<?php

namespace App\Repositories\Category;

use App\Constant;
use App\ReturnMessage;
use App\Utility;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function createCategory(array $data)
    {
        $image_name    = Utility::getImageName($data['upload_photo']);
        $data['image'] = $image_name;
        $ins_data      = Utility::saveCreated((array) $data);
        $result        = Category::create($ins_data);
        if ($result) {  
            $id = $result->id;
            $path_dir      = 'app/public/upload/category/';
            Utility::cropAndResize($data,$id,$path_dir);   
            $response = ReturnMessage::OK;
        }else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectAllCategory()

    {
        $categories = Category::select('category.id', 'category.name', 'category.parent_id', 'category.status', 'category.image', DB::raw('COALESCE(p.name, "None") as parent_name'))
                    ->leftJoin('category as p', 'category.parent_id', '=', 'p.id')
                    ->whereNull('category.deleted_at')
                    ->orderByDesc('category.id')
                    ->paginate(5);
     
        return $categories;
    }

    public function selectCategory(int $id)
    {
        $categories = Category::find($id);
        return $categories;
    }

    public function selectCategoryByParent(int $parent_id)
    {
        $categories = Category::select('id', 'name', 'status', 'image')
                    ->where('parent_id', $parent_id)
                    ->where('status', Constant::ENABLE_STATUS)
                    ->whereNull('deleted_at')
                    ->get();
        return $categories;
    }

    public function updateCategory(array $data)
    {
        $update_form   = Category::find($data['id']);
        if (array_key_exists('upload_photo', $data)) {
            $old_image     = $update_form['image'];
            $image_name    = Utility::getImageName($data['upload_photo']);
            $data['image'] = $image_name;
        }
        $data   = Utility::saveUpdated((array) $data);
        $result = $update_form -> update($data);
        if ($result) {
            if (array_key_exists('upload_photo', $data)) {
                $id            = $data['id'];
                $path_dir      = 'app/public/upload/category/';
                $full_path_dir = Utility::cropAndResize($data,$id,$path_dir);
                unlink($full_path_dir . '/' . $old_image);
            }
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }
    
    public function deleteCategory(int $id)
    {
        $delete_data   = Category::find($id);
        $data          = Utility::softDelete();
        $result        = $delete_data->update($data);
        if ($result) {
            $response  = ReturnMessage::OK;
        } else {
            $response  = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

}
