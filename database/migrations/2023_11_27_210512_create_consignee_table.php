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
        Schema::create('consignee', function (Blueprint $table) {
            $table->id();
            $table->string('consignee_name');
            $table->string('sconsignee_address');
            $table->string('consignee_address_two');
            $table->string('consignee_address_three');
            $table->string('consignee_country');
            $table->string('consignee_state');
            $table->string('consignee_city');
            $table->string('consignee_zip');
            $table->string('consignee_contact_name');
            $table->string('consignee_contact_email');
            $table->string('consignee_telephone');
            $table->string('consignee_ext');
            $table->string('consignee_toll_free');
            $table->string('consignee_fax');
            $table->string('consignee_hours');
            $table->string('consignee_appointments');
            $table->string('consignee_major_intersections');
            $table->string('consignee_status');
            $table->string('consignee_internal_notes');
            $table->string('consignee_shipping_notes');
            // Add other columns as needed
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
        Schema::dropIfExists('consignee');
    }
};
