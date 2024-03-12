<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function createCategory(array $data);
    public function deleteCategory(int $id);
    public function selectAllCategory();
    public function selectCategory(int $id);
    public function selectCategoryByParent(int $parent_id);
    public function updateCategory(array $data);
}