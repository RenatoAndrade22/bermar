<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePrductAddVolts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('power')->nullable()->default(null);
            $table->string('voltage')->nullable()->default(null);

            $table->decimal('packing_width',8, 2)->nullable()->default(null);
            $table->decimal('packing_weight',8, 2)->nullable()->default(null);
            $table->decimal('packing_length',8, 2)->nullable()->default(null);
            $table->decimal('packing_height',8, 2)->nullable()->default(null);
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
