<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookreview;  // Postモデルを使う

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
        return view('posts.Review_Posts', compact('reviews'));
    }

    // トップページ
    public function Top_page()
    {
        $reviews = Bookreview::all();
        return view('posts.Home', compact('reviews'));
    }

    // 書籍検索ページ
    public function Books_research()
    {
        $reviews = Bookreview::all();
        return view('posts.Books_research', compact('reviews'));
    }
// レビュー作成ページ
    public function create($isbn)
    {
        return view('posts.Review_Posts', compact('isbn'));
    }

    // レビュー保存
    public function store(Request $request)
    {
        $request->validate([
            'post.book' => 'required|string|max:255',
            'post.title' => 'required|string|max:255',
            'post.emotion_category' => 'required|string',
            'post.body' => 'required|string',
        ]);

        Bookreview::create([
            'book' => $request->input('post.book'),
            'title' => $request->input('post.title'),
            'emotion_category' => $request->input('post.emotion_category'),
            'body' => $request->input('post.body'),
        ]);

        return redirect()->route('Review_Posts')->with('status', 'Review created successfully!');
    }
};