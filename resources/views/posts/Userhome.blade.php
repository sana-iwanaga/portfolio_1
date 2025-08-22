@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }} さんのページ</h1>

    <p>フォロー数: <span id="followingsCount">{{ $followingsCount }}</span></p>
    <p>フォロワー数: <span id="followersCount">{{ $followersCount }}</span></p>

    @if(auth()->check() && auth()->id() !== $user->id)
        <button id="followBtn" data-user="{{ $user->id }}">
            {{ $isFollowing ? 'フォロー解除' : 'フォローする' }}
        </button>
    @endif

    <hr>
    <h2>投稿一覧</h2>
    @forelse($bookreviews as $post)
        <div class="post">
            <p>{{ $post->body }}</p>
            <small>{{ $post->created_at->format('Y/m/d H:i') }}</small>
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
        // 現在のボタン文字で判断
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
            // ボタン切替
            btn.textContent = data.following ? 'フォロー解除' : 'フォローする';
            // フォロワー数更新
            document.getElementById('followersCount').textContent = data.followersCount;
        });
    });
});
</script>
@endsection
