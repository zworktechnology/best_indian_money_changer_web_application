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
        Schema::create('expenses', function (Blueprint $table) {

            // Auto-generate ID column
            $table->id();

            // Request columns
            $table->string('unique_id')->unique();
            $table->string('date');
            $table->string('time');
            $table->string('amount');
            $table->string('description')->nullable();
            $table->boolean('soft_delete')->default(0);

            // CreatedAt & UpdatedAt columns
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
        Schema::dropIfExists('expenses');
    }
};
