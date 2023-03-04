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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            // $table->string('barcode')->unique()->nullable();

            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->cascadeOnUpdate(); //->cascadeOnDelete()
            // $table->foreignId('color_id')->nullable()->references('id')->on('colors')->cascadeOnUpdate(); //->cascadeOnDelete()
            // $table->foreignId('category_id')->constrained()->onUpdate('cascade');
            // $table->foreignId('color_id')->constrained()->onUpdate('cascade');

            $table->integer('price')->default(0);
            $table->integer('old_price')->default(0);
            // $table->decimal('price', 10, 2)->nullable()->default(0);
            // $table->decimal('old_price', 10, 2)->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
