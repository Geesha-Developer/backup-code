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
        Schema::create('invoices_email', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_id')->constrained('loads'); // Add foreign key to loads table
            $table->string('from_email');
            $table->string('to_email');
            $table->string('subject');
            $table->text('message');
            $table->json('attachments')->nullable();
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
        Schema::dropIfExists('invoices_email');
    }
};
