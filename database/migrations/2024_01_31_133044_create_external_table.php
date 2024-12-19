<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key referencing the users table
            $table->string('carrier_name'); // Foreign key referencing the users table
            $table->string('carrier_dot'); // Foreign key referencing the users table
            $table->string('carrier_mc_ff'); // Foreign key referencing the users table
            $table->string('carrier_mc_ff_input'); // Foreign key referencing the users table
            $table->string('carrier_address'); // Foreign key referencing the users table
            $table->string('carrier_address_two'); // Foreign key referencing the users table
            $table->string('carrier_country'); // Foreign key referencing the users table
            $table->string('carrier_address_three'); // Foreign key referencing the users table
            $table->string('carrier_state'); // Foreign key referencing the users table
            $table->string('carrier_city'); // Foreign key referencing the users table
            $table->string('carrier_zip'); // Foreign key referencing the users table
            $table->string('carrier_contact_name'); // Foreign key referencing the users table
            $table->string('carrier_email'); // Foreign key referencing the users table
            $table->string('carrier_telephone'); // Foreign key referencing the users table
            $table->string('carrier_extn'); // Foreign key referencing the users table
            $table->string('carrier_tollfree'); // Foreign key referencing the users table
            $table->string('carrier_fax'); // Foreign key referencing the users table
            $table->string('carrier_payment_terms'); // Foreign key referencing the users table
            $table->string('carrier_tax_id'); // Foreign key referencing the users table
            $table->string('carrier_username'); // Foreign key referencing the users table
            $table->string('carrier_password'); // Foreign key referencing the users table
            $table->string('carrier_factoring_company'); // Foreign key referencing the users table
            $table->string('carrier_notes'); // Foreign key referencing the users table
            $table->string('carrier_status'); // Foreign key referencing the users table
            $table->string('carrier_load_type'); // Foreign key referencing the users table
            $table->string('carrier_blacklisted'); // Foreign key referencing the users table
            $table->string('carrier_corporation'); // Foreign key referencing the users table

            // Define the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('external');
    }
}
