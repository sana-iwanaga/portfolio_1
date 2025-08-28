<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ $user->name }} さんがフォローしている人
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 space-y-4">
        @forelse($followings as $following)
            <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow">
                {{-- アイコン（名前の頭文字） --}}
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-lg font-bold text-white">
                        {{ mb_substr($following->name, 0, 1) }}
                    </div>
                    <a href="{{ route('users.show', $following->id) }}" 
                       class="font-bold text-gray-800 hover:underline">
                        {{ $following->name }}
                    </a>
                </div>

                {{-- フォローボタン --}}
                @if(Auth::check() && Auth::id() !== $following->id)
                    @if(Auth::user()->followings->contains($following->id))
                        <form action="{{ route('users.unfollow', $following->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-gray-300 text-gray-800 px-4 py-1 rounded-full">
                                フォロー中
                            </button>
                        </form>
                    @else
                        <form action="{{ route('users.follow', $following->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-full">
                                フォロー
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500">まだ誰もフォローしていません。</p>
        @endforelse

        <div class="mt-6">
            {{ $followings->links() }}
        </div>
    </div>
</x-app-layout>
