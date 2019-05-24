<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageIdToResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->integer('language_id');
        });
        Schema::table('files', function (Blueprint $table) {
            $table->integer('language_id');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->integer('language_id');
        });
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('language_id');
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->integer('language_id');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('language_id');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->integer('language_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
    }
}
