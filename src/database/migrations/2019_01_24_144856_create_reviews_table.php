<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->enum('lang', ['en','arm', 'ru']);
            $table->integer('parent_lang_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->text('content')->nullable();
            $table->integer('language_id');
            $table->enum('status', ['published','draft'] );
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('reviews');
    }
}
