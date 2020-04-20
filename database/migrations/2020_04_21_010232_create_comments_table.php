<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->text('body');
            $table->integer('commentable_id')->unsigned();
            $table->string('commentable_type');
            $table->tinyInteger('status')->default(0)->comment("0-not active, 1-active");
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::dropIfExists('comments');
    }
}
