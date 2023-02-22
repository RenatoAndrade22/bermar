<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSaleOrderAddFreteTransporteOutros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->string('shipping_type')->nullable()->default(null);
            $table->string('shipping_company')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);             
            $table->text('observation')->nullable()->default(null);             
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
