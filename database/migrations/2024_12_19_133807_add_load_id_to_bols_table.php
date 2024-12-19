<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bol', function (Blueprint $table) {
            $table->unsignedBigInteger('load_id'); // Foreign key column
            $table->foreign('load_id')->references('id')->on('loads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bol', function (Blueprint $table) {
            $table->dropForeign(['load_id']);
            $table->dropColumn('load_id');
        });
    }
};
