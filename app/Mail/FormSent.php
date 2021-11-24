<?php
/**
 

 *

 *

 * -------




 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSent extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;

    /**
     * Create a new message instance.
     *
     * @param $request
     * @param $recipient
     */
    public function __construct($request, $recipient)
    {
        $this->msg = $request;

		$this->to($recipient->email, $recipient->name);
        $this->replyTo($request->email, $request->first_name . ' ' . $request->last_name);
        $this->subject(trans('mail.contact_form_title', [
            'country'  => $request->country_name,
            'appName'  => config('app.name')
        ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.form');
    }
}
