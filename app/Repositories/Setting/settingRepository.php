<?php

namespace App\Repositories\Setting;

use App\ReturnMessage;
use App\Utility;
use App\Models\Setting;
use App\Repositories\Setting\settingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class settingRepository implements settingRepositoryInterface
{
    public function createSetting(array $data)
    {
        $image_name    = Utility::getImageName($data['upload_photo']);
        $data['image'] = $image_name;
        $ins_data      = Utility::saveCreated((array) $data);
        $result        = Setting::create($ins_data);
        if ($result) {
            $id = $result->id;
            $path_dir = 'app/public/upload/setting/';
            Utility::cropAndResize($data, $id, $path_dir);
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectAllSettings()
    {
        $settings = Setting::select('id', 'company_name', 'company_phone', 'company_email', 'company_address', 'image')
                    ->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->first();
        return $settings;
    }

    public function selectSetting(int $id)
    {
        $setting = Setting::find($id);
        return $setting;
    }

    public function updateSetting(array $data)
    {
        $update_form   = Setting::find($data['id']);
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
                $path_dir      = 'app/public/upload/setting/';
                $full_path_dir = Utility::cropAndResize($data, $id, $path_dir);
                unlink($full_path_dir . '/' . $old_image);
            }
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function deleteSetting(int $id)
    {
        $delete_data   = Setting::find($id);
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
