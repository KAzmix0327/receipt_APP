<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // public function index(Post $post)
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $comment = new Comment($request->all());
        // $comment->user_id = $request->user()->id;
        $comment->user_id = 1;
        $comment->post_id = $post->id;

        try {
            // 登録
            $comment->save();
        } catch (\Throwable $th) {
            // return back()->withInput()->withErrors($th->getMessage());
            logger($th->getMessage());
            return response('', 500);
        }

        // return redirect()->route('posts.show', $post)
        //     ->with('notice', 'コメントを登録しました');
        return response($comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        // if ($request->user()->cannot('update', $comment)) {
        //     return redirect()->route('posts.show', $post)
        //         ->withErrors('自分のコメント以外は更新できません');
        // }

        $comment->fill($request->all());

        try {
            // 登録
            $comment->save();
        } catch (\Throwable $th) {
            // return back()->withInput()->withErrors($th->getMessage());
            logger($th);
            return response('', 500);
        }

        // return redirect()->route('posts.show', $post)
        //     ->with('notice', 'コメントを更新しました');
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        // if ($request->user()->cannot('delete', $comment)) {
        //     return redirect()->route('posts.show', $post)
        //         ->withErrors('自分のコメント以外は削除できません');
        // }
        try {
            // 登録
            $comment->delete();
        } catch (\Throwable $th) {
            // return back()->withInput()->withErrors($th->getMessage());
            logger($th);
            return response('', 500);
        }

        // return redirect()->route('posts.show', $post)
        //     ->with('notice', 'コメントを削除しました');
        return response('', 204);
    }
}
