<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Models\Fault\SecondCall;
use Livewire\Component;
use Livewire\Attributes\On;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;
use App\Models\Settings\Companies;
use App\Traits\HandlesTmpUploads;

//assinatura
use App\Models\Signatures\DocumentSigned;
use App\Traits\Signatures\PdfSignatureTrait;

use App\Enums\SignedDocumentStatus;
use App\Enums\DocumentType;

class SecondChance extends Component
{
    use WithPagination;
    use HandlesTmpUploads;
    //assinatura
    use PdfSignatureTrait;

    public $authorizations;
    public $school_faults;
    public $id;
    public $breadcrumb = 'Autorização de 2º chamada';

    public $number;
    public $discipline_call;
    public $signature;
    public $documentType;

    public bool $hasOfficialDocument = false;

    public function mount(SchoolFaults $school_faults)
    {
        $this->authorizations = $school_faults->secondCall;
        $this->school_faults = $school_faults;

        if ($school_faults->companies->id) {
            $company = Companies::find($school_faults->companies->id);
            $files = Storage::files('public/companies/' . $company->id . '/signature');
            if ($files) {
                $signature = explode('/', $files[0]);
                // dd($signature[4]);
                $this->signature = url('storage/companies/' . $company->id . '/signature/' . $signature[4]); // Nome do arquivo
            } else {
                $this->signature = false;
            }
        }

        $this->hasOfficialDocument = DocumentSigned::where([
            'document_model' => SchoolFaults::class,
            'document_id'    => $this->school_faults->id,
            'document_type' => DocumentType::SecondCallAuthorization,
        ])
            ->whereIn('status', [
                SignedDocumentStatus::Current,
                SignedDocumentStatus::Completed,
            ])
            ->exists();
    }
    public function render()
    {
        return view('livewire.faults.second-chance');
    }
    public function addAuthorization()
    {
        SecondCall::create([
            'active'                => 1,
            'school_faults_id'      => $this->school_faults->id,
            'code'                  => Str::uuid(),
        ]);
        $this->school_faults = $this->school_faults;
        $this->authorizations = $this->school_faults->secondCall;
    }

    public function removeAuthorization(SecondCall $second_call)
    {
        $second_call->active = 0;
        $second_call->save();
        $this->school_faults = $second_call->fault;
        $this->authorizations = $this->school_faults->secondCall;
    }

    public function printAuthorization(
        ?int $documentSignedId = null
    ) //Imprimir relação
    {
        $documentSigned = null;

        if ($documentSignedId) {
            $documentSigned = DocumentSigned::with([
                'signatures.signer.user',
            ])->find($documentSignedId);
        }
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos/brasao-brasil-preto-e-branco.png');

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 5,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);

        if ($documentSigned) {
            $html = view(
                'livewire.faults.second-chance-pdf',
                [
                    'logoPath'          => $logoPath,
                    'title'             => 'Autorizações de 2º chamada de AP',
                    'authorizations'    => $this->authorizations,
                    'config'            => $config,
                    'signature'         => $this->signature,
                    'responsible'       => Auth::user()->name,
                    'signatureStamp'    => $this->makeSignatureStamp($documentSigned),
                ]
            )->render();
        } else {
            $html = view(
                'livewire.faults.second-chance-pdf',
                [
                    'logoPath'          => $logoPath,
                    'title'             => 'Autorizações de 2º chamada de AP',
                    'authorizations'    => $this->authorizations,
                    'config'            => $config,
                    'signature'         => $this->signature,
                    'responsible'       => Auth::user()->name,
                    'signatureStamp'    => null,
                ]
            )->render();
        }


        $mpdf->SetHTMLFooter('
           <table width="100%">
               <tr>
                   <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
                   <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
               </tr>
           </table>');
        $mpdf->WriteHTML($html);
        /*
            |--------------------------------------------------------------------------
            | PDF oficial assinado
            |--------------------------------------------------------------------------
            */

        if ($documentSigned) {

            $this->appendSignatureBlock(
                $mpdf,
                $documentSigned
            );

            $file = sprintf(
                '%s_%s.pdf',
                class_basename($documentSigned->document_model),
                $documentSigned->uuid
            );

            $this->saveSignedPdf(
                $mpdf,
                $documentSigned,
                $file
            );

            return;
        }

        // Salve o PDF temporariamente
        $file = trim('segunda_chamada_ap_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $mpdf->Output(
            $down,
            \Mpdf\Output\Destination::FILE
        );

        $this->dispatch(
            'openPdfSecond',
            pdfPath: $pdfPath
        );
    }

    /**
     * Gera o carimbo de assinatura digital para ser exibido
     * dentro de uma seção específica do documento.
     */
    protected function makeSignatureStamp(
        DocumentSigned $document
    ): string {

        $document->loadMissing([
            'signatures.signer.user',
        ]);

        return view(
            'components.pdf.signatures.signature-stamp',
            [
                'document' => $document,
                'authenticationBlock' => $this->generateQrCode($document),
            ]
        )->render();
    }

    #[On('document-signed')]
    public function generateOfficialPdf(int $documentSignedId): void
    {
        $documentSigned = DocumentSigned::with([
            'signatures.signer.user',
        ])->find($documentSignedId);

        if (!$documentSigned) {
            $this->openAlert(
                'error',
                'Documento assinado não encontrado.'
            );
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Gera novamente o PDF já contendo o bloco de assinaturas.
        |--------------------------------------------------------------------------
        */

        $this->printAuthorization($documentSigned->id);
        $this->dispatch('official-document-generated');
    }
}
