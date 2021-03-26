<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price_type_id')->unsigned();
            $table->bigInteger('object_id')->unsigned();
            $table->string('object_type', 2);
            $table->decimal('price')->default(0);
            $table->tinyInteger('status')->default(1)->comment("0-not active, 1-active");
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('created_by');
            $table->timestamps();
        });

        Schema::table('product_prices', function (Blueprint $table) {
            $table->foreign('price_type_id')
                ->references('id')
                ->on('price_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
}
