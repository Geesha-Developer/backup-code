<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageContent;
    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $messageContent, $attachments = [])
    {
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->attachments = $attachments;
    }

    /**
     * Build the message.
     */
// In your InvoiceMail Mailable class
    public function build()
    {
        $mail = $this->subject($this->subject)
            ->view('emails.invoice')
            ->with([
                'message' => $this->messageContent,
            ]);

        foreach ($this->attachments as $filePath) {
            $mail->attach($filePath); // Attaching the file paths
        }

        return $mail;
    }

}
