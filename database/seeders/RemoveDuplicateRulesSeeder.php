<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemoveDuplicateRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::transaction(function () {
            DB::statement('
                DELETE e1 FROM enterprises_rules e1
                INNER JOIN enterprises_rules e2 
                WHERE 
                    e1.id > e2.id AND 
                    e1.enterprise_id = e2.enterprise_id AND 
                    e1.enterprise_type_id = e2.enterprise_type_id
            ');
        });
    }
}
