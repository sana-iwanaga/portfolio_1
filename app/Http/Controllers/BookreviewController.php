<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Bookreview; 
use App\Models\Emotioncategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $emotionCategories = Emotioncategory::all();
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
            'rating' => $request->input('bookreview.rating'), // レーティングを追加
            'body' => $request->input('bookreview.body'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('books.book', ['isbn' => $isbn])
            ->with('status', 'レビューが保存されました');
    }

public function destroy($id)
    {
        $review = Bookreview::where('user_id', Auth::id())->where('bookreview_id', $id)->firstOrFail();
        $review->delete();

        return redirect()->route('reviews.my')->with('success', 'レビューが削除されました');
    }

public function myReviews()
{
    $reviews = Bookreview::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get(); // 全件取得

    return view('posts.Myreview', compact('reviews'));
}
    // 書籍タイトル取得
    public function getTitle(string $isbn): string
{
    return Cache::remember("book_title_{$isbn}", now()->addDays(7), function () use ($isbn) {
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
    });
}


    // 書籍詳細ページ
    public function like(Bookreview $bookreview)
    {
        $user = Auth::user();
        $review = Bookreview::where('isbn', $bookreview->isbn)->firstOrFail();
        $review->likes()->firstOrCreate([
            'user_id' => $user->id,
        ]);
        return back();
    }
};