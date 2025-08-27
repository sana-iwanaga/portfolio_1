<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $booklog->title }} の読書メモ一覧
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        {{-- 過去のメモ --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">過去のメモ</h3>

            @if($booklogmemos->count())
                <ul class="space-y-2">
                    @foreach($booklogmemos as $memo)
                        <li class="border rounded p-2 bg-gray-50">
                            <span class="text-gray-500 text-sm">
                                {{ $memo->created_at->format('Y-m-d H:i') }}
                            </span>
                            <p class="text-gray-800">{{ $memo->content }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-400">まだメモはありません。</p>
            @endif
        </div>
    </div>
</x-app-layout>
