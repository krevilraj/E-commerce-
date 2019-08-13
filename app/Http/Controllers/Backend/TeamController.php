<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\TeamRequest;
use App\Repositories\Team\TeamRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller {
	/**
	 * @var TeamRepository
	 */
	private $team;

	public function __construct( TeamRepository $team ) {
		$this->team = $team;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$teamMembersCount = $this->team->getAll()->count();

		return view( 'backend.team.index', compact( 'teamMembersCount' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'backend.team.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param TeamRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( TeamRequest $request ) {
		try {

			$this->team->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving team meamber: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Team member successfully added!' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$team = $this->team->getById( $id );

		return view( 'backend.team.edit', compact( 'team' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function update( Request $request, $id ) {
		try {

			$this->team->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating team member: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Team member successfully updated!' );
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

			$this->team->delete( $id );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in deleting team member: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Team member successfully deleted!' );
	}

	public function getTeamJson( Request $request ) {
		$teams = $this->team->getAll();

		foreach ( $teams as $team ) {
			$team->author         = $team->user->full_name;
			$image                       = null !== $team->getImage() ? $team->getImage()->smallUrl : $team->getDefaultImage()->smallUrl;
			$team->featured_image = $image;
		}

		return datatables( $teams )->toJson();
	}
}
