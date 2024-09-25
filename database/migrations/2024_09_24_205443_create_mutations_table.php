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
        Schema::create('mutations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('date')->useCurrent();
            $table->string('type');
            $table->integer('quantity');
            $table->uuid('user_id')->constrained('users');
            $table->uuid('item_id')->constrained('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
