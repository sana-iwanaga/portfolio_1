<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            書籍検索
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 検索フォーム --}}
            <form method="GET" action="{{ route('research') }}" class="mb-6 space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $title ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">著者名</label>
                    <input type="text" name="author" value="{{ old('author', $author ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">出版社名</label>
                    <input type="text" name="publisherName" value="{{ old('publisherName', $publisherName ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $isbn ?? '') }}"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500">
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
                        @php $item = $book['Item']; @endphp
                        <div class="p-4 border rounded shadow-sm hover:shadow-md transition">
                            <h3 class="font-bold text-lg mb-2">
                                <a href="{{ route('books.book', ['isbn' => $item['isbn']]) }}"
                                   class="text-indigo-600 hover:underline">
                                    {{ $item['title'] }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-700 mb-1">著者: {{ $item['author'] ?? '不明' }}</p>
                            <p class="text-sm text-gray-600">{{ $item['publisherName'] ?? '出版社不明' }}</p>
                            @if (!empty($item['mediumImageUrl']))
                                <img src="{{ $item['mediumImageUrl'] }}" alt="表紙"
                                     class="mt-2 w-auto h-48 object-contain">
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


