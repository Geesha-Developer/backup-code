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
        Schema::create('bol', function (Blueprint $table) {
            $table->id();
            $table->string('bol_number')->unique();
            $table->string('carrier_name');
            $table->decimal('freight_charges', 10, 2);
            $table->string('pickup_locations');
            $table->string('drop_locations');
            $table->integer('bill_of_lading_qty');
            $table->decimal('bill_of_lading_weight', 10, 2);
            $table->text('items');
            $table->string('files_print');
            $table->integer('pieces');
            $table->text('description');
            $table->decimal('lbs', 10, 2);
            $table->string('type');
            $table->string('nmfc')->nullable();
            $table->boolean('hm')->default(false);
            $table->string('class');
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
        Schema::dropIfExists('bol');
    }
};
