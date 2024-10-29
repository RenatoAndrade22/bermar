<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Inserir ou atualizar dados na tabela 'pages'
        $pages = [
            ['id'=> 1, 'name' => 'painel'],
            ['id'=> 2, 'name' => 'produtos'],
            ['id'=> 3, 'name' => 'familias'],
            ['id'=> 4, 'name' => 'vendas'],
            ['id'=> 5, 'name' => 'empresas'],
            ['id'=> 6, 'name' => 'usuarios'],
            ['id'=> 7, 'name' => 'minhas-compras'],
            ['id'=> 8, 'name' => 'garantias'],
            ['id'=> 9, 'name' => 'produtos/garantias'],
            ['id'=> 10, 'name' => 'vendas-externas'],
            ['id'=> 11, 'name' => 'representante-empresas'],
            ['id'=> 12, 'name' => 'vendas-externas-relatorios'],
            ['id'=> 13, 'name' => 'tabelas-comissoes']
        ];

        foreach ($pages as $page) {
            DB::table('pages')->updateOrInsert(
                ['id' => $page['id']],
                ['name' => $page['name']]
            );
        }

        // Regras por página
        $pages_rules = [
            // PAINEL
            ['page_id' => 1, 'enterprise_type_id' => 1],
            ['page_id' => 1, 'enterprise_type_id' => 2],
            ['page_id' => 1, 'enterprise_type_id' => 3],
            ['page_id' => 1, 'enterprise_type_id' => 4],
            ['page_id' => 1, 'enterprise_type_id' => 5],

            // PRODUTOS
            ['page_id' => 2, 'enterprise_type_id' => 1],
            ['page_id' => 2, 'enterprise_type_id' => 2],

            // FAMILIA
            ['page_id' => 3, 'enterprise_type_id' => 1],

            // VENDAS
            ['page_id' => 4, 'enterprise_type_id' => 1],
            ['page_id' => 4, 'enterprise_type_id' => 3],

            // EMPRESAS
            ['page_id' => 5, 'enterprise_type_id' => 1],

            // USUARIOS
            ['page_id' => 6, 'enterprise_type_id' => 1],

            // MINHAS COMPRAS
            ['page_id' => 7, 'enterprise_type_id' => 2],

            // GARANTIAS
            ['page_id' => 8, 'enterprise_type_id' => 1],
            ['page_id' => 8, 'enterprise_type_id' => 4],

            // PRODUTOS GARANTIAS
            ['page_id' => 9, 'enterprise_type_id' => 1],

            // VENDAS EXTERNAS
            ['page_id' => 10, 'enterprise_type_id' => 2],

            // VENDAS EXTERNAS
            ['page_id' => 10, 'enterprise_type_id' => 2],

            // representante-empresas
            ['page_id' => 11, 'enterprise_type_id' => 3],

            // representante-empresas
            ['page_id' => 12, 'enterprise_type_id' => 1],

            //tabelas-comissoes
            ['page_id' => 13, 'enterprise_type_id' => 1],

        ];

        foreach ($pages_rules as $rule) {
            DB::table('pages_rules')->updateOrInsert(
                ['page_id' => $rule['page_id'], 'enterprise_type_id' => $rule['enterprise_type_id']],
                []  // Sem necessidade de atualização de dados extras
            );
        }
    }
}
