<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            レビュー検索
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 検索フォーム --}}
            <form action="{{ route('reviews.search') }}" method="GET" class="mb-6 space-y-4">
                
                {{-- タイトル検索 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">タイトル</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ request('title') }}"
                        placeholder="タイトルで検索"
                        class="w-full rounded-lg border px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200"
                    >
                </div>

                {{-- 感情カテゴリ --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">感情カテゴリ</label>
                    <select 
                        name="emotioncategory_id"
                        class="w-full rounded-lg border px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200"
                    >
                        <option value="">すべての感情</option>
                        @foreach($emotioncategories as $category)
                            <option 
                                value="{{ $category->emotioncategory_id }}"
                                {{ request('emotioncategory_id') == $category->emotioncategory_id ? 'selected' : '' }}
                            >
                                {{ $category->emotioncategory_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 本文検索 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">本文</label>
                    <input 
                        type="text" 
                        name="body" 
                        value="{{ request('body') }}"
                        placeholder="本文で検索"
                        class="w-full rounded-lg border px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200"
                    >
                </div>

                {{-- 検索ボタン --}}
                <div>
                    <button 
                        type="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500"
                    >
                        検索
                    </button>
                </div>
            </form>

            {{-- 検索結果 --}}
            @if($reviews->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @foreach($reviews as $review)
                        <div class="rounded border p-4 shadow-sm transition hover:shadow-md">
                            {{-- カテゴリを右上に --}}
                            @if($review->emotioncategory)
                                <div class="mb-2 text-right">
                                    <span class="rounded bg-gray-200 px-2 py-1 text-sm">
                                        {{ $review->emotioncategory->emotioncategory_name }}
                                    </span>
                                </div>
                            @endif

                            {{-- タイトル --}}
                            <h3 class="mb-1 text-lg font-bold">
                                <a 
                                    href="{{ route('books.book', ['isbn' => $review->isbn, 'book_id' => $review->book_id]) }}"
                                    class="text-indigo-600 hover:underline"
                                >
                                    {{ $review->book_title }} - {{ $review->title }}
                                </a>
                            </h3>

                            {{-- ユーザー名を小さいラベルで --}}
                            <span class="mb-2 inline-block rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-600">
                                {{ $review->user->name ?? '名無し' }}
                            </span>

                            {{-- 本文 --}}
                            <p class="mt-2">{{ $review->body }}</p>

                            {{-- 投稿日 --}}
                            <small class="mt-2 block text-gray-500">
                                {{ $review->created_at->format('Y/m/d H:i') }}
                            </small>
                        </div>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <p class="mt-4 text-gray-500">レビューは見つかりませんでした。</p>
            @endif

        </div>
    </div>
</x-app-layout>
