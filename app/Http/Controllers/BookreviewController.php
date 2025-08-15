<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Bookreview; 
use App\Models\EmotionCategory;
use Illuminate\Support\Facades\Http;

class BookreviewController extends Controller
{
    // 投稿一覧
    public function index()
    {
        $reviews = Bookreview::all();
        return view('posts.Booklog', compact('reviews'));
    }

    // レビューページ
    public function Review_Posts()
    {
        $reviews = Bookreview::all();
        return view('posts.Bookreview', compact('reviews'));
    }

    // トップページ
    public function Home()
    {
        $reviews = Bookreview::all();
        return view('posts.Home', compact('reviews'));
    }

    // 書籍検索ページ
    public function Books_research()
    {
        $reviews = Bookreview::all();
        return view('posts.research', compact('reviews'));
    }
// レビュー作成ページ
    public function create($isbn)
    {
        $book = Book::where('isbn', $isbn)->first();
        $emotionCategories = EmotionCategory::all();
        return view('posts.Bookreview', compact('book', 'isbn', 'emotionCategories'));

    }


    // レビュー保存
    public function store(Request $request)
    {
        $request->validate([
            'bookreview.isbn' => 'required|string',
            'bookreview.title' => 'required|string|max:255',
            'bookreview.emotioncategory_id' => 'required|exists:emotioncategories,emotioncategory_id',
            'bookreview.body' => 'required|string',
        ]);

        $isbn = $request->input('bookreview.isbn');
        $book_title = $this->getTitle($isbn);


        Bookreview::create([
            'isbn' => $isbn,
            'book_title' => $book_title,
            'title' => $request->input('bookreview.title'),
            'emotioncategory_id' => $request->input('bookreview.emotioncategory_id'),
            'body' => $request->input('bookreview.body'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('books.book', ['isbn' => $isbn])
            ->with('status', 'レビューが保存されました');
    }

public function getTitle(string $isbn): string
{
    $queryParams = [
        'applicationId' => env('RAKUTEN_APP_ID'),
        'isbn' => $isbn,
        'format' => 'json',
        'hits' => 1,
    ];

    $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404';
    $response = Http::get($url, $queryParams);

    if ($response->failed()) {
        return 'タイトル不明';
    }

    $data = $response->json();
    return $data['Items'][0]['Item']['title'] ?? 'タイトル不明';
}



};