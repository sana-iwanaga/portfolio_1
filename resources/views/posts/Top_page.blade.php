<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('トップページ') }}
        </h2>
    </x-slot>
<body>
<h1>Booklog</h1>
<div class='posts'>
@foreach ($posts as $post)
<div class='post'>
<h2 class='title'>{{ $post->title }}</h2>
<p class='body'>{{ $post->body }}</p>
</div>
@endforeach
</div>
</body>
</html>
</x-app-layout>