<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\PostResource;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Create new category.
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->store($request->all(), $request->user());
        return $this->response(['category' => new CategoryResource($category)], 200, 'Category has successfully created.');
    }

    /**
     * Get specific category.
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($category)
    {
        $category = $this->categoryRepository->find($category);
        return $this->response(
            ['category' => new CategoryResource($category)],
            200,
            '',
            true,
        );
    }

    /**
     * Update specific category.
     * @param $category
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($category, CategoryRequest $request)
    {
        $category = $this->categoryRepository->find($category);
        if ( !$this->checkUser($category) ) {
            return $this->response([], 404, 'Item not found!', false);
        }
        $updatedCategory = $this->categoryRepository->update($category, $request->all());
        return $this->response(
            [ 'category' => new CategoryResource($updatedCategory)],
            200,
            'Category has updated successfully.',
            true);
    }

    /**
     * Delete specific category.
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($category)
    {
        $category = $this->categoryRepository->find($category);
        if ( !$this->checkUser($category) ) {
            return $this->response([], 404, 'Item not found!', false);
        }
        $this->categoryRepository->delete($category);
        return $this->response([], 200, 'The category and posts of the category have successfully deleted.', true);
    }

    /**
     * Get posts of category.
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts($category)
    {
        $categoryPostsCount = $this->categoryRepository->find($category)->posts()->active()->count();

        // paginate for category posts.
        $perPage = request('per_page', 15);
        $page = request('page', 1);
        $offset = ($page - 1) * $perPage;
        $postRelation = ['posts' => function ($query) use ($perPage, $page, $offset) {
            $query->active()->latest()->skip($offset)->take($perPage);
        }];

        $category = $this->categoryRepository->find($category, $postRelation);
        $categoryPosts = $category->posts;
        return $this->response([
            'posts' => [
                'posts' => PostResource::collection($categoryPosts),
                'meta' => [
                    'per_page' => (int) $perPage,
                    'current_page' => (int) $page,
                    'total_posts' => (int) $categoryPostsCount,
                    'total_pages' => (int) ceil($categoryPostsCount / $perPage)
                ]
            ]
        ], 200, 'Category and posts.', true);
    }

    /**
     * Check category belongs to current user.
     * @param $category
     * @return bool
     */
    private function checkUser($category)
    {
        if ( $category->user->id != auth('api')->id() ) {
            return false;
        }
        return true;
    }
}
