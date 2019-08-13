<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\MailRequest;
use App\Http\Controllers\Controller;
use App\Mail\Message;
use App\Mail\QuickMail;
use Mail;

class MailController extends Controller {
	public function sendMail( MailRequest $request ) {


        Mail::to($request->email)->send(new Message($request->all()));

		return redirect()->back()->with( 'success', 'Email successfully sent!!' );
	}
}
