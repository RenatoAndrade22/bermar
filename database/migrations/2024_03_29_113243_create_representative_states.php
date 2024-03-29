<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativeStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representative_states', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('enterprise_id');

            $table->string('state');

            $table->foreign('enterprise_id')
                ->references('id')->on('enterprises');
            
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
        Schema::dropIfExists('representative_states');
    }
}
