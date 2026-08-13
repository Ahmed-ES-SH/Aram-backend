<?php

namespace App\Modules\Content\Mail;

use App\Modules\Content\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function build()
    {
        return $this->subject($this->newsletter->subject)
            ->view('emails.newsletter');
    }
}
