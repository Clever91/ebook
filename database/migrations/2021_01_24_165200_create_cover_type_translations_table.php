<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoverTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cover_type_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cover_type_id')->unsigned();
            $table->string('locale')->index();
            $table->tinyInteger('is_default')->default(0)->comment("0-not default, 1-default");
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('cover_type_translations', function($table) {
            $table->unique(['cover_type_id', 'locale']);
            $table->foreign('cover_type_id')
                ->references('id')
                ->on('cover_types')
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
        Schema::dropIfExists('cover_type_translations');
    }
}
