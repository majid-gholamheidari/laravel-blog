<?php

namespace App\Interfaces;

use App\Models\User;

interface CategoryRepositoryInterface
{
    /**
     * Create new category
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function store(array $data, User $user);

    /**
     * Get specific category
     * @param $category
     * @return mixed
     */
    public function find($category);

    /**
     * Update specific category
     * @param $category
     * @param array $data
     * @return mixed
     */
    public function update($category, array $data);

    /**
     * Delete specific category with its posts
     * @param $category
     * @return mixed
     */
    public function delete($category);
}
