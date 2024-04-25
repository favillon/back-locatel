<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transaction_type_id');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');

            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->bigInteger('value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
