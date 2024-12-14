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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('librarian_id');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->boolean('returned')->default(false);
            $table->timestamps();

            $table->foreign('book_id')->references('book_id')->on('books');
            $table->foreign('member_id')->references('member_id')->on('members');
            $table->foreign('librarian_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
