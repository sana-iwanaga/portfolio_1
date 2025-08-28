{{-- resources/views/Userhome.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }} さんのページ
        </h2>
    </x-slot>

    <div class="container py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">

        {{-- プロフィールエリア --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-bold">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold">{{ $user->name }}</h3>

                    {{-- フォロー・フォロワー数リンク --}}
                    <div class="text-sm text-gray-600 space-x-4 mt-1">
                        <a href="{{ route('users.followings', $user->id) }}" class="hover:underline">
                            フォロー: <span id="followingsCount">{{ $followingsCount }}</span>
                        </a>
                        <a href="{{ route('users.followers', $user->id) }}" class="hover:underline">
                            フォロワー: <span id="followersCount">{{ $followersCount }}</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- フォローボタン --}}
            @if(auth()->check() && auth()->id() !== $user->id)
                <button id="followBtn" data-user="{{ $user->id }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-500 transition">
                    {{ $isFollowing ? 'フォロー解除' : 'フォローする' }}
                </button>
            @endif
        </div>

        <hr class="my-4">

        {{-- 投稿一覧 --}}
        <h2 class="text-lg font-bold mb-4">投稿一覧</h2>
        <div class="space-y-4">
            @forelse($bookreviews as $post)
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
                    {{-- 投稿ヘッダー --}}
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $post->title }}</h3>
                        <small class="text-gray-400 text-sm">{{ $post->created_at->format('Y/m/d H:i') }}</small>
                    </div>

                    {{-- 書籍タイトル --}}
                    <p class="text-sm text-gray-500 mb-3">書籍: {{ $post->book_title }}</p>

                    {{-- 投稿本文 --}}
                    <p class="text-gray-700">{{ $post->body }}</p>
                </div>
            @empty
                <p class="text-center text-gray-500">投稿はありません。</p>
            @endforelse
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('followBtn');
        if (!btn) return;

        btn.addEventListener('click', function() {
            const userId = btn.dataset.user;
            const action = btn.textContent.includes('解除') ? 'unfollow' : 'follow';

            fetch(`/users/${userId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.textContent = data.following ? 'フォロー解除' : 'フォローする';
                document.getElementById('followersCount').textContent = data.followersCount;
            });
        });
    });
    </script>
</x-app-layout>

