<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('role')->default('user');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->date('birth')->nullable();
            $table->string('gender', 1)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('address')->nullable();
            $table->string('password');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
