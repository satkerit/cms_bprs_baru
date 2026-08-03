<?php

namespace App\Mail;

use App\Models\Career;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{name: string, email: string, phone: string, cover_letter: ?string, cv_name: string}  $data
     */
    public function __construct(
        public Career $career,
        public array $data,
        public string $cvPath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lamaran Pekerjaan: '.$this->career->title.' - '.$this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-application',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('local', $this->cvPath)
                ->as(basename($this->data['cv_name'])),
        ];
    }
}
