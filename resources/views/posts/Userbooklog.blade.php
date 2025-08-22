@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }} さんのページ</h1>

    <div class="user-stats">
        <p>フォロー数: {{ $followingsCount }}</p>
        <p>フォロワー数: {{ $followersCount }}</p>
    </div>

    @if(auth()->check() && auth()->id() !== $user->id)
        @if($isFollowing)
            <form action="{{ route('unfollow', $user) }}" method="POST">
                @csrf
                <button type="submit">フォロー解除</button>
            </form>
        @else
            <form action="{{ route('follow', $user) }}" method="POST">
                @csrf
                <button type="submit">フォローする</button>
            </form>
        @endif
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
