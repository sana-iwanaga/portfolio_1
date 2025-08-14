<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booklog;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function latestBooklog()
{
    $latestBooklogs = Booklog::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();

    $statusCounts = Booklog::where('user_id', Auth::id())
                           ->selectRaw('status, count(*) as count')
                           ->groupBy('status')
                           ->pluck('count','status');

    return view('posts.home', compact('latestBooklogs', 'statusCounts'));
}

};
