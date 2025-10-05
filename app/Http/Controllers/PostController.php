<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\CigarettesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;
    protected $cigarettesService;

    public function __construct(PostService $postService, CigarettesService $cigarettesService)
    {
        $this->postService = $postService;
        $this->cigarettesService = $cigarettesService;
    }

    // Add this method to show the create post form
    public function create()
    {
        return view('posts.create');
    }

    public function index(Request $request)
    {
        $posts = $this->postService->getPublishedPosts($request);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'cigarette_id' => 'required|exists:cigarettes,id',
            'rating' => 'required|integer|between:1,5',
            'cigarettes_count' => 'sometimes|integer|min:1|max:10',
        ]);

        $user = Auth::user();
        $result = $this->postService->createPost($request->all(), $user);

        if ($result['success']) {
            return response()->json($result, 201);
        }

        return response()->json($result, $result['code']);
    }

    public function show($id)
    {
        $post = $this->postService->find($id);

        if (!$post || $post->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $post->load(['user', 'cigarette.brand']);

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string|min:10',
            'rating' => 'sometimes|integer|between:1,5',
        ]);

        $post = $this->postService->find($id);
        if (!$post || $post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $result = $this->postService->update($id, $request->all());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $this->postService->find($id)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update post'
        ], 400);
    }

    public function destroy($id)
    {
        $post = $this->postService->find($id);
        if (!$post || $post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $result = $this->postService->delete($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete post'
        ], 400);
    }

    public function getUserPosts()
    {
        $user = Auth::user();
        $posts = $this->postService->getUserPosts($user->id);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function getByCigarette($cigaretteId)
    {
        $posts = $this->postService->getPostsByCigarette($cigaretteId);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
}