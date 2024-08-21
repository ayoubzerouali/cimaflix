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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('content_id'); // the id of the content stored either series or movie
            $table->foreignId('user_id')->constrained(); // foreing key user
            $table->string('title')->nullable(); // Movie or series title
            $table->text('description')->nullable(); // Description
            $table->enum('type', ['movie', 'tv']); // favorite type of record
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
