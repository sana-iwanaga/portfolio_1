<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レビュー検索
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 検索フォーム --}}
            <form action="{{ route('reviews.search') }}" method="GET" class="mb-6 space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">タイトル</label>
                    <input type="text" name="title" value="{{ request('title') }}"
                           placeholder="タイトルで検索"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">感情カテゴリ</label>
                    <select name="emotioncategory_id"
                            class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                        <option value="">すべての感情</option>
                        @foreach($emotioncategories as $category)
                            <option value="{{ $category->emotioncategory_id }}"
                                {{ request('emotioncategory_id') == $category->emotioncategory_id ? 'selected' : '' }}>
                                {{ $category->emotioncategory_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">本文</label>
                    <input type="text" name="body" value="{{ request('body') }}"
                           placeholder="本文で検索"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500">
                        検索
                    </button>
                </div>
            </form>

            {{-- 検索結果 --}}
            @if($reviews->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($reviews as $review)
                        <div class="p-4 border rounded shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-bold">{{ $review->user->name ?? '名無し' }}</p>
                                @if($review->emotioncategory)
                                    <span class="text-sm px-2 py-1 rounded bg-gray-200">{{ $review->emotioncategory->name }}</span>
                                @endif
                            </div>
                            <p>{{ $review->body }}</p>
                            <small class="text-gray-500 block mt-2">{{ $review->created_at->format('Y/m/d H:i') }}</small>
                        </div>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <p class="text-gray-500 mt-4">レビューは見つかりませんでした。</p>
            @endif

        </div>
    </div>
</x-app-layout>
