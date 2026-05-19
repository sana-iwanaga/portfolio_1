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
        $response = Http::withHeaders([
            'Referer' => 'https://portfolio-bookmemory-bd6e33aa868f.herokuapp.com',
            'Origin' => 'https://portfolio-bookmemory-bd6e33aa868f.herokuapp.com',
        ])->get('https://openapi.rakuten.co.jp/services/api/BooksBook/Search/20170404', [
            'applicationId' => env('RAKUTEN_APP_ID', 'bdab1540-4dd2-4840-9d97-ec56825b8cbb'),
            'accessKey' => env('RAKUTEN_ACCESS_KEY', 'pk_4OafB4EU5IoKJqBam7lyNsNrLfAnigWjgux0T49EOCd'),
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
    