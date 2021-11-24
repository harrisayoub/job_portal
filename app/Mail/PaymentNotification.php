<?php
/**
 

 *

 *

 * -------




 */

namespace App\Mail;

use App\Models\Package;
use App\Models\PaymentMethod;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $post;
	public $package;
	public $paymentMethod;

    /**
     * PaymentNotification constructor.
     * @param $payment
     * @param $post
     * @param $adminUser
     */
    public function __construct($payment, $post, $adminUser)
    {
        $this->payment = $payment;
        $this->post = $post;
		$this->package = Package::findTrans($payment->package_id);
		$this->paymentMethod = PaymentMethod::find($payment->payment_method_id);

        $this->to($adminUser->email, $adminUser->name);
        $this->subject(trans('mail.payment_notification_title'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment.notification');
    }
}
