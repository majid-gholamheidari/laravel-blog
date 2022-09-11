<?php

namespace App\Interfaces;

use App\Models\Post;
use App\Models\User;

interface LikeRepositoryInterface
{

    /**
     * like post.
     * @param Post $post
     * @param User $user
     * @return mixed
     */
    public function likePost(Post $post, User $user);

    /**
     * dislike post.
     * @param $post
     * @param $user
     * @return mixed
     */
    public function dislikePost(Post $post, User $user);

    /**
     * like comment.
     * @param Post $post
     * @param User $user
     * @return mixed
     */
    public function likeComment($post, User $user);

    /**
     * dislike comment.
     * @param $post
     * @param $user
     * @return mixed
     */
    public function dislikeComment($post, $user);
}
