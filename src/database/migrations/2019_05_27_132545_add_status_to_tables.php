<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->enum('status', ['published','draft'] );
        });
        Schema::table('files', function (Blueprint $table) {
            $table->enum('status', ['published','draft'] );
        });
        Schema::table('lecturers', function (Blueprint $table) {
            $table->enum('status', ['published','draft'] );
        });
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['published','draft'] );
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
