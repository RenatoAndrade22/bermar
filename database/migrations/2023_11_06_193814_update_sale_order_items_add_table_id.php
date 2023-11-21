<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSaleOrderItemsAddTableId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('price_table_id')->nullable()->default(null);
            
            $table->foreign('price_table_id')
                ->references('id')->on('price_tables');
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
