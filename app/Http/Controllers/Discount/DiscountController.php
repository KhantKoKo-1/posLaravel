<?php

namespace App\Http\Controllers\Discount;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountDelRequest;
use App\Http\Requests\DiscountStoreRequest;
use App\Http\Requests\DiscountUpdRequest;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Utility;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    private $discountRepository;
    private $itemRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository, ItemRepositoryInterface $itemRepository)
    {
        DB::connection()->enableQueryLog();
        $this->discountRepository = $discountRepository;
        $this->itemRepository = $itemRepository;
    }

    public function getForm()
    {
        $screen = "Show Discount Promotion Form !!";
        try {
            $items = $this->itemRepository->selectAllItems((bool) true);

            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.discount.form', compact('items'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }

    }
    public function getList()
    {
        $screen = "Show Discount Promotion List !!";
        try {
            $discountData = $this->discountRepository->selectAllDiscountPromotion();
            // dd($discountData);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.discount.list', compact('discountData'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }

    }

    public function store(DiscountStoreRequest $request)
    {
        $screen = "Discount Item Post Method !!";
        try {
            $response = $this->discountRepository->createDiscountItems($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/discount/list')->with(['successMessage' => 'Create Promotion Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
            return redirect('sg-backend/discount/list')->with(['errorMessage' => ' Create Promotion Item Fail'])->withInput();
        }

    }

    public function getEdit($id)
    {
        $screen = "Discount Edit Screen !!";
        try {
            $items = $this->itemRepository->selectAllItems((bool) false);
            $discount = $this->discountRepository->selectDiscountPromotion((int) $id);
            $itemIds = $this->discountRepository->getItemIds((int) $id);
            if ($discount == null) {
                return response()->view('errors.404', [], 404);
            }
            return view('backend.discount.form', compact(['discount', 'items', 'itemIds']));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function updateForm(DiscountUpdRequest $request)
    {
        $screen = "Discount Update Method !!";
        try {
            $response = $this->discountRepository->updateDiscountPromotion($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/discount/list')->with(['successMessage' => 'Create Promotion Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            return redirect('sg-backend/category/list')->with(['errorMessage' => 'Create Promotion Item Fail'])->withInput();
        }
    }

    public function discountDelete(DiscountDelRequest $request)
    {
        $screen = "Category Delete Method!!";
        try {
            $response = $this->discountRepository->delete($request->id);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/discount/list')->with(['successMessage' => 'Delete Promotion Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            return redirect('sg-backend/discount/list')->with(['errorMessage' => 'Delete Promotion Item Fail'])->withInput();
        }
    }


}