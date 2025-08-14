<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ホーム</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-bold mb-2">読書ログの概要</h3>
            <ul>
                <li>未読: {{ $statusCounts['unread'] ?? 0 }} 冊</li>
                <li>読書中: {{ $statusCounts['reading'] ?? 0 }} 冊</li>
                <li>読了: {{ $statusCounts['read'] ?? 0 }} 冊</li>
            </ul>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-2">最近追加した本</h3>
            <ul>
                @forelse($latestBooklogs as $log)
                    <li>
                        <strong>{{ $log->title }}</strong> - ステータス: {{ $log->status_label }}
                    </li>
                @empty
                    <li>まだ読書ログはありません</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
