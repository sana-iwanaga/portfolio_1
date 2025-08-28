<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // 自分のホーム
    public function home(User $user)
    {
        $bookreviews = $user->getOwnPaginateByLimit(5);

        return view('posts.home', [
            'user' => $user,
            'bookreviews' => $bookreviews,
        ]);
    }

    // 他人のページ
    public function show(User $user)
    {
        $bookreviews = $user->getOwnPaginateByLimit(5);

        $me = Auth::user();
        $isFollowing = $me ? $me->followings()->get()->contains($user->id) : false;
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();

        return view('posts.Userhome', compact(
            'user', 'bookreviews', 'isFollowing', 'followersCount', 'followingsCount'
        ));
    }

    // フォロー
    public function follow(User $user)
    {
        $me = Auth::user();

        if ($me && !$me->followings()->where('following_id', $user->id)->exists()) {
            $me->followings()->attach($user->id);
        }

        if (request()->ajax()) {
            return response()->json([
                'following' => true,
                'followersCount' => $user->followers()->count(),
            ]);
        }

        return redirect()->back()->with('success', 'フォローしました。');
    }

    // フォロー解除
    public function unfollow(User $user)
    {
        $me = Auth::user();

        if ($me && $me->followings()->where('following_id', $user->id)->exists()) {
            $me->followings()->detach($user->id);
        }

        if (request()->ajax()) {
            return response()->json([
                'following' => false,
                'followersCount' => $user->followers()->count(),
            ]);
        }

        return redirect()->back()->with('success', 'フォローを解除しました。');
    }

    public function followings(User $user)
    {
        $followings = $user->followings()->paginate(10);

        return view('posts.Userfollowings', compact('user', 'followings'));
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(10);

        return view('posts.Userfollower', compact('user', 'followers'));
    }
}
