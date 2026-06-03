<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'content' => 'required|string',
        'image'   => 'nullable|image|max:2048',
        'status'  => 'nullable|string'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Post::create([
         'user_id'    => Auth::id(),
        'title'      => 'Registrar Office',
        'content'    => $request->content,
        'image_path' => $imagePath,
        'status'     => $request->status ?? 'Published',
        'posted_at'  => now(),
        ]);

        return response()->json(['message' => 'Post uploaded successfully']);
    }
  public function fetch(Request $request) {
    $query = Post::with('user')->orderBy('posted_at', 'desc');

    // Only show Published posts to normal users
    if (Auth::user()->role !== 'admin') {
        $query->where('status', 'Published');
    }

    $posts = $query->get()->map(function($post) {
        // Add full URL for images if they exist
        $post->image_url = $post->image_path ? asset('storage/'.$post->image_path) : null;
        return $post;
    });

    return response()->json($posts);
}

}

