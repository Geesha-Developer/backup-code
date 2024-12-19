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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->string('shipper_name');
            $table->string('shipper_address');
            $table->string('shipper_address_two');
            $table->string('shipper_address_three');
            $table->string('shipper_country');
            $table->string('shipper_state');
            $table->string('shipper_city');
            $table->string('shipper_zip');
            $table->string('shipper_contact_name');
            $table->string('shipper_contact_email');
            $table->string('shipper_telephone');
            $table->string('shipper_extn');
            $table->string('shipper_toll_free');
            $table->string('shipper_fax');
            $table->string('shipper_hours');
            $table->string('shipper_appointments');
            $table->string('shipper_major_intersections');
            $table->string('shipper_status');
            $table->string('shipper_shipping_notes');
            $table->string('shipper_internal_notes');
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
        Schema::dropIfExists('shippers');
    }
};
