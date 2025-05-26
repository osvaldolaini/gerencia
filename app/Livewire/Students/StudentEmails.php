<?php

namespace App\Livewire\Students;

use App\Models\Admin\Settings\Settings;
use App\Models\Emails;
use App\Models\Peoples;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentEmails extends Component
{
    public $emails;
    public $contacts;
    public $student;
    public $attachment;

    public function mount(Peoples $student)
    {
        $this->student  =  $student;
        $this->emails   = $this->student->emails->sortByDesc('created_at');
        $this->contacts =  $student->contacts;
    }

    public function render()
    {
        $this->emails   = $this->student->emails->sortByDesc('created_at');
        return view('livewire.students.student-emails');
    }

    public function sentEmail()
    {
        $countMail = 0;
        $totalEmails = $this->contacts->count();
        if ($this->contacts->count() > 0) {
            foreach ($this->contacts as $contact) {

                $this->attachment = trim('ficha_individual_' . $this->student->number . '_' . $this->student->nick . '_' . Str::uuid() . '.pdf');

                if ($contact->type == 'email') {
                    if (filter_var($contact->contact, FILTER_VALIDATE_EMAIL)) {
                        $send = Mail::send(
                            new \App\Mail\StudentRecordNew([
                                'contact' => $contact,
                                'attachment' => $this->downloadTmp(),
                                'company' => $this->student->company
                            ])
                        );
                        if ($send) {
                            $countMail++;
                            Emails::create([
                                'status' => 1,
                                'student_contacts_id' => $contact->id,
                                'student_id' => $this->student->id,
                                'to' => $contact->contact,
                                'subject' => 'Ficha individual',
                                'message' => 'Encaminho',
                                'attachment' => $this->downloadTmp(),
                                'code'      => Str::uuid(),
                            ]);
                        }
                    }
                }
            }

            $error = $totalEmails - $countMail;
            Log::info('Enviados ' . $countMail . ' fichas do(a) aluno(a)');
            $this->openAlert('success', $countMail . ' email(s) enviados com sucesso.');
            if ($error > 0) {
                $this->openAlert('error', $error . ' email(s) não foram por erro no cadastro ou falta de email.');
            }
        } else {
            $this->dispatch('openAlertModal', 'error', 'Nenhum contato cadastrado');
        }
        $this->emails   = $this->student->emails->sortByDesc('created_at');
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
        $this->dispatch('openAlertModal', $status, $msg);
        $this->dispatch('closeModal');
    }
    //Turmas
    public function downloadTmp()
    {
        $config = Settings::find(1);
        $company = $this->student?->al_class?->classGrade?->getCompany ?? false;
        $signature = false;
        if ($company) {
            $logoPath = Storage::exists('public/companies/' . $company->id)
                ? url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png')
                : url('storage/logos-school/logo-header.png');

            $files = Storage::files('public/companies/' . $company->id . '/signature/small');
            if ($files) {
                $sign = explode('/', $files[0]);
                // dd($signature[4]);
                $signature = url('storage/companies/' . $company->id . '/signature/small/' . $sign[5]); // Nome do arquivo
            } else {
                $signature = false;
            }
        } else {
            $logoPath = url('storage/logos-school/logo-header.png');
        }


        $studentImage = Storage::exists('public/student/' . $this->student->id)
            ? url('storage/student/' . $this->student->id . '/' . $this->student->code_image . '_list.png')
            : $logoPath;

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.settings.pdf.student-history-pdf',
            [
                'logoPath'          => $logoPath,
                'studentImage'      => $studentImage,
                'signature'         => $signature,
                'student'           => $this->student,
                'config'            => $config,
                'companies'         => $this->student->company,
                'subtext'           => 'Aluno da ' . ($this->student->company ? $this->student->company->nick : ''),
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
            <table width="100%">
                <tr >
                    <td width="50%">
                        <img width="50" src="' . $logoPath . '" alt="Logo">
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>' . $config->name . '</strong><br>
                        ' . ($this->student->company ? $this->student->company->name : '') . '<br>
                    </td>
                </tr>
            </table>
            ');
        $mpdf->SetHTMLFooter('
     <table width="100%">
         <tr>
             <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
             <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
         </tr>
     </table>');
        $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        $file = trim('ficha_individual_' . $this->student->number . '_' . $this->student->nick . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        return $file;
    }
}
