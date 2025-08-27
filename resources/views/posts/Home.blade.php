<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ホーム</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- 読書ログと最近追加した本 -->
        <div class="bg-white shadow rounded p-6">
            <!-- 読書ログの概要 -->
            <h3 class="text-lg font-bold mb-2">{{ Auth::user()->name }} さんの読書ログ
            </h3>
            <ul class="list-none list-inside">
                <li>未読: {{ $statusCounts['unread'] ?? 0 }} 冊</li>
                <li>読書中: {{ $statusCounts['reading'] ?? 0 }} 冊</li>
                <li>読了: {{ $statusCounts['read'] ?? 0 }} 冊</li>
            </ul>

            <!-- 最近追加した本 -->
            <h3 class="text-lg font-bold mt-6 mb-2">最近追加した本</h3>
            <ul class="list-none list-inside">
                @forelse($latestBooklogs as $log)
                    <li>
                        <strong>{{ $log->title }}</strong> - ステータス: {{ $log->status_label }}
                    </li>
                @empty
                    <li>まだ読書ログはありません</li>
                @endforelse
            </ul>
            <div class="mt-4 text-right">
                <a href="{{ route('booklogs.index') }}" class="text-blue-500 hover:underline">
                    もっと見る（自分の読書ログ一覧へ）
                </a>
            </div>
        </div>

        <!-- 最近追加したレビュー -->
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-2">最近追加したレビュー</h3>
            <ul class="list-none list-inside">
                @forelse($latestBookreviews as $log)
                    <li>
                        <strong>{{ $log->book_title }}</strong> : {{ $log->title }} - {{ $log->body }}
                    </li>
                @empty
                    <li>まだレビューはありません</li>
                @endforelse
            </ul>
            <div class="mt-4 text-right">
                <!-- 安全にするならGETリンク -->
                <a href="{{ route('reviews.my') }}" class="text-blue-500 hover:underline">
                    もっと見る（自分のレビュー一覧へ）
                </a>
            </div>
        </div>

    </div>
</x-app-layout>

