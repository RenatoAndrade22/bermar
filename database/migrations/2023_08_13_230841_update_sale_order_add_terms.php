<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSaleOrderAddTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_orders', function (Blueprint $table) {
           
            $table->integer('carrier_id_redispatch')->nullable()->default(null);

            $table->unsignedBigInteger('payment_term_id')->nullable()->default(null);

            $table->foreign('payment_term_id')
                ->references('id')->on('payment_terms');

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
