<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booklog;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookreview;

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
   
    $latestBookreviews = Bookreview::where('user_id', Auth::id())
                           ->orderBy('created_at', 'desc')
                           ->take(3)
                           ->get();

    return view('posts.Home', compact('latestBooklogs', 'statusCounts', 'latestBookreviews'));
}

}
