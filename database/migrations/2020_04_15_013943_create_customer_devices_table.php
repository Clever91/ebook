<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_id");
            $table->bigInteger("device_id");
            $table->timestamps();
        });

        Schema::table('customer_devices', function (Blueprint $table) {
            $table->unique(['customer_id', 'device_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_devices');
    }
}
