<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 12, 2, true);
            $table->bigInteger('leftover')->nullable();
            $table->string('cover', 2)->default('S')->comment('H -> hard, S -> Soft');
            $table->string('letter', 2)->default('L')->comment('L -> Lotin, K -> Krill');
            $table->string('size', 8)->nullable();
            $table->string('color', 20)->nullable();
            $table->tinyInteger('status')->default(0)->comment("0-not active, 1-active");
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('created_by');
            $table->timestamps();
        });

        Schema::table('books', function($table) {
            $table->unique(['product_id', 'id']);
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('books');
    }
}
