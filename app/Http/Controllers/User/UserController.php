<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountDelRequest;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        DB::connection()->enableQueryLog();
        $this->userRepository = $userRepository;
    }

    public function getForm($type = 'cashier')
    {
        $accountType = $type;
        $screen = "Show User Account Form !!";
        try {
            Utility::saveInfoLog($screen);
            return view('backend.user.form', compact('accountType'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function store(AccountStoreRequest $request)
    {
        $screen = "Account Create Method !!";
        try {
            $response = $this->userRepository->storeAccount($request->all());
            Utility::saveInfoLog($screen);
            if ($response == '200') {
                if ($request->account_type == 'admin') {
                    return redirect('sg-backend/account/list/admin')->with(['successMessage' => 'Create Admin Account Success'])->withInput();
                } else {
                    return redirect('sg-backend/account/list/cashier')->with(['successMessage' => 'Create Cashier Account Success'])->withInput();
                }
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/account/list')->with(['errorMessage' => ' Create Cashier Account Fail'])->withInput();
        }
    }

    public function getList($type = 'cashier')
    {
        $accountType = $type;
        $screen = "Show User Account List !!";
        try {
            $accounts = $this->userRepository->selectAllAccount($type);
            Utility::saveInfoLog($screen);
            return view('backend.user.list', compact('accounts', 'accountType'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function getEdit($type, $editType, $id)
    {
        $accountType = $type;
        $screen = "Account Edit Screen !!";
        try {
            $account = $this->userRepository->selectAccount((int) $id);
            if ($id == null) {
                return response()->view('errors.404', [], 404);
            }
            return view('backend.user.form', compact('account', 'editType', 'accountType'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function updateForm(AccountUpdRequest $request)
    {
        $screen = "Account Update Method !!";
        try {
            if (empty($request->password)) {
                $response = $this->userRepository->updateAccountInfo($request->all());
            } else {
                $response = $this->userRepository->updateAccountPassword($request->all());
            }
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/account/list/'.$request->account_type)->with(['successMessage' => 'Update Account Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/account/list/'.$request->account_type)->with(['errorMessage' => 'Update Account Fail'])->withInput();
        }

    }

    public function accountDelete(AccountDelRequest $request)
    {
        $screen = "Account Delete Method!!";
        try {
            $response = $this->userRepository->deleteAccount($request->id);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/account/list/cashier')->with(['successMessage' => 'Delete Account Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/account/list/cashier')->with(['errorMessage' => 'Delete Account Fail'])->withInput();
        }

    }
}