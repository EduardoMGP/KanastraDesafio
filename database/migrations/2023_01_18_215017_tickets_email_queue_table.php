<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('tickets_email_queues', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('ticket_barcode')->nullable(true);
            $table->integer('debtId')->unique();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('debtId')->references('debtId')->on('invoices')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets_email_queue');
    }
};
