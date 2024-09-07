<?php

namespace App\Services;

use App\Models\Post;
use App\Criterions\Post\PostTitleCriterion;
use App\Criterions\Post\PostCityCriterion;
use App\Criterions\Post\PostDistrictCriterion;
use App\Criterions\PostReply\PostIdCriterion;
use App\Helpers\Locker;
use App\Models\PostReply;
use DB;
use Storage;

class PostService
{
    public function getPosts(array $criteria, $page = 1, $perPage = 10)
    {
        $allowCriteria = [
            PostTitleCriterion::class,
            PostCityCriterion::class,
            PostDistrictCriterion::class,
        ];
        $query = Post::query()->orderBy('created_at', 'desc');

        if(!empty($criteria)) {
            foreach($criteria as $key => $value) {
                foreach($allowCriteria as $criterion) {
                    if($criterion::getKey() == $key) {
                        $criterion::apply($query, $value);
                    }
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getPostReplies(array $criteria, $page = 1, $perPage = 10)
    {
        $allowCriteria = [
            PostIdCriterion::class,
        ];
        $query = PostReply::query();

        if(!empty($criteria)) {
            foreach($criteria as $key => $value) {
                foreach($allowCriteria as $criterion) {
                    if($criterion::getKey() == $key) {
                        $criterion::apply($query, $value);
                    }
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function createPost(array $data)
    {
        DB::transaction(function() use ($data, &$post) {
            $post = Post::create($data);

            if(isset($data['files'])) {
                foreach($data['files'] as $file) {
                    $path = $file->store('public/files');
                    $url = Storage::url($path);
                    $post->files()->create([
                        'path' => $path,
                        'url' => $url,
                    ]);
                }
            }
        });

        return $post;
    }

    public function updatePost(Post $post, array $data)
    {
        DB::transaction(function() use ($data, &$post) {
            $post = Post::create($data);

            if(isset($data['new_files'])) {
                foreach($data['new_files'] as $file) {
                    $path = $file->store('public/files');
                    $url = Storage::url($path);
                    $post->files()->create([
                        'path' => $path,
                        'url' => $url,
                    ]);
                }
            }

            if(isset($data['deleted_files'])) {
                $files = $post->files()->whereIn('path', $data['deleted_files'])->get();
                foreach($files as $file) {
                    Storage::delete($file->path);
                    $file->delete();
                }
            }
        });

        return $post;
    }

    public function createReply(Post $post, array $data)
    {
        DB::transaction(function() use ($post, $data, &$reply) {
            // lock for update
            $count = Locker::lockForCountPostReplies($post);
            $floor = $count + 1;
            $reply = $post->post_replies()->create($data + [
                'floor' => $floor,
            ]);

            if(isset($data['files'])) {
                foreach($data['files'] as $file) {
                    $path = $file->store('public/files');
                    $url = Storage::url($path);
                    $reply->files()->create([
                        'path' => $path,
                        'url' => $url,
                    ]);
                }
            }
        });

        return $reply;
    }
}
