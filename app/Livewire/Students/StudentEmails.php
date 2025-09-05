<?php

namespace App\Livewire\Students;

use App\Enums\MilitaryRank;
use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FactObserved;
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

    public $showModalConfirm = false;
    public $loading = false;

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
    public function showConfirm()
    {
        if ($this->contacts->count() > 0) {
            $this->showModalConfirm = true;
        } else {
            $this->dispatch('openAlert', 'error', 'Nenhum contato cadastrado');
        }
    }

    public function sentEmail()
    {
        $this->showModalConfirm = false;
        $this->loading = true;
        $countMail = 0;
        $totalEmails = 0;

        if ($this->contacts->count() > 0) {
            foreach ($this->contacts as $contact) {
                $totalEmails++;
                $this->attachment = trim('ficha_individual_' . $this->student->number . '_' . $this->slug($this->student->nick) . '_' . Str::uuid() . '.pdf');

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
            if ($countMail > 0) {
                $al_nick          = $this->student->nick;
                $al_name          = $this->student->name;
                $al_number        = $this->student->number;
                $al_class         = $this->student->al_class->title;
                $cmt_cia_posto    = MilitaryRank::from(intval($this->student->al_class->classGrade->company->comandant->posto_grad))->label();
                $cmt_cia          = $this->student->al_class->classGrade->company->comandant->name;
                $cia              = $this->student->al_class->classGrade->company->name;
                $company_id       = $this->student->al_class->classGrade->company->id;

                $user = Auth::user();

                if ($user?->people) {
                    $fact_observer = MilitaryRank::from($user?->people?->posto_grad)->label() . ' ' . $user?->people?->nick;
                    $fact_observer_function = $user?->people?->function;
                    $fact_observer_id = $user?->people?->id;
                    FactObserved::create([
                        'active'    => 1,
                        'cia'                      => $cia,
                        'company_id'               => $company_id,
                        'cmt_cia_posto'            => $cmt_cia_posto,
                        'cmt_cia'                  => $cmt_cia,
                        'student_id'               => $this->student->id,
                        'al_nick'                  => $al_nick,
                        'al_name'                  => $al_name,
                        'al_number'                => $al_number,
                        'al_class'                 => $al_class,
                        'fact'                     => 'Foi enviado a ficha individual do aluno para os responsáveis.',
                        'fact_hour'                => date('h:i:s'),
                        'fact_date'                => date('d/m/Y'),
                        'fact_type'                => 'informativo',
                        // 'faults'                   => $faults,
                        'fact_observer'            => $fact_observer,
                        'fact_observer_function'   => $fact_observer_function,
                        'fact_observer_id'         => $fact_observer_id,
                        'code'      => Str::uuid(),
                    ]);
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
        $this->loading = false;
    }
    public function slug($name)
    {
        return mb_strtolower(str_replace(" ", "_", $name));
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
        $file = trim('ficha_individual_' . $this->student->number . '_' . $this->slug($this->student->nick) . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        return $file;
    }
}
