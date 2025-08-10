<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(User $user)
    {
        // ユーザーの投稿を取得
        $bookreviews = $user->getOwnPagenateByLimit(5);

        // ビューにデータを渡す
        return view('users.home', [
            'user' => $user,
            'bookreviews' => $bookreviews,
        ]);
    }
}
