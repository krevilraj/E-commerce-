<?php
$email=':email';

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
  'verified' => "Your Email is not Verified,Please Check Your Email, click <a href='/resendmail/$email'>here</a> 
                            Resend Mail",
                           
  'active' => 'Your Account is pending for Approval !!!',

];
