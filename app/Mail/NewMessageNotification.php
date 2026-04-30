<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $message;

    public function __construct(User $sender, Message $message)
    {
        $this->sender = $sender;
        $this->message = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Message from ' . $this->sender->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-message',
        );
    }
}