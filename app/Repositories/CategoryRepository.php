<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Models\User;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * Create new category.
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function store(array $data, User $user)
    {
        $category = Category::create($data);
        $user->categories()->save($category);
        return $category;
    }

    /**
     * Get specific category with slug.
     * @param $category
     * @param array $relations
     * @return mixed
     */
    public function find($category, array $relations = [])
    {
        return Category::with($relations)->whereSlug($category)->firstOrFail();
    }

    /**
     * Update specific category.
     * @param $category
     * @param array $data
     * @return mixed
     */
    public function update($category, array $data)
    {
        // update category slug
        $data['slug'] = null;
        $category->update($data);
        return $this->find($category->slug);
    }

    /**
     * Delete specific category with its posts.
     * @param $category
     * @return mixed
     */
    public function delete($category)
    {
        return $category->delete();
    }
}
