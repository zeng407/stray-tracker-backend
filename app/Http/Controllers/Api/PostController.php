<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\PostService;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $criteria = $request->validate([
            'title' => 'nullable|string|max:30',
            'country' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'district' => 'nullable|string|max:30',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer|max:30',
        ]);

        logger($criteria);
        $posts = $this->postService->getPosts($criteria, $criteria['page'] ?? 1, $criteria['per_page'] ?? 10);

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'district' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:100',
            'gps_latitude' => 'nullable|numeric',
            'gps_longitude' => 'nullable|numeric',
            'files' => 'nullable|array|max:10',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg|max:8192', // todo: modify uplaod size in php.ini
        ]);

        logger($data);
        $post = $this->postService->createPost($data);

        return PostResource::make($post);
    }
}
