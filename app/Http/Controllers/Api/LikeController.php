<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LikeResource;
use App\Interfaces\LikeRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private LikeRepositoryInterface $likeRepository;
    private PostRepositoryInterface $postRepository;

    public function __construct(LikeRepositoryInterface $likeRepository, PostRepositoryInterface $postRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Create like for post.
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function likePost($post)
    {
        $post = $this->postRepository->find($post);
        $user = auth('api')->user();
        $result = $this->likeRepository->likePost($post, $user);
        if ($result) {
            return $this->response([], 200, 'The item has been successfully saved in your favorites.');
        }
        return $this->response([], 200, 'The item has already been saved in your favorites.');
    }

    /**
     * remove like from post.
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikePost($post)
    {
        $post = $this->postRepository->find($post);
        $user = auth('api')->user();
        $result = $this->likeRepository->dislikePost($post, $user);

        if ($result) {
            return $this->response([], 200, 'The item has been successfully removed from your favorites.');
        }
        return $this->response([], 200, 'The item is not available in your favorites.');
    }
}
