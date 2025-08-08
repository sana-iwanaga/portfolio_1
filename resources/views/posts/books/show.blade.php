{{-- resources/views/posts/books/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            書籍詳細
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $book['title'] ?? 'タイトル不明' }}</h1>
            <p class="mb-2">著者: {{ $book['author'] ?? '不明' }}</p>
            <p class="mb-2">出版社: {{ $book['publisherName'] ?? '不明' }}</p>
            <p class="mb-4">発売日: {{ $book['salesDate'] ?? '不明' }}</p>

            @if(!empty($book['largeImageUrl']))
                <img src="{{ $book['largeImageUrl'] }}" alt="書籍表紙" class="w-48 h-auto mb-4">
            @endif

            <p>{{ $book['itemCaption'] ?? '説明なし' }}</p>
        </div>
        {{-- 詳細画面の下あたりに追加 --}}

<div class="mt-6">
    <a href="{{ route('reviews.create', ['isbn' => $book['isbn'] ?? '']) }}"
       class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
        この本のレビューを書く
    </a>
</div>

    </div>
</x-app-layout>
