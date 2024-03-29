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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('total_amount')->nullable();
            $table->string('total_paid')->nullable();
            $table->string('total_balance')->nullable();

            $table->unsignedBigInteger('sales_id')->nullable();

            $table->unsignedBigInteger('purchase_customerid')->nullable();
            $table->foreign('purchase_customerid')->references('id')->on('customers')->onDelete('cascade');
            $table->string('purchase_amount')->nullable();
            $table->string('purchase_paid')->nullable();
            $table->string('purchase_balance')->nullable();

            $table->unsignedBigInteger('purchase_id')->nullable();


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
        Schema::dropIfExists('payments');
    }
};
