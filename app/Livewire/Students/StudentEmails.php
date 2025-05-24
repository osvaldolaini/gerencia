<?php

namespace App\Livewire\Students;

use App\Models\Emails;
use App\Models\Peoples;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $this->emails   =  $student->emails;
        $this->contacts =  $student->contacts;
        $this->attachment = trim('ficha_individual_' . $this->student->number . '_' . $this->student->nick . '_' . Str::uuid() . '.pdf');
    }
    public function render()
    {
        return view('livewire.students.student-emails');
    }
    public function sentEmail()
    {

        $countMail = 0;
        $totalEmails = $this->contacts->count();
        if ($this->contacts->count() > 0) {
            foreach ($this->contacts as $contact) {
                if ($contact->type == 'email') {
                    if (filter_var($contact->contact, FILTER_VALIDATE_EMAIL)) {
                        $send = Mail::send(
                            new \App\Mail\StudentRecordNew([
                                'contact' => $contact,
                                'attachment' => $this->attachment,
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
                                'attachment' => $this->attachment,
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
        }
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
        $this->dispatch('closeModal');
    }
}
