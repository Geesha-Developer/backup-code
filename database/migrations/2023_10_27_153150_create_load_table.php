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
        Schema::create('load', function (Blueprint $table) {
            $table->id();
            $table->string('load_number');
            $table->string('load_dispatcher');
            $table->string('load_bill_to');
            $table->string('load_status');
            $table->string('load_workorder');
            $table->string('load_payment_type');
            $table->string('load_type');
            $table->string('load_shipper_rate');
            $table->string('load_pds');
            $table->string('load_fsc_rate');
            $table->string('load_telephone');
            $table->string('load_other_change');
            $table->string('load_final_rate');
            $table->string('load_carrier');
            $table->string('load_advance_payment');
            $table->string('load_type_two');
            $table->string('load_billing_type');
            $table->string('load_mc_no');
            $table->string('load_equipment_type');
            $table->string('load_carrier_fee');
            $table->string('load_currency');
            $table->string('load_pds_two');
            $table->string('load_billing_fsc_rate');
            $table->string('load_other_charge');
            $table->string('load_final_carrier_fee');
            $table->string('load_other_charge_two');
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
        Schema::dropIfExists('load');
    }
};
