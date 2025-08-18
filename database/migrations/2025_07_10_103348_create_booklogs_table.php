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
        Schema::create('booklogs', function (Blueprint $table) {
            $table->id('booklog_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('isbn', 20);
            $table->string('title');
            $table->enum('status', ['unread', 'reading', 'read']);
            $table->text('memo')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'isbn']); // ユーザーごとにISBNの重複を防ぐ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booklogs');
    }
};
