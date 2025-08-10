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
        Schema::create('searchs', function (Blueprint $table) {
            $table->id('search_id');
            $table->string('book_title',50);
            $table->string('book_author',50);
            $table->string('book_isbn',20);
            $table->string('book_publisher',50);
            $table->date('book_published_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searchs');
    }
};
