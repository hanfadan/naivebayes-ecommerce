<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->double('total')->default(0);
            $table->string('invoice')->unique();
            $table->unsignedInteger('user_id');
            $table->date('created')->nullable();
            $table->date('modified')->nullable();
        });

        Schema::create('transactions_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty');
            $table->double('price');
            $table->unsignedInteger('tran_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions_details');
        Schema::dropIfExists('transactions');
    }
};
