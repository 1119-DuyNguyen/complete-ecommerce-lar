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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('thumb_image');
            $table->foreignId('vendor_id')->constrained(
                table: 'users', column: 'id'
            )->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->noActionOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained()->noActionOnDelete();
            $table->foreignId('child_category_id')->nullable()->constrained()->noActionOnDelete();
            $table->foreignId('brand_id')->constrained()->noActionOnDelete();
            $table->unsignedInteger('qty');
            $table->text('short_description');
            $table->text('long_description');
            $table->double('price');
            $table->double('offer_price')->nullable();
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->boolean('status') -> default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
