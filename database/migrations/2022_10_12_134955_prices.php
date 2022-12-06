<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Prices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price_table_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price',8, 2);

            $table->foreign('price_table_id')
                ->references('id')->on('price_tables');

            $table->foreign('product_id')
                ->references('id')->on('products');
                
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
       
    }
}
