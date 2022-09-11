<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeRepository implements \App\Interfaces\LikeRepositoryInterface
{

    /**
     * Create like for post.
     * @param Post $post
     * @param User $user
     * @return
     */
    public function likePost(Post $post, User $user)
    {
        $like = Like::where('likeable_id', $post->id)->where('user_id', $user->id)->first();

        if ( is_null($like) ) {
            $post->like()->create([
                'user_id' => $user->id
            ]);
            return true;
        }
        return false;
    }

    /**
     * Create like for post.
     * @param Post $post
     * @param User $user
     * @return bool
     */
    public function dislikePost(Post $post, User $user)
    {
        $like = Like::where('likeable_id', $post->id)->where('user_id', $user->id)->first();

        if ( !is_null($like) ) {
            $like->delete();
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function likeComment($post, User $user)
    {
        // TODO: Implement likeComment() method.
    }

    /**
     * @inheritDoc
     */
    public function dislikeComment($post, $user)
    {
        // TODO: Implement dislikeComment() method.
    }
}
