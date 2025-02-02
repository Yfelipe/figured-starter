<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get posts
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);

        //return collection as resource
        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $post = $request->isMethod('put') ? Post::findOrFail($request->post_id) : new Post;

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->author = $request->input('author');
        if ($request->isMethod('put')) {
            $post->_id = $request->input('post_id');
        }



        if($post->save()) {
            return new PostResource($post);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get post
        $post = Post::findOrFail($id);

        //Return single post
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get post
        $post = Post::findOrFail($id);

        if($post->delete()){
            return new PostResource($post);
        }
    }
}
