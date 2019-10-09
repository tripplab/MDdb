<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
			[
				'name' => 'Juan D.',
				'lastname' => 'Carrillo',
				'email' => 'jd@research.dev',
				'pwd' => Hash::make('random'),
			],
			[
				'name' => 'Erik R.',
				'lastname' => 'Munoz',
				'email' => 'erik.r@research.dev',
				'pwd' => Hash::make('dlagarza'),
			],
      	);

		foreach($users as $key => $u) {
			$user = new User;
			$user->name = $u['name'].' '.$u['lastname'];
			$user->email = $u['email'];
			$user->password = $u['pwd'];

			$user->save();

		}  // End of users iterator
    }
}
