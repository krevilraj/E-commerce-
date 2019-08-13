<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use App\Role;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class UserController extends Controller {

	/**
	 * @var UserRepository
	 */
	private $user;

	public function __construct( UserRepository $user ) {
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$usersCount = \request()->has( 'role' ) && \request( 'role' ) != 'client' ? $this->user->getByRole( \request( 'role' ) ) : $this->user->getVisitors();

		return view( 'backend.users.index' )
			->with( [ 'usersCount' => count( $usersCount ) ] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$roles = array( '' => 'Select Role' ) + Role::pluck( 'display_name', 'id' )->toArray() + array( '0' => 'Visitor' );

		return view( 'backend.users.create', compact( 'roles' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param UserRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( UserRequest $request ) {
		try {

			$this->user->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving user: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'User successfully created!!' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		$user = $this->user->getById( $id );

		return view( 'backend.users.show', compact( 'user' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$user       = $this->user->getById( $id );
		$activeRole = $user->roles->first();

		if ( ! auth()->user()->hasRole( 'admin' ) ) {
			$roles = Role::whereNotIn( 'name', [ 'admin' ] )->pluck( 'display_name', 'id' )->toArray();
		} else {
			$roles = Role::pluck( 'display_name', 'id' )->toArray();
		}

		return view( 'backend.users.edit', compact( 'user', 'activeRole', 'roles' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UserRequest|Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function update( UserRequest $request, $id ) {
		try {

			$this->user->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating user: ' . $e->getMessage() );
		}
if($request->active ==1){
 $data2 = [

            'name'=>$request['first_name'] ,
          
        ];

                Mail::to($request['email'])->send(new  \App\Mail\Welcome($data2));



}


		return redirect()->back()->with( 'success', 'User successfully updated!!' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function destroy( $id ) {
		try {

			$this->user->delete( $id );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in deleting user: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'User successfully deleted!' );
	}

	public function getUsersJson( Request $request ) {

		switch ( $request->input( 'role' ) ) {
			case 'admin':
				$users = $this->user->getByRole( $request->input( 'role' ) );
				break;
			case 'manager':
				$users = $this->user->getByRole( $request->input( 'role' ) );
				break;
            case 'shop-manager':
                $users = $this->user->getByRole( $request->input( 'role' ) );
                break;
//            case 'client':
//                $users = $this->user->getByRole( $request->input( 'role' ) );
//                break;
			case 'visitor':
				$users = $this->user->getVisitors();
				break;
case 'non-active':
                $users = $this->user->getNonActive();
                break;
			default:
				$users = $this->user->getAll();
		}

		foreach ( $users as $user ) {
			$user->name   = $user->full_name;
			$user->avatar = null !== $user->getImage() ? $user->getImage()->smallUrl : $user->getDefaultImage()->smallUrl;
			$user->role   = optional( $user->roles->first() )->display_name;
		}

		return datatables( $users )->toJson();
	}

	public function searchUser( Request $request ) {
		$term = trim( $request->input( 'q' ) );
		if ( empty( $term ) ) {
			return response()->json( [], 200 );
		}

		$users = DB::table( 'users' )->where( 'first_name', 'like', '%' . $term . '%' )->orderBy( 'first_name' )->take( 15 )->get();

		$formattedUsers = [];

		foreach ( $users as $user ) {
			$formattedUsers[] = [ 'id' => $user->id, 'text' => $user->first_name . ' ' . $user->last_name ];
		}

		return response()->json( $formattedUsers, 200 );

	}
}
