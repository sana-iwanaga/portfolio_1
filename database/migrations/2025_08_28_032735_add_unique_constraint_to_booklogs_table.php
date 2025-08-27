<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booklogs', function (Blueprint $table) {
            $table->unique(['user_id', 'isbn']); // 制約を再作成
        });
    }

    public function down(): void
    {
        Schema::table('booklogs', function (Blueprint $table) {
            $table->dropUnique('booklogs_user_id_isbn_unique'); // 元に戻す
        });
    }
};

