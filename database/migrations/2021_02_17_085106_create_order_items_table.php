<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id', false, true);
            $table->bigInteger('item_id', false, true);
            $table->string('item_type', 2)->comment('B-book, E-ebook, A-audio, G-good');
            $table->decimal('price', 16, 2)->default(0);
            $table->integer('quantity');
            $table->decimal('discount', 16, 2)->default(0);
            $table->decimal('total_price', 16, 2);
            $table->timestamps();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
        Schema::dropIfExists('order_items');
    }
}
