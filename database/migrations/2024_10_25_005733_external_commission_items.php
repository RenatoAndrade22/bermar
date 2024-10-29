<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExternalCommissionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_commission_items', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('external_commission_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('comission',8, 2);
            $table->boolean('double')->default(false);

            $table->foreign('external_commission_id')->references('id')->on('external_commissions');

            $table->foreign('product_id')->references('id')->on('products');
                
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
