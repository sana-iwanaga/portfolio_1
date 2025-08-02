<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        return User::all(); // すべてのユーザーを取得
    }
}
