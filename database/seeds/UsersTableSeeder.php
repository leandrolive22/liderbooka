<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('carteiras')->insert([
    		'id' => NULL,
    		'name' => 'ADMIN',
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
    	DB::table('setores')->insert([
    		'id' => NULL,
    		'name' => 'ADMIN',
    		'carteira_id' => 1,
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
    	DB::table('ilhas')->insert([
    		'id' => NULL,
    		'name' => 'ADMIN',
    		'setor_id' => 1,
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
		DB::table('cargos')->insert([
    		'id' => NULL,
    		'description' => 'ADMIN',
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
        //Cria Usuário
        $insert = new User();
        $insert->name = 'ADMIN';
        $insert->matricula = '123456';
        $insert->username = 'userteste';
        $insert->password = Hash::make('secret');
        $insert->cpf = '12345678910';
        $insert->cargo_id = '1';
        $insert->ilha_id = '1';
        $insert->carteira_id = '1';
        $insert->supervisor_id = NULL;
        $insert->coordenador_id = NULL;
        $insert->gerente_id = NULL;
        $insert->superintendente_id = NULL;
        $insert->another_config;
        $insert->save();

        DB::table('permissions')->insert([
        	'name' => 'webMaster',
        	'created_at' => now(),
    		'updated_at' => now()
        ]);

        DB::table('user_permissions')->insert([
        	'user_id' => 1,
        	'permission_id' => 1,
        	'created_at' => now(),
    		'updated_at' => now()
        ]);

    }
}
