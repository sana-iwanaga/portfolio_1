<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Bookreview; 

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
        return view('posts.Bookreview', compact('book', 'isbn'));
    }
    

    // レビュー保存
    public function store(Request $request)
    {
        $request->validate([
            'bookreview.isbn' => 'required|string',
            'bookreview.title' => 'required|string|max:255',
            'bookreview.emotion_category' => 'required|string|in:happy,sad,angry,laugh,honwaka',
            'bookreview.body' => 'required|string',
        ]);

        Bookreview::create([
            'isbn' => $request->input('bookreview.isbn'),
            'title' => $request->input('bookreview.title'),
            'emotion_category' => $request->input('bookreview.emotion_category'),
            'body' => $request->input('bookreview.body'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('Bookreview')->with('status', 'レビューが保存されました');
    }
};