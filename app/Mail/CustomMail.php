<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;
    public $subject;
    public $message;
    public $attachments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fromEmail, $subject, $message, $attachments = [])
    {
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
        $this->message = $message;
        $this->attachments = $attachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->fromEmail)
                     ->subject($this->subject)
                     ->view('emails.custom')
                     ->with(['messageContent' => $this->message]);

        // Handle attachments
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                if ($attachment instanceof UploadedFile) {
                    $mail->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                    ]);
                }
            }
        }

        return $mail;
    }
}
