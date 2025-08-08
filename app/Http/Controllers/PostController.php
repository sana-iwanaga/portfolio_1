<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;  // Postモデルを使う

class PostController extends Controller
{
    // 投稿一覧
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // レビューページ
    public function Review_Posts()
    {
        $posts = Post::all();
        return view('posts.Review_Posts', compact('posts'));
    }

    // トップページ
    public function Top_page()
    {
        $posts = Post::all();
        return view('posts.Top_page', compact('posts'));
    }

    // 書籍検索ページ
    public function Books_research()
    {
        $posts = Post::all();
        return view('posts.Books_research', compact('posts'));
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'isbn' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'isbn' => $request->isbn,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('Review_Posts')->with('status', 'Review created successfully!');
    }
};