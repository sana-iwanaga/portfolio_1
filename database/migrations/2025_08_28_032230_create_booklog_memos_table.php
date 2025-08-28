<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booklog_memos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booklog_id'); // Booklogとの紐付け
            $table->foreign('booklog_id')->references('booklog_id')->on('booklogs')->onDelete('cascade');
            $table->text('memo'); // メモ内容
            $table->timestamps(); // 作成・更新日時
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booklog_memos');
    }
};

