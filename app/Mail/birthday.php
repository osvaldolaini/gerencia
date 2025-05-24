<?php

namespace App\Mail;

use App\Models\Admin\Settings\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentRecord extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $partner;
    // public $partner;
    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly array $data
    ) {
        $this->partner = $data['partner'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $config = Settings::find(1);
        return new Envelope(
            from: new Address($config->email, $config->title),
            to: [
                new Address($this->data['partner']->email, $this->data['partner']->name),
            ],
            subject: 'Feliz Aniversário',
            tags: ['assgapa'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'livewire.admin.marketing.birthday',
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
        return [];
    }
}
