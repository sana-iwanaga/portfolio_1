@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }} さんのページ</h1>

    <div class="user-stats">
        <p>フォロー数: <span id="followings-count">{{ $followingsCount }}</span></p>
        <p>フォロワー数: <span id="followers-count">{{ $followersCount }}</span></p>
    </div>

    @if(auth()->check() && auth()->id() !== $user->id)
        <button 
            id="follow-btn" 
            class="btn btn-primary" 
            data-user-id="{{ $user->id }}">
            {{ $isFollowing ? 'フォロー解除' : 'フォローする' }}
        </button>
    @endif

    <hr>

    <h2>投稿一覧</h2>
    @forelse($posts as $post)
        <div class="post">
            <p>{{ $post->body }}</p>
            <small>{{ $post->created_at->format('Y/m/d H:i') }}</small>
        </div>
    @empty
        <p>投稿はありません。</p>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const followBtn = document.getElementById("follow-btn");

    if (followBtn) {
        followBtn.addEventListener("click", function () {
            const userId = followBtn.dataset.userId;
            const url = followBtn.textContent.trim() === "フォローする"
                ? `/follow/${userId}`
                : `/unfollow/${userId}`;

            axios.post(url, {}, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            }).then(response => {
                // ボタンの表示を切り替え
                if (response.data.following) {
                    followBtn.textContent = "フォロー解除";
                } else {
                    followBtn.textContent = "フォローする";
                }

                // フォロー数を更新
                document.getElementById("followings-count").textContent = response.data.followingsCount;
                document.getElementById("followers-count").textContent = response.data.followersCount;
            }).catch(error => {
                console.error(error);
            });
        });
    }
});
</script>
@endpush
