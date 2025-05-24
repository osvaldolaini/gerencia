<?php

namespace App\Mail;

use App\Models\Admin\Settings\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $config = Settings::find(1);
        return new Envelope(
            from: new Address($this->data['company']->email, $config->name),
            to: [
                new Address($this->data['contact']->contact, $this->data['contact']->parent),
            ],
            subject: 'Ficha individual',
            tags: [$config->nick],
        );
    }

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
        // return [url('storage/pdf-tmp/' . $this->data['attachment'])];
        return [];
    }
}
