<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\PostResource;
use App\Http\Resources\Api\UserResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(PostRepositoryInterface $postRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Create new post.
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $data = $request->only([
            'title',
            'description',
            'status',
            'image',
            'meta_data',
        ]);

        $category = $this->categoryRepository->find($request->category);
        $post = $this->postRepository->store($data);
        $user = auth('api')->user();

        $user->posts()->save($post);
        $category->posts()->save($post);

        return $this->response([
            'post' => new PostResource($post),
            'category' => new CategoryResource($category),
        ], 200, 'Post has successfully created.');
    }

    /**
     * Update specific post.
     * @param $post
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($post, PostRequest $request)
    {
        $data = $request->only([
            'title',
            'description',
            'status',
            'image',
            'meta_data',
        ]);
        $post = $this->postRepository->find($post);

        // check post belongs to current user.
        if ( !$this->checkUser($post) ) {
            return $this->response([], 404, 'Item not found!', false);
        }
        $updatedPost = $this->postRepository->update($post, $data);
        return $this->response([
            'post' => new PostResource($updatedPost),
            'category' => new CategoryResource($updatedPost->category),
        ], 200, 'Post has successfully updated.');
    }

    /**
     * Show specific post.
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($post)
    {
        $post = $this->postRepository->find($post);

        return $this->response([
            'post' => new PostResource($post),
            'category' => new CategoryResource($post->category),
            'author' => new UserResource($post->author),
        ]);
    }

    public function delete($post)
    {
        $post = $this->postRepository->find($post);
        if ( !$this->checkUser($post) ) {
            return $this->response([], 404, 'Item not found!', false);
        }
        $this->postRepository->delete($post);
        return $this->response([], 200, 'The post and comments, likes of the post have successfully deleted.', true);
    }

    /**
     * Check post belongs to current user.
     * @param $post
     * @return bool
     */
    private function checkUser($post)
    {
        if ( $post->author->id != auth('api')->id() ) {
            return false;
        }
        return true;
    }
}
