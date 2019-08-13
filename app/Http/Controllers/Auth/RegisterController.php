<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Mail\EmailVerification;
use App\Mail\Welcome;
use App\User;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/vertification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration Request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|min:10',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'verified' => '0',
            'password' => bcrypt($data['password']),
            'email_token' => base64_encode($data['email'])
        ]);


        return $user;

    }

    public function register(Request $request)
    {
//        $this->validator($request->all())->validate();
//        event(new Registered($user = $this->create($request->all())));
//        dispatch(new SendVerificationEmail($user));
//        return view('vertification');

        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));


        $data = [
            'email_token' => $user->email_token


        ];

        Mail::to($request->email)->send(new EmailVerification($data));

        return view('vertification');
    }

    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();

        $user->verified = '1';
        $data2 = [

            'name' => $user->first_name
        ];
        if ($user->save()) {

            Mail::to($user->email)->send(new Welcome($data2));

            return view('emailconfirm', ['user' => $user]);
        }


    }
}

