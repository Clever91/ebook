<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("chat_order_id")->unsigned();
            $table->bigInteger("product_id")->unsigned();
            $table->integer("quantity");
            $table->decimal("price", 16, 0);
            $table->timestamps();
        });

        Schema::table('chat_order_details', function($table) {
            $table->foreign('chat_order_id')
                ->references('id')
                ->on('chat_orders')
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
        Schema::dropIfExists('chat_order_details');
    }
}
