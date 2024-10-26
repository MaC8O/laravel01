<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // Display all posts
    public function index()
    {
        $posts = DB::table('posts')->get(); // Retrieve all posts
        return view('index', compact('posts')); 
    }

    // Show the form for creating new posts
    public function create()
    {
        return view('create'); // Changed to 'create'
    }

    // Store a newly created post
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Use DB facade to insert a new post
        DB::table('posts')->insert([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Show a specific post
    public function show($id)
    {
        $post = DB::table('posts')->where('id', $id)->first(); // Retrieve a post by ID

        if (!$post) {
            abort(404); // Handle case where post is not found
        }

        return view('show', compact('post')); // Changed to 'show'
    }

    // Show the form for editing an existing post
    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        if (!$post) {
            abort(404); // Handle case where post is not found
        }

        return view('edit', compact('post')); // Changed to 'edit'
    }

    // Update an existing post
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Use DB facade to update an existing post
        DB::table('posts')->where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    // Delete a post
    public function destroy($id)
    {
        DB::table('posts')->where('id', $id)->delete(); // Delete the post
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
