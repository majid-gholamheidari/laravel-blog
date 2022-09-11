<?php

namespace App\Interfaces;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

interface CommentRepositoryInterface
{
    /**
     * Create Comment for post.
     * @param Post $post
     * @param array $data
     * @return mixed
     */
    public function store(Post $post, array $data);

    /**
     * Reject specific comment.
     * @param Comment $comment
     * @param User $author
     * @return mixed
     */
    public function reject(Comment $comment, User $author);

    /**
     * Accept specific comment.
     * @param Comment $comment
     * @param User $author
     * @return mixed
     */
    public function accept(Comment $comment, User $author);

    /**
     * Get specific comment.
     * @param $comment
     * @return mixed
     */
    public function find($comment);
}
