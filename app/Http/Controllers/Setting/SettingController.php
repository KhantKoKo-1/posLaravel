<?php

namespace App\Http\Controllers\Setting;

use App\Utility;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\SettingUpdRequest;
use App\Http\Requests\SettingDelRequest;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        DB::connection()->enableQueryLog();
        $this->settingRepository = $settingRepository;
    }

    public function getForm()
    {
        $screen = "Show Setting Form !!";
        try {
            $setting = $this->settingRepository->selectAllSettings();
            if ($setting == null) {
                Utility::saveInfoLog($screen);
                return view('backend.setting.form');
            } else {
                return view('backend.setting.form', compact('setting'));
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function store(SettingStoreRequest $request)
    {
        $screen = "Setting Create Method !!";
        try {
            $response = $this->settingRepository->createSetting($request->all());
            Utility::saveInfoLog($screen);
            if ($response == '200') {
                return redirect('sg-backend/setting/list')->with(['successMessage' => 'Create Setting Success'])->withInput();
            } else {
                return redirect('sg-backend/setting/list')->with(['errorMessage' => 'Fail Setting Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/setting/list')->with(['errorMessage' => ' Create Setting Fail'])->withInput();
        }
    }

    public function getList()
    {
        $screen = "Show Setting List !!";
        try {
            $setting = $this->settingRepository->selectAllSettings();
            Utility::saveInfoLog($screen);
            return view('backend.setting.list', compact(['setting']));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }


    public function getEdit($id)
    {
        $screen = "Setting Edit Screen !!";
        try {
            $setting = $this->settingRepository->selectSetting((int) $id);
            if ($setting == null) {
                return response()->view('errors.404', [], 404);
            }
            return view('backend.setting.form', compact('setting'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function updateForm(SettingUpdRequest $request)
    {
        $screen = "Setting Update Method !!";
        try {
            $response = $this->settingRepository->updateSetting($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/setting/list')->with(['successMessage' => 'Update Setting Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/setting/list')->with(['errorMessage' => 'Update Setting Fail'])->withInput();
        }
    }

    public function settingDelete(SettingDelRequest $request)
    {
        $screen = "Setting Delete Method!!";
        try {
            $response = $this->settingRepository->deleteSetting($request->id);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/setting/list');
            }
            return redirect('sg-backend/setting/list');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
}
