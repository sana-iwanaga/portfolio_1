<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レビュー検索
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        {{-- 検索フォーム --}}
        <form action="{{ route('reviews.search') }}" method="GET" class="mb-4 flex flex-wrap gap-2 items-center">

            <input type="text" name="title" placeholder="タイトルで検索"
                   value="{{ request('title') }}"
                   class="flex-grow border rounded px-2 py-1">

            <select name="emotioncategory_id" class="border rounded px-2 py-1">
                <option value="">すべての感情</option>
                @foreach($emotioncategories as $category)
                    <option value="{{ $category->emotioncategory_id }}"
                        {{ request('emotioncategory_id') == $category->emotioncategory_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="body" placeholder="本文で検索"
                   value="{{ request('body') }}"
                   class="flex-grow border rounded px-2 py-1">

            <button type="submit"
                    class="px-4 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                検索
            </button>
        </form>

        {{-- 検索結果 --}}
        @if($reviews->count())
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="border p-4 rounded shadow">
                        <div class="flex justify-between items-center mb-2">
                            <p class="font-bold">{{ $review->user->name ?? '名無し' }}</p>
                            @if($review->emotioncategory)
                                <span class="text-sm px-2 py-1 rounded bg-gray-200">{{ $review->emotioncategory->name }}</span>
                            @endif
                        </div>
                        <p>{{ $review->body }}</p>
                        <small class="text-gray-500">{{ $review->created_at->format('Y/m/d H:i') }}</small>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $reviews->withQueryString()->links() }}
            </div>
        @else
            <p>レビューは見つかりませんでした。</p>
        @endif

    </div>
</x-app-layout>

