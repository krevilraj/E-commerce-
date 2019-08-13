<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\User;
use Mail;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Where to redirect users after logout.
	 *
	 * @var string
	 */
	protected $redirectAfterLogout = '/login';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'guest' )->except( 'logout' );
	}





	/**
	 * Redirect the user to the social provider authentication page.
	 *
	 * @param $provider
	 *
	 * @return mixed
	 */
	public function redirectToProvider( $provider ) {
		return Socialite::driver( $provider )->redirect();
	}

	/**
	 * Obtain the user information from social provider.
	 *
	 * @param $provider
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function handleProviderCallback( $provider ) {
		try {
			if ( $provider != 'facebook' ) {
				$user = Socialite::driver( $provider )->user();
			} else {
				$user = Socialite::driver( $provider )->fields(
					[
						'id',
						'name',
						'first_name',
						'last_name',
						'email',
					]
				)->user();
			}

		} catch ( Exception $e ) {
			return redirect()->to( '/login' );
		}

		$authUser = $this->findOrCreateUser( $user, $provider );
if ($authUser->verified != 1){
            return redirect()->to( 'vertification' );

        }
        elseif ($authUser->active != 1)

        {
            return redirect()->to( 'pending' );

        }
        else
		auth()->login( $authUser, true );

		return redirect()->to( $this->redirectTo );
	}

	private function findOrCreateUser( $socialLiteUser, $key ) {
		$email = $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'];

		if ( $authUser = User::where( 'email', $email )->first() ) {
			return $authUser;
		}
        

		return User::create( [
			'first_name'  => $key != 'facebook' ? $socialLiteUser->user['name']['givenName'] : $socialLiteUser->user['first_name'],
			'last_name'   => $key != 'facebook' ? $socialLiteUser->user['name']['familyName'] : $socialLiteUser->user['last_name'],
			'email'       => $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'],
			'password'    => bcrypt( str_random( 10 ) ),
			'provider'    => $key,
			           'email_token' => base64_encode($key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email']),
                         'verified'=>'1',
			'provider_id' => $key != 'facebook' ? $socialLiteUser->id : $socialLiteUser->user['id'],
		] );
      
	}
}
