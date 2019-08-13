<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/19/2017
 * Time: 12:28 PM
 */

namespace App\Http\ViewComposers;

use App\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class TeamListComposer {

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$teamMembers = Team::where( 'status', '=', 1 )->orderBy(DB::raw('LENGTH(priority), priority'))->get();

		$view->with( 'teamMembers', $teamMembers );
	}
}