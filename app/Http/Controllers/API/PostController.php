<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::latest()->paginate($request->per_page);
        return response()->json($posts);
        // return view('posts.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post($request->all());
        // $post->user_id = $request->user()->id;
        // $post->user_id = $request->user()->id;
        $post->user_id = 1;
        $file = $request->file('image');
        $post->image = self::createFilename($file);

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $post->save();

            // 画像アップロード
            if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            // return back()->withInput()->withErrors($e->getMessage());
            logger($e->getMessage());
            return response(status: 500);
        }

        // return redirect()
        //     ->route('posts.show', $post)
        //     ->with('notice', '記事を登録しました');
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $post = Post::with(['user'])->find($id);
        // $post = Post::with(['user'])->find($post->id);
        // $comments = $post->comments()->latest()->get()->load(['user']);
        $post->load('comments');
        // return view('posts.show', compact('post', 'comments'));
        // return response()->json(compact('post', 'comments'));
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // $post = Post::find($id);

        // if ($request->user()->cannot('update', $post)) {
        //     return redirect()->route('posts.show', $post)
        //         ->withErrors('自分の記事以外は更新できません');
        // }

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $post->image_path;
            $post->image = self::createFilename($file);
        }
        $post->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $post->save();

            if ($file) {
                // 画像アップロード
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                // 画像削除
                if (!Storage::delete($delete_file_path)) {
                    //アップロードした画像を削除する
                    Storage::delete($post->image_path);
                    //例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            // return back()->withInput()->withErrors($e->getMessage());
            logger($e->getMessage());
            return response(status: 500);
        }

        // return redirect()->route('posts.show', $post)
        //     ->with('notice', '記事を更新しました');
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // $post = Post::find($id);

        // トランザクション開始
        DB::beginTransaction();
        try {
            $post->delete();

            // 画像削除
            if (!Storage::delete($post->image_path)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの削除に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
        logger($e->getMessage());
        return response(status: 500);
        }

        // return redirect()->route('posts.index')
        //     ->with('notice', '記事を削除しました');
        return response()->json($post, 204);
    }

    private static function createFilename($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
