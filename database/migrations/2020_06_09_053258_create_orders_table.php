<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->decimal('total', 16, 2)->default(0);
            $table->decimal('subtotal', 16, 2)->default(0);
            $table->decimal('discount', 16, 2)->default(0);
            $table->char('state', 1)->default('N')->comment("N-new, P-paid");
            $table->char('type', 1)->comment("P-product, E-ebook");
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
        Schema::dropIfExists('orders');
    }
}
