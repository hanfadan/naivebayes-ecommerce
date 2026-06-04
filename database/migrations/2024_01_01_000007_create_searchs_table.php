<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('searchs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('view')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('searchs');
    }
};
