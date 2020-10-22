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
    		'name' => 'ADMIN',
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
    	DB::table('setores')->insert([
    		'name' => 'ADMIN',
    		'carteira_id' => 1,
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
    	DB::table('ilhas')->insert([
    		'name' => 'ADMIN',
    		'setor_id' => 1,
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
		DB::table('cargos')->insert([
    		'description' => 'ADMIN',
    		'created_at' => now(),
    		'updated_at' => now()
    	]);
        //Cria Usuário
        $insert = new User();
        $insert->name = 'dev';
        $insert->matricula = '123450';
        $insert->username = 'userdev';
        $insert->password = Hash::make('secret');
        $insert->cpf = '12345678912';
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

        DB::table('book_materiais.tipos_materiais')->insert([
            [
                'name' => 'Comunicado',
                'created_at' => now(),
            ],
            [
                'name' => 'Roteiro',
                'created_at' => now(),
            ],
            [
                'name' => 'Material de Apoio',
                'created_at' => now(),
            ],
            [
                'name' => 'Videos',
                'created_at' => now(),
            ],
        ]);

    }
}
