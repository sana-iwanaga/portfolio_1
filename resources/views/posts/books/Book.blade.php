{{-- resources/views/posts/books/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            書籍詳細
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">

        {{-- 書籍情報 --}}
        <div class="bg-white shadow rounded p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $apibook['title'] ?? 'タイトル不明' }}</h1>
            <p class="mb-2">著者: {{ $apibook['author'] ?? '不明' }}</p>
            <p class="mb-2">出版社: {{ $apibook['publisherName'] ?? '不明' }}</p>
            <p class="mb-4">ISBN: {{ $apibook['isbn'] ?? '不明' }}</p>

            @if(!empty($apibook['largeImageUrl']))
                <img src="{{ $apibook['largeImageUrl'] }}" alt="書籍表紙" class="w-48 h-auto mb-4">
            @endif

            <p>{{ $apibook['itemCaption'] ?? '説明なし' }}</p>
        </div>

        {{-- レビュー作成リンク --}}
        <div class="mt-6">
            <a href="{{ route('reviews.create', ['isbn' => $apibook['isbn'] ?? '']) }}"
               class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                この本のレビューを書く
            </a>
        </div>

        {{-- 読書ログ追加 --}}
        <div class="mt-4">
            <form action="{{ route('booklogs.store') }}" method="POST">
                @csrf
                <input type="hidden" name="isbn" value="{{ $apibook['isbn'] ?? '' }}">
                <input type="hidden" name="title" value="{{ $apibook['title'] ?? '' }}">

                <label for="status" class="block mb-1 font-medium">ステータスを選択：</label>
                <select name="status" id="status" class="border rounded px-2 py-1 mb-2">
                    <option value="unread">未読</option>
                    <option value="reading">読書中</option>
                    <option value="read">読了</option>
                </select>

                <button type="submit"
                        class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                    読書ログに追加
                </button>
            </form>
        </div>

        {{-- レビュー一覧 --}}
        <div class="bg-white shadow rounded p-6 mt-6">
            <h3 class="text-lg font-bold mb-4">レビュー一覧</h3>

            @forelse($reviews as $review)
                <div class="border-b border-gray-200 py-2">
                    <p>
                        <strong>{{ $review->user->name ?? '名無し' }}</strong> - 感情: {{ $review->emotionCategory->emotioncategory_name ?? '不明' }}
                        @if($review->rating)
                            - 評価: {{ str_repeat('★', $review->rating) }}
                        @endif
                    </p>
                    <p>{{ $review->body }}</p>

                    {{-- いいねボタン --}}
                    @auth
                        <button class="like-button text-blue-500 hover:underline"
                                data-review-id="{{ $review->bookreview_id }}">
                            いいね (<span class="likes-count">{{ $review->likes->count() }}</span>)
                        </button>
                    @else
                        <span class="text-gray-400">いいね ({{ $review->likes->count() }})</span>
                    @endauth
                </div>
            @empty
                <p>まだレビューはありません。</p>
            @endforelse
        </div>

    </div>

    {{-- Ajax いいね処理 --}}
    <script>
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.dataset.reviewId;
                const span = this.querySelector('.likes-count');

                fetch(`/reviews/${reviewId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        span.textContent = data.likes_count;
                    }
                })
                .catch(err => console.error(err));
            });
        });
    </script>

</x-app-layout>

