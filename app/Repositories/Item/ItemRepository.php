<?php

namespace App\Repositories\Item;

use App\Constant;
use App\Models\Item;
use App\Repositories\Item\ItemRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class ItemRepository implements ItemRepositoryInterface
{
    public function createItem(array $data)
    {
        $image_name = Utility::getImageName($data['upload_photo']);
        $data['image'] = $image_name;
        $ins_data = Utility::saveCreated((array) $data);
        $category_id = $ins_data['category_id'];
        $result = Item::create($ins_data);
        if ($result) {
            $id = $result->id;
            $path_dir = 'app/public/upload/item/';
            Utility::cropAndResize($data, $id, $path_dir);
            $code_no = Utility::generateCodeNo($category_id, $id);
            $update_form = Item::find($id);
            $update_data['code_no'] = $code_no;
            $update_data = Utility::saveUpdated((array) $update_data);
            $update_result = $update_form->update($update_data);
            if ($update_result) {
                $response = ReturnMessage::OK;
            } else {
                $response = ReturnMessage::INTERNAL_SERVER_ERROR;
            }
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectAllItems(bool $order_items)
    {
        $items = Item::select('id', 'name', 'price', 'quantity', 'code_no', 'category_id', 'status', 'image')
            ->whereNull('deleted_at');
        if ($order_items) {
            $items = $items->where('status', Constant::ENABLE_STATUS)
                ->get();
        } else {
            $items = $items->orderByDesc('id')
                ->paginate(5);
        }
        return $items;
    }

    public function selectItem(bool $order_item, int $id)
    {
        $item = Item::select('id', 'name', 'price', 'quantity', 'code_no', 'category_id', 'status', 'image')
            ->whereNull('deleted_at');
        if ($order_item) {
            $item = $item->where('status', Constant::ENABLE_STATUS)
                ->where('category_id', $id)
                ->get();
        } else {
            $item = $item->where('id', $id)
                ->first();
        }

        return $item;
    }

    public function updateItem(array $data)
    {
        $update_form = Item::find($data['id']);
        if (array_key_exists('upload_photo', $data)) {
            $old_image = $update_form['image'];
            $image_name = Utility::getImageName($data['upload_photo']);
            $data['image'] = $image_name;
        }
        $data = Utility::saveUpdated((array) $data);
        $result = $update_form->update($data);
        if ($result) {
            if (array_key_exists('upload_photo', $data)) {
                $id = $data['id'];
                $path_dir = 'app/public/upload/item/';
                $full_path_dir = Utility::cropAndResize($data, $id, $path_dir);
                unlink($full_path_dir . '/' . $old_image);
            }
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function deleteItem(int $id)
    {
        $delete_data = Item::find($id);
        $data = Utility::softDelete();
        $result = $delete_data->update($data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }
}