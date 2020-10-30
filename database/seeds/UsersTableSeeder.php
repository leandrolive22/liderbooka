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

        DB::table('permissions')->insert([
            ["id" =>"1", "name" => "WebMaster","created_at" => now(), "updated_at" => now()],
            ["id" =>"2", "name" => "Calculadoras: Ver Carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"3", "name" => "Calculadoras: Ver Empresa","created_at" => now(), "updated_at" => now()],
            ["id" =>"4", "name" => "Calculadoras: Ver Equipe/Ilha","created_at" => now(), "updated_at" => now()],
            ["id" =>"5", "name" => "Calculadoras: Ver Setor","created_at" => now(), "updated_at" => now()],
            ["id" =>"6", "name" => "Chat: Criar Grupos","created_at" => now(), "updated_at" => now()],
            ["id" =>"7", "name" => "Chat: Deletar Grupos","created_at" => now(), "updated_at" => now()],
            ["id" =>"8", "name" => "Chat: Ver Carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"9", "name" => "Chat: Ver Empresa","created_at" => now(), "updated_at" => now()],
            ["id" =>"10", "name" => "Chat: Ver Equipe/Ilha","created_at" => now(), "updated_at" => now()],
            ["id" =>"11", "name" => "Chat: Ver Setor","created_at" => now(), "updated_at" => now()],
            ["id" =>"12", "name" => "Clima: Grafico","created_at" => now(), "updated_at" => now()],
            ["id" =>"13", "name" => "Medidas Disciplinares: Abrir","created_at" => now(), "updated_at" => now()],
            ["id" =>"14", "name" => "Medidas Disciplinares: Aplicar","created_at" => now(), "updated_at" => now()],
            ["id" =>"15", "name" => "Medidas Disciplinares: Criar","created_at" => now(), "updated_at" => now()],
            ["id" =>"16", "name" => "Modulos: FormTransfer","created_at" => now(), "updated_at" => now()],
            ["id" =>"17", "name" => "Modulos: LiderReport","created_at" => now(), "updated_at" => now()],
            ["id" =>"18", "name" => "Monitora: Criar Laudos","created_at" => now(), "updated_at" => now()],
            ["id" =>"19", "name" => "Monitoria: Aplicar Feedback","created_at" => now(), "updated_at" => now()],
            ["id" =>"20", "name" => "Monitoria: Consideracoes (Operador)","created_at" => now(), "updated_at" => now()],
            ["id" =>"21", "name" => "Monitoria: Contestar","created_at" => now(), "updated_at" => now()],
            ["id" =>"22", "name" => "Monitoria: Excluir Laudos","created_at" => now(), "updated_at" => now()],
            ["id" =>"23", "name" => "Monitoria: Ver Carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"24", "name" => "Monitoria: Ver todas","created_at" => now(), "updated_at" => now()],
            ["id" =>"25", "name" => "Monitoria: Visualizar Monitorias (Monitor)","created_at" => now(), "updated_at" => now()],
            ["id" =>"26", "name" => "Post: Publicar","created_at" => now(), "updated_at" => now()],
            ["id" =>"27", "name" => "Post: Ver Carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"28", "name" => "Post: Ver Ilha","created_at" => now(), "updated_at" => now()],
            ["id" =>"29", "name" => "Posts: Excluir","created_at" => now(), "updated_at" => now()],
            ["id" =>"30", "name" => "Posts: Relatorio","created_at" => now(), "updated_at" => now()],
            ["id" =>"31", "name" => "Quiz: Criar Conteudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"32", "name" => "Quiz: Excluir","created_at" => now(), "updated_at" => now()],
            ["id" =>"33", "name" => "Quiz: Exportar","created_at" => now(), "updated_at" => now()],
            ["id" =>"34", "name" => "Usuario: Criar","created_at" => now(), "updated_at" => now()],
            ["id" =>"35", "name" => "Usuario: Editar","created_at" => now(), "updated_at" => now()],
            ["id" =>"36", "name" => "Usuario: Excluir","created_at" => now(), "updated_at" => now()],
            ["id" =>"37", "name" => "Usuario: Restaurar","created_at" => now(), "updated_at" => now()],
            ["id" =>"38", "name" => "Wiki: Criar Conteudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"39", "name" => "Wiki: Editar Conteudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"40", "name" => "Wiki: Excluir Conteudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"41", "name" => "Wiki: Relatorios","created_at" => now(), "updated_at" => now()],
            ["id" =>"42", "name" => "Wiki: Ver por Carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"43", "name" => "Wiki: Ver Conteudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"44", "name" => "Wiki: Ver todos os conteudos","created_at" => now(), "updated_at" => now()],
            ["id" =>"45", "name" => "Usuario: Permissoes","created_at" => now(), "updated_at" => now()],
            ["id" =>"46", "name" => "Quiz: Ver","created_at" => now(), "updated_at" => now()],
            ["id" =>"47", "name" => "Monitoria: Dash","created_at" => now(), "updated_at" => now()],
            ["id" =>"50", "name" => "Monitoria: Aplicar Laudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"51", "name" => "Monitoria: Exportar","created_at" => now(), "updated_at" => now()],
            ["id" =>"52", "name" => "Monitoria: Visualizar Monitorias (Supervisor)","created_at" => now(), "updated_at" => now()],
            ["id" =>"53", "name" => "Monitoria: Editar Laudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"54", "name" => "Monitoria: Editar Monitoria","created_at" => now(), "updated_at" => now()],
            ["id" =>"55", "name" => "Monitoria: Excluir Monitoria","created_at" => now(), "updated_at" => now()],
            ["id" =>"56", "name" => "Wiki: Ver Por Ilha","created_at" => now(), "updated_at" => now()],
            ["id" =>"57", "name" => "Areas: Gerenciar setor","created_at" => now(), "updated_at" => now()],
            ["id" =>"58", "name" => "Areas: Gerenciar carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"59", "name" => "Areas: Gerenciar carteira","created_at" => now(), "updated_at" => now()],
            ["id" =>"60", "name" => "Areas: Gerenciar setor","created_at" => now(), "updated_at" => now()],
            ["id" =>"61", "name" => "Monitoria: Ver todas (Somente alta Gerência)","created_at" => now(), "updated_at" => now()],
            ["id" =>"62", "name" => "Post: Ver tudo","created_at" => now(), "updated_at" => now()],
            ["id" =>"64", "name" => "Monitoria: Ver Escobs","created_at" => now(), "updated_at" => now()],
        ]);
    }
}
