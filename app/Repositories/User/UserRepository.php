<?php

namespace App\Repositories\User;

use App\Constant;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function storeAccount(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if ($data['account_type'] == 'admin') {
            $data['role'] = Constant::ADMIN_ROLE;
        } else {
            $data['role'] = Constant::CASHIER_ROLE;
        }
        $ins_data = Utility::saveCreated((array) $data);
        $result = User::create($ins_data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectAllAccount(string $type)
    {
        if ($type == 'admin') {
            $role = Constant::ADMIN_ROLE;
        } else {
            $role = Constant::CASHIER_ROLE;
        }
        $account = User::select('id', 'username', 'status')
            ->where('role', $role)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->paginate(5);
        return $account;
    }

    public function selectAccount(int $id)
    {
        $categories = User::find($id);
        return $categories;
    }

    public function updateAccountInfo(array $data)
    {
        $update_form = User::find($data['id']);
        $data = Utility::saveUpdated((array) $data);
        $result = $update_form->update($data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function updateAccountPassword(array $data)
    {
        $update_form = User::find($data['id']);
        $data['password'] = Hash::make($data['password']);
        $data = Utility::saveUpdated((array) $data);
        $result = $update_form->update($data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function deleteAccount(int $id)
    {
        $delete_data = User::find($id);
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