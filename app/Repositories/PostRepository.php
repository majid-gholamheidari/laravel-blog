<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements \App\Interfaces\PostRepositoryInterface
{

    /**
     * Create new post.
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return Post::create($data);
    }

    /**
     * @inheritDoc
     */
    public function find($post, $relations = [])
    {
        return Post::with($relations)->whereSlug($post)->firstOrFail();
    }

    /**
     * Update specific post.
     * @param $post
     * @param array $data
     * @return mixed
     */
    public function update($post, array $data)
    {
        $data['slug'] = null;
        $post->update($data);
        return $this->find($post->slug);
    }

    /**
     * Delete specific post with its likes and comments.
     * @param $post
     * @return mixed
     */
    public function delete($post)
    {
        return $post->delete();
    }
}
