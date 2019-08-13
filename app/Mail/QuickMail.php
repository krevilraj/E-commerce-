<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuickMail extends Mailable {
	use Queueable, SerializesModels;
	/**
	 * @var
	 */
	public $attributes;

	/**
	 * Create a new message instance.
	 *
	 * @param $attributes
	 */
	public function __construct(  ) {

	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(Request $request) {
		return $this->view( 'emails.quick' ,['msg'=>$request->message])->to($request->email)->from('info@himalayansolution.com');
	}
}
