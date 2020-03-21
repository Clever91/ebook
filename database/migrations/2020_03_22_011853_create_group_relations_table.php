<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('related_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
            $table->string('type')->comment('P-product, C-Category, A-Author');
            $table->integer('order_no');
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('created_by');
            $table->timestamps();
        });

        Schema::table('group_relations', function($table) {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_relations');
    }
}
