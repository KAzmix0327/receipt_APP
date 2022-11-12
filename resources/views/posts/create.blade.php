<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">登録</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="body">
                    名前
                </label>
                <textarea name="name" rows="1"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3"
                    required>{{ old('name') }}</textarea>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="title">
                        金額
                    </label>
                    <input type="number" name="price"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3"
                        required placeholder="" value="{{ old('price') }}">円
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="body">
                        コメント
                    </label>
                    <textarea name="body" rows="10"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                        required>{{ old('body') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="image">
                        領収書画像
                    </label>
                    <input type="file" name="image" class="border-gray-300">
                </div>

                <div class="flex justify-around">
                <input type="submit" value="登録"
                    class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <div class="w-20"></div>
                <a href="{{ route('posts.index') }}"
                class="block text-center w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">キャンセル</a> 
                </div>
        </form>
    </div>
</x-app-layout>
