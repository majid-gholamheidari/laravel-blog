<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentRequest;
use App\Http\Resources\Api\CommentResource;
use App\Interfaces\CommentRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;

class CommentController extends Controller
{

    private CommentRepositoryInterface $commentRepository;
    private PostRepositoryInterface $postRepository;
    public function __construct(CommentRepositoryInterface $commentRepository, PostRepositoryInterface $postRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Create comment for post.
     * @param $post
     * @return
     */
    public function store($post, CommentRequest $request)
    {
        $post = $this->postRepository->find($post);
        $comment = $this->commentRepository->store($post, $request->only(['comment', 'email', 'name']));
        return $this->response([
            'comment' => new CommentResource($comment)
        ]);
    }
}
