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
        Schema::create('bookreviews', function (Blueprint $table) {
            $table->id('bookreview_id');
            // $table->text('review_title');
            // $table->text('review');
            $table->string('isbn');
            $table->string('book_title')->nullable();
            $table->string('title');
            $table->foreignId('emotioncategory_id')
                  ->constrained('emotioncategories', 'emotioncategory_id')
                  ->onDelete('cascade');
            $table->text('body');
            $table->unsignedBigInteger('user_id'); // ユーザーIDを追加
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookreviews');
    }
};
