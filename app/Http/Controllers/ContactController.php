<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestProduct;
use App\Contact;
use Mail;
use App\Mail\User;



class ContactController extends Controller
{
    public function contact(){
        return View ('pages.templates.contact');

    }
    public function testimional(){
        return View ('pages.templates.request-new-product');

    }
    public function  contactAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',

        ]);

        $newRequest = new Contact();
        $newRequest->name = $request['name'];
        $newRequest->email = $request['email'];
        $newRequest->subject = $request['subject'];
        $newRequest->message = $request['message'];
        $newRequest->phone= $request['phone'];

        $newRequest->save();
 $data = [

            'name'=>$request['name'],

            'email'=>$request['email'],
            'subject'=>$request['subject'],
            'message'=>$request['message'],
        
            'phone'=>$request['phone'],



        ];

        Mail::to($request['email'])->send(new \App\Mail\UserMessage($data));

    }



    public function  NewRequestAdd(Request $request){


        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',

        ]);
        $newRequest=new RequestProduct();
        $newRequest->name=$request['name'];
        $newRequest->email=$request['email'];
        $newRequest->subject=$request['subject'];
        $newRequest->message=$request['message'];
        $newRequest->link=$request['link'];
        $newRequest->application=$request['application'];
        $newRequest->phone=$request['phone'];
        $newRequest->save();

        $data = [

            'name'=>$request['name'],

            'email'=>$request['email'],
            'subject'=>$request['subject'],
            'message'=>$request['message'],
            'link'=>$request['link'],
            'application'=>$request['application'],
            'phone'=>$request['phone'],



        ];
        
               Mail::to($request['email'])->send(new \App\Mail\UserRequest($data));

               Mail::to(getConfiguration('order_email'))->send(new \App\Mail\Request($data));



return response()->json( [
			'status'  => 'success',
			'message' => 'Message'
		], 200 );
    }




}
