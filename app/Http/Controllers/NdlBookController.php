<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use SimpleXMLElement;

class NdlBookController extends Controller
{
    // NDL検索画面（Blade表示用）
    public function search(Request $request)
    {
        $query = $request->input('q');

        $response = Http::get('https://ndlsearch.ndl.go.jp/api/opensearch', [
            'title' => $query,
            'cnt' => 20,
        ]);

        $xml = simplexml_load_string($response->body());
        $results = [];

        foreach ($xml->channel->item ?? [] as $item) {
            $dc = $item->children('dc', true); // 名前空間'dc'
            $results[] = [
                'title' => (string) $item->title,
                'creator' => (string) ($dc->creator ?? '不明'),
            ];
        }

        return view('books.ndl_search', compact('results', 'query'));
    }

    // Ajax検索用（JSON返却）
public function quickSearch(Request $request)
{
    $query = $request->input('q');

    if (!$query) return response()->json([]);

    // クエリを空白で分割 → AND条件に変換
    $terms = preg_split('/\s+/', trim($query));
    $keyword = implode(' AND ', array_map(fn($term) => '"' . $term . '"', $terms));

    // NDL OpenSearch API 呼び出し
   $response = Http::get('https://ndlsearch.ndl.go.jp/api/opensearch', [
    'title' => $keyword,
    'au' => $keyword,
    'cnt' => 20,
]);

    $xml = simplexml_load_string($response->body());
    $results = [];

    foreach ($xml->channel->item ?? [] as $item) {
        $dc = $item->children('dc', true);
        $results[] = [
            'title' => (string) $item->title,
            'creator' => (string) ($dc->creator ?? '不明'),
        ];
    }

    return response()->json($results);
}

    // NDL書籍詳細画面（Blade表示用）
    public function detail($id)
    {
        // ここにNDL書籍の詳細取得ロジックを実装
        // 例: NDL APIを呼び出して書籍情報を取得し、ビューに渡す
        return view('books.ndl_detail', compact('id'));
    }
}
