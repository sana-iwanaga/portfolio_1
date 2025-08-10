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
            $table->string('title',50);
            $table->string('author',50);
            $table->string('isbn',20);
            $table->string('publisherName',50);
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
