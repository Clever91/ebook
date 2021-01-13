<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('eprice');
            $table->dropColumn('ebook');
            $table->dropColumn('file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2, true);
            $table->decimal('eprice', 12, 2, true)->nullable();
            $table->bigInteger('file_id')->nullable()->after('author_id');
            $table->tinyInteger('ebook')->default(0)->comment("0-ebook doesn't exists, 1-ebook exists");
        });
    }
}
