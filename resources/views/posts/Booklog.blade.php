<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ Auth::user()->name }} さんの読書ログ</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- ステータスの概要 --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-bold mb-2">読書ログ</h3>
            <ul>
                <li>未読: {{ $statusCounts['unread'] ?? 0 }} 冊</li>
                <li>読書中: {{ $statusCounts['reading'] ?? 0 }} 冊</li>
                <li>読了: {{ $statusCounts['read'] ?? 0 }} 冊</li>
            </ul>
        </div>

        {{-- 読書ログ一覧 --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-2">読書ログ一覧</h3>
            <ul>
                @forelse($latestBooklogs as $log)
                    <li class="mb-4 border-b pb-2">
                        <strong>{{ $log->title }}</strong>

                        {{-- ステータス＋メモ一括更新 --}}
                        <form action="{{ route('booklogs.update', $log->booklog_id) }}" method="POST" class="mt-1 inline">
                            @csrf
                            @method('PUT')

                            {{-- ステータス --}}
                            <label for="status-{{ $log->booklog_id }}">ステータス:</label>
                            <select name="status" id="status-{{ $log->booklog_id }}" class="border rounded p-1">
                                <option value="unread" {{ $log->status == 'unread' ? 'selected' : '' }}>未読</option>
                                <option value="reading" {{ $log->status == 'reading' ? 'selected' : '' }}>読書中</option>
                                <option value="read" {{ $log->status == 'read' ? 'selected' : '' }}>読了</option>
                            </select>

                            {{-- メモ --}}
                            <label for="memo-{{ $log->booklog_id }}" class="ml-2">メモ追加:</label>
                            <input type="text" name="memo" id="memo-{{ $log->booklog_id }}" class="border rounded p-1 w-64" placeholder="ここにメモを入力">

                            <button type="submit" class="ml-2 bg-green-500 text-white px-2 py-1 rounded">更新</button>
                        </form>

                        <a href="{{ route('booklogs.memos', $log->isbn) }}" class="text-blue-600 hover:underline mt-1 inline-block">過去のメモを見る</a>
                    </li>
                @empty
                    <li>まだ読書ログはありません</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>


