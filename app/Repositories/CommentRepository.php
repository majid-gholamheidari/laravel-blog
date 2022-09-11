<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentRepository implements CommentRepositoryInterface
{

    /**
     * Create comment for specific post.
     * @param Post $post
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Post $post, array $data)
    {
        return $post->comment()->create($data);
    }

    /**
     * Change status of comment ot rejected.
     * @param Comment $comment
     * @param User $author
     * @return bool
     */
    public function reject(Comment $comment, User $author)
    {
        $comment->status = Comment::REJECTED_STATUS;
        return $comment->save();
    }

    /**
     * Change status of comment ot accepted.
     * @param Comment $comment
     * @param User $author
     * @return bool
     */
    public function accept(Comment $comment, User $author)
    {
        $comment->status = Comment::ACCEPTED_STATUS;
        return $comment->save();
    }

    /**
     * Get specific comment.
     * @param $comment
     * @return mixed
     */
    public function find($comment)
    {
        return Comment::findOrFail($comment);
    }
}
