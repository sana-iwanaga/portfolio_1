<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booklogs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            // ユニーク制約を削除
            $table->dropUnique('booklogs_user_id_isbn_unique');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('booklogs', function (Blueprint $table) {
            // 元に戻す場合
            $table->unique(['user_id', 'isbn']);
        });
    }
};

