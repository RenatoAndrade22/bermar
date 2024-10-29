<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagesRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_rules', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('enterprise_type_id');

            $table->foreign('page_id')
                ->references('id')->on('pages');
            
            $table->foreign('enterprise_type_id')
                ->references('id')->on('enterprise_types');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
