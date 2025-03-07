<?php
// app/Mail/PaymentSuccessNotification.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $organizationName;
    public $bookingDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($organizationName, $bookingDetails)
    {
        $this->organizationName = $organizationName;
        $this->bookingDetails = $bookingDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('payment_success') // عرض الـ View
            ->subject('Payment Success')
            ->from(env('MAIL_FROM_ADDRESS'), 'Aram');
    }
}
