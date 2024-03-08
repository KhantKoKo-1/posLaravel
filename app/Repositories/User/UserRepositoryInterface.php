<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function storeAccount(array $data);
    public function selectAllAccount(string $type);
    public function selectAccount(int $id);
    public function updateAccountInfo(array $data);
    public function updateAccountPassword(array $data);
    public function deleteAccount(int $id);

}
