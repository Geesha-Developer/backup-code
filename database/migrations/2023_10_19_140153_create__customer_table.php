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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('load');
            $table->string('dispatch_bill_to');
            $table->string('dispatch_status');
            $table->string('dispatch_work_order');
            $table->string('dispatch_payment_type');
            $table->string('dispatch_type');
            $table->string('dispatch_shipper_rate');
            $table->string('dispatch_pds');
            $table->string('dispatch_fsc_rate');
            $table->string('dispatch_order_charge');
            $table->string('dispatch_final_rate');
            $table->string('dispatch_advance_payment');
            $table->string('dispatch_load_type');
            $table->string('dispatch_billing_type');
            $table->string('dispatch_mc_no');
            $table->string('dispatch_carrier');
            $table->string('dispatch_equipment_type');
            $table->string('dispatch_carrier_fee');
            $table->string('dispatch_currency');
            $table->string('dispatch_pds_two');
            $table->string('dispatch_fsc_rate_two');
            $table->string('dispatch_other_charge');
            $table->string('dispatch_final_carrier_fee');
            $table->string('shipper');
            $table->string('shipper_date');
            $table->string('shipper_location');
            $table->string('shipper_show_time');
            $table->string('shipper_description');
            $table->string('shipper_qty');
            $table->string('shipper_type');
            $table->string('shipper_weight');
            $table->string('shipper_commodity');
            $table->string('shipper_shipping_notes');
            $table->string('shipper_value');
            $table->string('shipper_po_number');
            $table->string('shipper_custome_broker');
            $table->string('consignee');
            $table->string('consignee_date');
            $table->string('consignee_location');
            $table->string('consignee_show_time');
            $table->string('consignee_description');
            $table->string('consignee_qty');
            $table->string('consignee_type');
            $table->string('consignee_weight');
            $table->string('consignee_commodity');
            $table->string('consignee_delivery_note');
            $table->string('consignee_value');
            $table->string('consignee_po_number');
            $table->string('consignee_pro_miles');
            $table->string('consignee_empty');
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
        Schema::dropIfExists('customers');
    }
};
