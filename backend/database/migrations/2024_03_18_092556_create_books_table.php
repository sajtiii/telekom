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
        Schema::create('books', function (Blueprint $table) {
            $table->id()->autoIncrement(); // NOTE: I prefer using UUIDs as primary keys, as they are harder to guess, but the provided JSON contains integer IDs

            $table->string('author', 100);
            $table->string('title', 200);
            $table->timestamp('publish_date'); // NOTE: `publised_at` would be a better name, as is the Laravel convention
            $table->string('isbn', 13)->unique();
            $table->longText('summary')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('on_store');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
