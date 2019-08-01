<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class UsersToRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $correos = array(
			'jd@research.dev',
			'erik.r@research.dev',
      	);

        $usuarios = User::whereIn('email', $correos)->get();

        foreach ($usuarios as $key => $usuario) {

            $usuario->syncRoles('root-admin');

        }
    }
}
