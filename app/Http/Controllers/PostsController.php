<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Posts::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function search(string $slug = null)
    {
        return $slug ? Posts::where("slug","like",'%'.$slug.'%')->get(): ["Post not found"];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'title'=>'required|string|max:100',
                'body'=>'required|string|max:100'
            ]
        );
        $post = new Posts();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = Str::slug($request->title, "-");
        return $post->save() ? ["Post saved"] : ["Error saving post"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        return $id ? Posts::find($id): ["Post not found"];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = null)
    {
        //
        $request->validate(
            [
                'title'=>'string|max:100',
                'body'=>'string|max:100'
            ]
        );
        $msg = ["Null id"];
        $post = Posts::find($id);
        if ($post)
        {
            $msg = $post->update($request->all()) ? ["Post updated"] : ["Post Update failed"];
        }
        else
        {
            $msg = ["Post not found"];
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id = null)
    {
        //
        $msg = ["Null id"];
        $post = Posts::find($id);
        if($post)
        {
            $msg = $post->delete($id) ? ["Post Deleted"] : ["Post Delete Failed"];
        }
        else
        {
            $msg = ["Post not found"];
        }
        
        return $msg;
    }
}
