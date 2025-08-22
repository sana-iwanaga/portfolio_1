{{-- resources/views/users/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }} さんのページ
        </h2>
    </x-slot>

    <div class="container py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <p>フォロー数: <span id="followingsCount">{{ $followingsCount }}</span></p>
        <p>フォロワー数: <span id="followersCount">{{ $followersCount }}</span></p>

        @if(auth()->check() && auth()->id() !== $user->id)
            <button id="followBtn" data-user="{{ $user->id }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                {{ $isFollowing ? 'フォロー解除' : 'フォローする' }}
            </button>
        @endif

        <hr class="my-4">

        <h2 class="text-lg font-bold mb-2">投稿一覧</h2>
        @forelse($bookreviews as $post)
            <div class="post border-b border-gray-200 py-2">
                <p>{{ $post->body }}</p>
                <small class="text-gray-500">{{ $post->created_at->format('Y/m/d H:i') }}</small>
            </div>
        @empty
            <p>投稿はありません。</p>
        @endforelse
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
