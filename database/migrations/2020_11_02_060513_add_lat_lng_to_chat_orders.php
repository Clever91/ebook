<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLngToChatOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_orders', function (Blueprint $table) {
            $table->decimal("lat", 12, 8)->nullable();
            $table->decimal("long", 12, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_orders', function (Blueprint $table) {
            $table->dropColumn("lat");
            $table->dropColumn("long");
        });
    }
}
