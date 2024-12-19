<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesEmailTable extends Migration
{
    public function up()
    {
        Schema::create('invoices_email', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('load_id');
            $table->unsignedBigInteger('invoice_user_id');
            $table->string('from_email');
            $table->string('to_email');
            $table->string('subject');
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('load_id')->references('id')->on('load')->onDelete('cascade');
            $table->foreign('invoice_user_id')->references('user_id')->on('load')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices_email');
    }
}
