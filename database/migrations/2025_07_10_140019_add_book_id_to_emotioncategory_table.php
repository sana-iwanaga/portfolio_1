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
        Schema::table('emotioncategory', function (Blueprint $table) {
            $table->foreignId('book_id')
                  ->constrained('book', 'book_id')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emotioncategory', function (Blueprint $table) {
            //
        });
    }
};
