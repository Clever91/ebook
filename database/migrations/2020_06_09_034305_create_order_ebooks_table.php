<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_ebooks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('price', 16, 2);
            $table->decimal('discount', 16, 2)->default(0);
            $table->char('state', 1)->comment("O-order, P-payed")->default("O");
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('order_ebooks', function (Blueprint $table) {
            $table->unique(['customer_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_ebooks');
    }
}
