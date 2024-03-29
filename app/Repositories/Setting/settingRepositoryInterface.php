<?php

namespace App\Repositories\Setting;

interface SettingRepositoryInterface
{
    public function createSetting(array $data);
    public function selectAllSettings();
    public function selectSetting(int $id);
    public function updateSetting(array $data);
    public function deleteSetting(int $id);
}
