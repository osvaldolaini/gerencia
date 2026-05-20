<?php

namespace App\Mail;

use App\Models\Admin\Settings\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class StudentRecordNew extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $attachment;
    public $company;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly array $data
    ) {
        $this->contact = $data['contact'];
        $this->attachment = $data['attachment'];
        $this->company = $data['company'];


        /**
         * CONFIGURA SMTP DINAMICAMENTE
         * Dados vindos da empresa/setor
         */
        Config::set('mail.default', 'smtp');

        Config::set('mail.mailers.smtp.transport', 'smtp');

        Config::set('mail.mailers.smtp.host', $this->company->mail_host);
        Config::set('mail.mailers.smtp.port', $this->company->mail_port);

        Config::set('mail.mailers.smtp.username', $this->company->mail_username);
        Config::set('mail.mailers.smtp.password', $this->company->mail_password);

        Config::set('mail.mailers.smtp.encryption', $this->company->mail_encryption);

        Config::set('mail.from.address', $this->company->mail_from_address);
        Config::set('mail.from.name', $this->company->mail_from_name);

        /**
         * LIMPA CONEXÕES ANTIGAS
         */
        Mail::purge();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $config = Settings::find(1);

        return new Envelope(
            from: new Address(
                $this->company->mail_from_address,
                $this->company->mail_from_name . ' - ' . $config->nick
            ),

            to: [
                new Address(
                    $this->contact->contact,
                    $this->contact->parent
                ),
            ],

            subject: 'Ficha individual',

            tags: [
                $config->nick
            ],
        );
    }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'livewire.students.student-record',

    //         with: [
    //             'config' => Settings::find(1),
    //             'company' => $this->company,
    //             'contact' => $this->contact,
    //         ],
    //     );
    // }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'livewire.students.student-record',
            with: [
                'config' => Settings::find(1),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // dd(storage_path('app/pdf-tmp/' . $this->data['attachment']));
        return [
            Attachment::fromPath(url('storage/pdf-tmp/' . $this->data['attachment']))
                ->as($this->data['attachment'])
                ->withMime('application/pdf')
        ];
    }
}
