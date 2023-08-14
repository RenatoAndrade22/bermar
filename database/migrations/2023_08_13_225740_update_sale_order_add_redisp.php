<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSaleOrderAddRedisp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_orders', function (Blueprint $table) {
           
            $table->unsignedBigInteger('carrier_id')->nullable()->default(null);

            $table->string('phone_redispatch')->nullable()->default(null);
            $table->string('shipping_type_redispatch')->nullable()->default(null);

            $table->foreign('carrier_id')
                ->references('id')->on('carriers');

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
