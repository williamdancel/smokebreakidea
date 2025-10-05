<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService extends BaseService
{
    protected $model = Post::class;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function createPost(array $data, User $user): array
    {
        try {
            $post = $this->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $user->id,
                'cigarette_id' => $data['cigarette_id'],
                'cigarettes_count' => $data['cigarettes_count'] ?? 1,
                'rating' => $data['rating'],
                'status' => 'published',
                'is_from_non_registered_user' => false,
            ]);

            $post->load(['user', 'cigarette.brand']);

            return $this->successResponse($post, 'Post created successfully!', 201);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create post: ' . $e->getMessage());
        }
    }

    public function getUserPosts(int $userId)
    {
        return $this->model->with(['cigarette.brand'])
                          ->where('user_id', $userId)
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

     public function getPublishedPosts(Request $request): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'cigarette.brand'])
                            ->where('status', 'published');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('body', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%");
            });
        }

        // Sorting functionality
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc')
                          ->orderBy('created_at', 'desc');
                    break;
                case 'cigarettes':
                    $query->orderBy('cigarettes_count', 'desc')
                          ->orderBy('created_at', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->per_page ?? 9;
        return $query->paginate($perPage);
    }

    public function getPostsByCigarette(int $cigaretteId)
    {
        return $this->model->with(['user', 'cigarette.brand'])
                          ->where('cigarette_id', $cigaretteId)
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
}