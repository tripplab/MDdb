<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user_roles = [
            ['name' => 'Admin', 'description' => 'The super-admin role.'],
        ];

        foreach ($user_roles as $ut) {
            $user_role = new Role();
            $user_role->name = $ut['name'];
            $user_role->description = $ut['description'];
            $user_role->save();
        }

        $users = [
            [
                'name' => 'Testing',
                'lastname' => 'Concéntrico',
                'username' => 'dev',
                'email' => 'dev@concentrico.com.mx',
                'user_role_id' => [1],
                'pwd' => Hash::make('secret'),
            ],
            [
                'name' => 'Homero',
                'lastname' => 'Marín',
                'username' => 'hmarin',
                'email' => 'hmarin@concentrico.com.mx',
                'user_role_id' => [1],
                'pwd' => Hash::make('secret'),
            ],
        ];

        foreach ($users as $key => $u) {
            $user = new User();
            $user->name = $u['name'].' '.$u['lastname'];
            $user->email = $u['email'];
            $user->username = $u['username'];
            $user->password = $u['pwd'];
            $user->remember_token = str_random(10);

            $user->save();
            foreach ($u['user_role_id'] as $rol) {
                $user->hasRoles()->attach($rol);
            }
        }
    }
}
