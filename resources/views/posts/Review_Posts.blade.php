<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レビュー投稿画面') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6" x-data="bookSearch()">
        <h1 class="text-2xl font-bold mb-4">Booklog - レビュー投稿</h1>

        <!-- 書籍検索 -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-1">書籍検索</label>
            <div class="flex gap-2">
                <input
                    type="text"
                    x-model="keyword"
                    placeholder="書名で検索"
                    class="border p-2 w-full"
                    @keyup.enter="searchBooks"
                >
                <!-- ↑ Enterキーでも検索できる -->
                <button
                    type="button"
                    @click="searchBooks"
                    class="bg-blue-600 text-white px-3 py-2 rounded"
                >検索</button>
            </div>

            <!-- 検索結果 -->
            <template x-if="results.length > 0">
                <ul class="mt-3 space-y-2">
                    <template x-for="book in results" :key="book.title">
                        <li class="border p-2 rounded hover:bg-gray-100">
                            <strong x-text="book.title"></strong><br>
                            著者：<span x-text="book.creator ?? '不明'"></span><br>
                            <button
                                type="button"
                                @click="selectBook(book)"
                                class="text-blue-500 text-sm mt-1"
                            >この本を選択</button>
                        </li>
                    </template>
                </ul>
            </template>
        </div>

        <!-- 投稿フォーム -->
        <form action="/posts" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="book" class="block text-sm font-medium text-gray-700">本</label>
                <input
                    type="text"
                    name="post[book]"
                    id="book"
                    x-model="selected.title"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    required
                >
            </div>

            <div>
                <label for="emotion_category" class="block text-sm font-medium text-gray-700">感情カテゴリ</label>
                <select
                    name="post[emotion_category]"
                    id="emotion_category"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                >
                    <option value="happy">嬉しい</option>
                    <option value="sad">悲しい</option>
                    <option value="angry">怒り</option>
                    <option value="laugh">笑える</option>
                    <option value="honwaka">ほんわか</option>
                </select>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                <input
                    type="text"
                    name="post[title]"
                    id="title"
                    placeholder="タイトル"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    required
                >
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">本文</label>
                <textarea
                    name="post[body]"
                    id="body"
                    placeholder="本文を入力してください。"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    rows="6"
                    required
                ></textarea>
            </div>

            <div>
                <input
                    type="submit"
                    value="保存"
                    class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 cursor-pointer"
                >
            </div>
        </form>

        <div class="mt-6">
            <a href="/" class="text-blue-500 hover:underline">マイページに戻る</a>
        </div>
    </div>

    <!-- Alpine.js の検索スクリプト -->
    <script>
        function bookSearch() {
            return {
                keyword: '',
                results: [],
                selected: {
                    title: '',
                    creator: '',
                },
                searchBooks() {
                    if (this.keyword.trim() === '') return;

                    fetch(`/books/quicksearch?q=${encodeURIComponent(this.keyword)}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data.map(item => ({
                                title: item.title || 'タイトル不明',
                                creator: item.creator || '不明',
                            }));
                        })
                        .catch(error => {
                            console.error('検索失敗:', error);
                            alert('検索に失敗しました。もう一度お試しください。');
                        });
                },
                selectBook(book) {
                    this.selected.title = book.title;
                    this.selected.creator = book.creator;
                    this.results = []; // 検索結果をクリア
                }
            }
        }
    </script>
</x-app-layout>