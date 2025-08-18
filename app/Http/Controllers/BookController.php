<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Book;
use App\Models\Bookreview;

class BookController extends Controller
{
    public function book($isbn)
    {
        $response = Http::get('https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404', [
            'applicationId' => env('RAKUTEN_APP_ID', '1023370564471652170'),
            'isbn' => $isbn, 
            'format' => 'json',
        ]);

        $data = $response->json();

        if (empty($data['Items']) || !isset($data['Items'][0]['Item'])) {
            abort(404, '書籍が見つかりません');
        }

        $apibook = $data['Items'][0]['Item'];

        $book = Book::updateOrCreate(
            ['isbn' => $apibook['isbn']],
            [
                'title' => $apibook['title'],
                'author' => $apibook['author'],
                'publisherName' => $apibook['publisherName'],
                'mediumImageUrl' => $apibook['mediumImageUrl'] ?? null,
                'SalesDate' => $apibook['salesDate'] ?? null,
            ]
        );

        $reviews = Bookreview::with(['user', 'emotioncategory'])
                     ->where('isbn', $apibook['isbn'])
                     ->get();

        return view('posts.books.Book', compact('apibook', 'book', 'reviews'));  // ビューのパスを確認
    }
}
    