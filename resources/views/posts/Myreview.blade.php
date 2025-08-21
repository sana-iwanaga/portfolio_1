<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">自分のレビュー</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">自分のレビュー一覧</h1>

        @if ($reviews->isEmpty())
            <p class="text-gray-500">まだレビューはありません。</p>
        @else
            @foreach ($reviews as $review)
                <div class="p-4 bg-white rounded shadow mb-4">
                    <h3 class="font-bold text-lg">
                        <a href="{{ route('books.book', $review->isbn, $review->book_id) }}" class="text-blue-600 hover:underline">
                            {{ $review->book_title }} - {{ $review->title }}</a>
                    </h3>
                    <p class="mt-2">評価: {{ str_repeat('★', $review->rating) }}</p>
                    <p class="mt-2">{{ $review->body }}</p>
                    <p class="text-gray-500 text-sm mt-1">投稿日: {{ $review->created_at->format('Y/m/d H:i') }}</p>

                    <!-- 削除ボタン -->
                    <form action="{{ route('reviews.destroy', $review->bookreview_id) }}" 
                          method="POST" 
                          onsubmit="return confirm('本当に削除しますか？');" 
                          class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                            削除
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>

