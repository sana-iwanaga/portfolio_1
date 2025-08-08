<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function show($isbn)
    {
        $response = Http::get('https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404', [
            'applicationId' => env('RAKUTEN_APP_ID', '1023370564471652170'),
            'isbn' => $isbn,  // isbn -> isbnjan に変更
            'format' => 'json',
        ]);

        $data = $response->json();

        if (empty($data['Items']) || !isset($data['Items'][0]['Item'])) {
            abort(404, '書籍が見つかりません');
        }

        $book = $data['Items'][0]['Item'];

        return view('posts.books.show', compact('book'));  // ビューのパスを確認
    }
}
        