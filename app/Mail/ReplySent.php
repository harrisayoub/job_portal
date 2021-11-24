<?php
/**
 

 *

 *

 * -------




 */

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplySent extends Mailable
{
    use Queueable, SerializesModels;

    public $msg; // CAUTION: Conflict between the Model Message $message and the Laravel Mail Message objects

    /**
     * Create a new message instance.
     *
	 * @param Message $msg
	 */
    public function __construct(Message $msg)
    {
        $this->msg = $msg;

        $this->to($msg->to_email, $msg->to_name);
        $this->replyTo($msg->from_email, $msg->from_name);
        $this->subject($msg->subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.post.reply-sent');
    }
}
