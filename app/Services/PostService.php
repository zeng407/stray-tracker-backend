<?php

namespace App\Services;

use App\Models\Post;
use App\Criterions\Post\PostTitleCriterion;
use DB;
use Storage;

class PostService
{
    public function getPosts(array $criteria, $page = 1, $perPage = 10)
    {
        $allowCriteria = [
            PostTitleCriterion::class,
        ];
        $query = Post::query();

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
}
