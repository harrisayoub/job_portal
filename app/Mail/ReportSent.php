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
use App\Models\Post;

class ReportSent extends Mailable
{
	use Queueable, SerializesModels;
	
	public $post;
	public $report;
	
	/**
	 * Create a new message instance.
	 *
	 * @param Post $post
	 * @param $report
	 * @param $recipient
	 */
	public function __construct(Post $post, $report, $recipient)
	{
		$this->post = $post;
		$this->report = $report;
		
		$this->to($recipient->email, $recipient->name);
		$this->replyTo($this->report->email, $this->report->email);
		$this->subject(trans('mail.post_report_sent_title', [
			'appName'     => config('app.name'),
			'countryCode' => $post->country_code,
		]));
	}
	
	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.post.report-sent');
	}
}
