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
            $table->text('book');
            $table->text('title');
            $table->text('emotion_category');
            $table->text('body');
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
