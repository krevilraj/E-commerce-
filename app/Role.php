<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	/**
	 * The users that belong to the role.
	 */
	public function users()
	{
		return $this->belongsToMany(User::class);
	}
}
