<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // * 1. UPLOAD IMAGE
        $image = $request->image->store('posts');
        // * 2. CREATE THE POST
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'publish_at' => $request->publish_at,
            'category_id' => $request->category
        ]);
        // * 3. FLASH Message
        session()->flash('success', 'Post trashed successfully');
        // * 4. REDIRECT USER
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->all(['title', 'description', 'publish_at', 'content']);
        // * check if new image
        if($request->hasFile('image')) {
             $image = $request->image->store('posts');
            //  Storage::delete($post->image);
             $post->deleteImage();
             $data['image'] = $image;
        }   

        $post->update($data);
        session()->flash('success', 'Post update successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        
        if($post->trashed())
        {
            // Storage::delete($post->image);
            $post->deleteImage();
            $post->forceDelete();
        } else {
            $post->delete();
        }

        session()->flash('success', 'Post deleted successfully');
        return redirect(route('posts.index'));

    }

     /**
     * Display the the list of all trashed posts.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();
        session()->flash('success', 'Post restore successfully');
        return redirect()->back();
    }
}
