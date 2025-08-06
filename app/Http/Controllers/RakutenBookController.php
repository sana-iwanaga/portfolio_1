<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RakutenBookController extends Controller
{
    // 検索用のメソッド名を index から search に変更し、ルーティング名とも一致させるのがおすすめ
    public function search(Request $request)
    {
        $keyword = $request->input('q');
       

        // 空キーワードの場合は空配列返して検索画面へ
        if (empty($keyword)) {
            return view('posts.Books_research')->with([
                'books' => [],
                'query' => '',
            ]);
        }

        $client = new Client([
            'verify' => config('app.env') !== 'local',
        ]);

        $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404';

        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'applicationId' => '1023370564471652170', // ここは.env等に置くのがベスト
                    'format' => 'json',
                    'title' => $keyword,   // ここでキーワードを渡す
                    'hits' => 20,           // 取得件数指定（任意）
                ],
            ]);

            $books = json_decode($response->getBody(), true);

            Log::info('Rakuten API response:', $books);

            return view('posts.Books_research')->with([
                'books' => $books['Items'] ?? [],
                'query' => $keyword,
            ]);
        } catch (\Exception $e) {
            Log::error('Rakuten API error: ' . $e->getMessage());

            return view('posts.Books_research')->with([
                'books' => [],
                'query' => $keyword,
                'error' => '検索中にエラーが発生しました。',
            ]);
        }
    }
}



