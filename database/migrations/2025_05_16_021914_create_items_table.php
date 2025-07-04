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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('condition', ['new', 'like new', 'used', 'poor']);
            $table->enum('status', ['available', 'reserved', 'sold', 'pending approval'])->default('pending approval');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
