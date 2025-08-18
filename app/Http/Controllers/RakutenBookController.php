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
            'applicationId' => env('RAKUTEN_APP_ID', '1023370564471652170'),
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
        if (count($queryParams) === 3) {
            return view('posts.research', [
                'books' => [],
                'error' => '検索条件を1つ以上入力してください',
            ]);
        }

        try {
            $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404';
            $response = Http::get($url, $queryParams);

            if ($response->failed()) {
                return view('posts.research', [
                    'books' => [],
                    'error' => 'APIの取得に失敗しました',
                ]);
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
