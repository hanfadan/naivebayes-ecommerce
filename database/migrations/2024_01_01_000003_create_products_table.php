<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('stok')->default(0);
            $table->double('price')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->date('created')->nullable();
            $table->date('modified')->nullable();
            $table->unsignedInteger('category_id');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
