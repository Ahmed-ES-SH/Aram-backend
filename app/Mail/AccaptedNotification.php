<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccaptedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $bookingDetails;
    public $organizationEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $bookingDetails, $organizationEmail)
    {
        $this->userName = $userName;
        $this->bookingDetails = $bookingDetails;
        $this->organizationEmail = $organizationEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('accapted_mail') // عرض الـ View
            ->subject('Reservation Approved') // موضوع البريد
            ->from(env('MAIL_FROM_ADDRESS'), 'Aram') // تحديد مرسل البريد
            ->with([
                'userName' => $this->userName, // تمرير اسم المستخدم
                'bookingDetails' => $this->bookingDetails, // تمرير تفاصيل الحجز
            ]);
    }
}
