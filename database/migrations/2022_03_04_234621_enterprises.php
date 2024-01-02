<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Enterprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('enterprise_type_id');
            $table->string('email')->unique();
            $table->string('cnpj');
            $table->string('phone')->unique();

            $table->timestamps();

            $table->foreign('enterprise_type_id')
                ->references('id')->on('enterprise_types');
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
