<?php

use App\Permission;
use App\Role;
use Faker\Factory as Faker;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'users' )->delete();
		DB::table( 'roles' )->delete();
		DB::table( 'permissions' )->delete();
		DB::table( 'role_user' )->delete();
		DB::table( 'permission_role' )->delete();

		$faker = Faker::create( 'en_US' );
		$limit = 25;

		/*
		 * Base User Accounts
		 */

		// Super Admin (User)
		$adminU = User::create( [
			'first_name' => 'John',
			'last_name'  => 'Doe',
			'email'      => 'johndoe@gmail.com',
			'phone'      => '98xxxxxxxx',
			'password'   => bcrypt( 'password' ),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		] );

		// Admin (User)
		$managerU = User::create( [
			'first_name' => 'Jane',
			'last_name'  => 'Doe',
			'email'      => 'jane@gmail.com',
			'phone'      => '98xxxxxxxx',
			'password'   => bcrypt( 'password' ),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		] );

		// Admin (Role)
		$adminR = Role::create( [
			'name'         => 'admin',
			'display_name' => 'Admin',
			'description'  => 'User is the admin of the system',
			'created_at'   => Carbon::now(),
			'updated_at'   => Carbon::now()
		] );

		// Admin (Role)
		$managerR = Role::create( [
			'name'         => 'manager',
			'display_name' => 'Manager',
			'description'  => 'User is the manager of the system',
			'created_at'   => Carbon::now(),
			'updated_at'   => Carbon::now()
		] );

		$createPost               = new Permission();
		$createPost->name         = 'create-post';
		$createPost->display_name = 'Create Posts'; // optional Allow a user to...
		$createPost->description  = 'Create new blog Post'; // optional $createPost->save();
		$createPost->created_at   = Carbon::now();
		$createPost->updated_at   = Carbon::now();
		$createPost->save();

		$editManager               = new Permission();
		$editManager->name         = 'edit-manager';
		$editManager->display_name = 'Edit Managers'; // optional Allow a user to...
		$editManager->description  = 'Edit existing Manager'; // optional
		$editManager->created_at   = Carbon::now();
		$editManager->updated_at   = Carbon::now();
		$editManager->save();

		$adminU->attachRole( $adminR );
		$managerU->attachRole( $managerR );

		$adminR->attachPermission( $createPost );
		$adminR->attachPermission( $editManager );

		$managerR->attachPermission( $createPost );

		/*
		 * Dummy User accounts
		 */
		for ( $i = 0; $i < $limit; $i ++ ) {
			User::create( [
				'first_name' => $faker->firstName,
				'last_name'  => $faker->lastName,
				'email'      => $faker->unique()->email,
				'phone'      => $faker->phoneNumber,
				'password'   => bcrypt( 'password' ),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			] );

		}
	}
}
