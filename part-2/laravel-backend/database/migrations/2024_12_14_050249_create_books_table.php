<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('name', 50);
            $table->char('description', 200);
            $table->char('isbn', 13);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();
    
            $table->foreign('author_id')->references('author_id')->on('authors')->onDelete('cascade');
            $table->foreign('genre_id')->references('genre_id')->on('genres')->onDelete('cascade');
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
