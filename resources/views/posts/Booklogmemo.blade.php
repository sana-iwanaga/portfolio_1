<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }} の読書メモ
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        {{-- メモ一覧 --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">過去のメモ</h3>

            @if($book->memos->count())
                <ul class="space-y-2">
                    @foreach($book->memos as $memo)
                        <li class="border rounded p-2 bg-gray-50">
                            <span class="text-gray-500 text-sm">{{ $memo->created_at->format('Y-m-d H:i') }}</span>
                            <p class="text-gray-800">{{ $memo->content }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-400">まだメモはありません。</p>
            @endif
        </div>

        {{-- 新しいメモ追加 --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-2">新しいメモを追加</h3>
            <form action="{{ route('book.memos.store', $book->id) }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <textarea name="content" rows="3" class="border rounded p-2 w-full" placeholder="ここにメモを入力"></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-32">追加</button>
            </form>
        </div>
    </div>
</x-app-layout>
