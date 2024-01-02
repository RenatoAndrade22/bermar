<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterprisesRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises_rules', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('enterprise_id');
            $table->unsignedBigInteger('enterprise_type_id');
            
            $table->foreign('enterprise_id')
                ->references('id')->on('enterprises');
            
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
        Schema::dropIfExists('enterprises_rules');
    }
}
