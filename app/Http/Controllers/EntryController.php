<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Request $request)
    {
        $entry = new Entry([
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
            'status' => 1,
        ]);

        $entry ->save();

        return redirect()->route('posts.show', $post);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return redirect()->route('posts.show', $post);
    }
}
