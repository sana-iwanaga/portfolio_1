<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            書籍検索
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 検索フォーム --}}
            <form method="GET" action="{{ route('Books_research') }}" class="mb-6">
                <div class="flex items-center space-x-4">
                    <input
                        type="text"
                        name="q"
                        value="{{ old('q', $query ?? '') }}"
                        placeholder="書籍タイトルなどを入力"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
                    >
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500"
                    >
                        検索
                    </button>
                </div>
            </form>

            {{-- エラーメッセージ --}}
            @isset($error)
                <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
                    {{ $error }}
                </div>
            @endisset

            {{-- 検索結果 --}}
            @if (!empty($books))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($books as $book)
                        <div class="p-4 border rounded shadow-sm hover:shadow-md transition">
                            <h3 class="font-bold text-lg mb-2">{{ $book['Item']['title'] }}</h3>
                            <p class="text-sm text-gray-700 mb-1">著者: {{ $book['Item']['author'] ?? '不明' }}</p>
                            <p class="text-sm text-gray-600">{{ $book['Item']['publisherName'] ?? '出版社不明' }}</p>
                            @if (!empty($book['Item']['mediumImageUrl']))
                                <img src="{{ $book['Item']['mediumImageUrl'] }}" alt="表紙" class="mt-2 w-auto h-48 object-contain">
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 mt-4">検索結果がありません。</p>
            @endif

        </div>
    </div>
</x-app-layout>
