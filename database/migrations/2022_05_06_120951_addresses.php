<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('street');
            $table->string('district');
            $table->string('zipcode');
            $table->string('city');
            $table->string('state');
            $table->string('complement')->nullable()->default(null);
            $table->unsignedBigInteger('enterprise_id');

            $table->timestamps();

            $table->foreign('enterprise_id')
                ->references('id')->on('enterprises');
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
