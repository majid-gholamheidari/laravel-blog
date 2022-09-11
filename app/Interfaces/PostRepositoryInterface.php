<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{

    /**
     * Create new post.
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * Get specific post.
     * @param $post
     * @return mixed
     */
    public function find($post);

    /**
     * Update specific post.
     * @param $post
     * @param array $data
     * @return mixed
     */
    public function update($post, array $data);

    /**
     * Delete specific post with its likes and comments.
     * @param $post
     * @return mixed
     */
    public function delete($post);
}
