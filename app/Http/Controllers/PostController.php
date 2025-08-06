<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PostController extends Controller
{
    public function index(User $Post)
    {
        return view('posts.index', ['posts' => $Post->all()]); // すべてのユーザーを取得
    }

    public function Review_Posts(User $Post)
    {
        return view('posts.Review_Posts', ['posts' => $Post->all()]); // すべてのユーザーを取得
    }
    public function Top_page(User $Post)
    {
        return view('posts.Top_page', ['posts' => $Post->all()]); // すべてのユーザーを取得
    }
     public function Books_research(User $Post)
    {
        return view('posts.Books_research', ['posts' => $Post->all()]); // すべてのユーザーを取得
    }
}
