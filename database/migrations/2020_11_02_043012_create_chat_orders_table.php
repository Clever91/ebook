<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_orders', function (Blueprint $table) {
            $table->id();
            $table->string("chat_id", 200);
            $table->tinyInteger("delivery_type")->nullable()->comment("1-mail, 2-express24, 3-pickup");
            $table->tinyInteger("payment_type")->nullable()->comment("1-payme, 2-click, 3-cash");
            $table->decimal("delivery_price", 8, 0)->default(0);
            $table->decimal("amount", 16, 0)->default(0);
            $table->string("state", 4)->default("D")->comment("D-draf, N-New, C-Complate");
            $table->tinyInteger('status')->default(1)->comment("0-not active, 1-active");
            $table->tinyInteger("paid")->default(0)->comment("0-not paid, 1-paid");
            $table->string("phone")->nullable();
            $table->string("code")->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('chat_orders');
    }
}
