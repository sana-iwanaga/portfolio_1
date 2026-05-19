<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RakutenBookController extends Controller
{
    public function search(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');
        $publisherName = $request->input('publisherName');
        $isbn = $request->input('isbn');
        $keyword = $request->input('q'); // フリーワード検索用

        $queryParams = [
            'applicationId' => env('RAKUTEN_APP_ID'),
            'accessKey' => env('RAKUTEN_ACCESS_KEY'),
            'format' => 'json',
            'hits' => 20,
        ];

        if (!empty($title)) {
            $queryParams['title'] = $title;
        }
        if (!empty($author)) {
            $queryParams['author'] = $author;
        }
        if (!empty($publisherName)) {
            $queryParams['publisherName'] = $publisherName;
        }
        if (!empty($isbn)) {
            $queryParams['isbn'] = $isbn;
        }
        if (!empty($keyword)) {
            $queryParams['keyword'] = $keyword;
        }

        // 条件が1つもない場合
        if (count($queryParams) === 4) {
            return view('posts.research', [
                'books' => [],
                'error' => '検索条件を1つ以上入力してください',
            ]);
        }

        try {
            $url = 'https://openapi.rakuten.co.jp/services/api/BooksBook/Search/20170404';
            $response = Http::withHeaders([
                'Referer' => 'https://portfolio-bookmemory-bd6e33aa868f.herokuapp.com',
                'Origin' => 'https://portfolio-bookmemory-bd6e33aa868f.herokuapp.com',
                'User-Agent' => 'Mozilla/5.0',
            ])->get($url, $queryParams);

            if ($response->failed()) {
                dd(
                    $response->status(),
                    $response->body(),
                    $response->json()
                );
            }

            $data = $response->json();
            Log::info('Rakuten API response:', $data);

            return view('posts.research', [
                'books' => $data['Items'] ?? [],
                'title' => $title,
                'author' => $author,
                'publisherName' => $publisherName,
                'isbn' => $isbn,
                'query' => $keyword,
            ]);

        } catch (\Exception $e) {
            Log::error('Rakuten API error: ' . $e->getMessage());
            return view('posts.research', [
                'books' => [],
                'error' => '検索中にエラーが発生しました。',
            ]);
        }
    }

}
