<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internal_id');
            $table->unsignedBigInteger('external_id');
            $table->string('model');
            $table->timestamps();

            // Adicionar restrição unique nas colunas id_banco_a e model
            $table->unique(['internal_id', 'model']);
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
