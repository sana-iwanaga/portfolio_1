<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booklog;
use App\Models\BooklogMemo;

class BooklogController extends Controller
{
    public function booklogsall()
{
    // ログインユーザーの全読書ログ
    $allbooklogs = Booklog::where('user_id', Auth::id())->get();


    // 最新3件
    $latestBooklogs = Booklog::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();

    // ステータスごとの件数
    $statusCounts = Booklog::where('user_id', Auth::id())
                           ->selectRaw('status, count(*) as count')
                           ->groupBy('status')
                           ->pluck('count','status');

    return view('posts.Booklog', compact(
        'allbooklogs',
        'latestBooklogs',
        'statusCounts'
    ));
}


    public function store(Request $request)
    {
        $request->validate([
            'isbn'   => 'required|string|max:20',
            'title'  => 'required|string|max:255',
            'status' => 'required|in:unread,reading,read',
            'memo'   => 'nullable|string|max:1000',
        ]);

        $exist = Booklog::where('user_id', Auth::id())
            ->where('isbn', $request->isbn)
            ->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'この本のログはすでに登録されています。');
        }

        Booklog::create([
            'user_id' => Auth::id(),
            'isbn'    => $request->isbn,
            'title'   => $request->title,
            'status'  => $request->status,
        ]);

        return redirect()->route('booklogs.index')->with('success', 'Booklog created successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unread,reading,read',
        ]);


        $booklog = Booklog::where('user_id', Auth::id())
                          ->where('booklog_id', $id)
                          ->firstOrFail();
        $booklog->status = $request->status;
        $booklog->save();


        return back()->with('success', 'ステータスを更新しました');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unread,reading,read',
            'memo'   => 'nullable|string|max:1000',
        ]);

        $booklog = Booklog::where('user_id', Auth::id())
                          ->where('booklog_id', $id)
                          ->firstOrFail();
        $booklog->status = $request->status;
        $booklog->save();
        if ($request->filled('memo')) {
            $booklog->memo->create([
                'booklog_id' => $booklog->booklog_id,
                'memo'       => $request->memo,
            ]);
        }

        return back()->with('success', '読書ログを更新しました');
    }

    public function storeMemo(Request $request, $id)
    {
        $request->validate([
            'memo' => 'required|string|max:1000',
        ]);

        $booklog = Booklog::where('user_id', Auth::id())
                          ->where('booklog_id', $id)
                          ->firstOrFail();

        BooklogMemo::create([
            'booklog_id' => $booklog->booklog_id,
            'memo'       => $request->memo,
        ]);

        return back()->with('success', 'メモを追加しました');
    }

    public function destroy($id)
    {
        $log = Booklog::where('user_id', Auth::id())
                      ->where('booklog_id', $id)
                      ->firstOrFail();

        $log->delete();

        return back()->with('success', '読書ログを削除しました');
    }

    public function allmemo($isbn)
    {
        $booklog = Booklog::where('user_id', Auth::id())
            ->where('isbn', $isbn)
            ->firstOrFail();

        $booklogmemos = $booklog->memos()->orderBy('created_at', 'desc')->get();

        return view('posts.Booklogmemo', compact('booklog', 'booklogmemos'));
    }

}
