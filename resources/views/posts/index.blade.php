<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-nowrap">
        <a href="{{ route('posts.create') }}"
            class="text-2xl text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            新規登録
        </a>
    </div>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">

        <x-flash-message :message="session('notice')" />

        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
            @foreach ($posts as $post)
                <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                    <a href="{{ route('posts.show', $post) }}">
                        <div class="flex flex-row-reverse justify-between">
                            <h2
                                class="inline font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                                {{ $post->user->name }}</h2>
                                
                            @can('update',$post)
                            <a href="{{ route('posts.edit', $post) }}"
                                class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                変更
                            </a>
                            @endcan
                        </div>
                    </a>
<div class="h-5"></div>
                    <a href="{{ route('posts.show', $post) }}">
                        <img class="w-full mb-2" src="{{ $post->image_url }}" alt="">
                        <h3>{{ $post->price }}円</h3>
                        <p class="text-gray-700 text-base">コメント：{{ Str::limit($post->body, 50) }}</p>
                        <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                            <span
                                class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                            {{ $post->created_at }}
                        </p>
                    </a>
                </article>
            @endforeach
        </div>
        {{ $posts->links() }}
    </div>
</x-app-layout>
