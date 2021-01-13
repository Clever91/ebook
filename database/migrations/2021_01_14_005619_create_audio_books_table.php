<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 12, 2, true);
            $table->bigInteger('file_id');
            $table->tinyInteger('status')->default(0)->comment("0-not active, 1-active");
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('created_by');
            $table->timestamps();
        });

        Schema::table('audio_books', function($table) {
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
        Schema::dropIfExists('audio_books');
    }
}
