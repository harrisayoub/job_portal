<?php
/**
 * Career Enterprise - Geolocalized Job Platform

 *
 * Website: https://www.CareerEnterprise.com
 *

 * -------




 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserActivated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->to($user->email, $user->name);
        $this->subject(trans('mail.user_activated_title', ['appName' => config('app.name'), 'userName' => $user->name]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user.activated');
    }
}
