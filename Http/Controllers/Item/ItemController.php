<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemDelRequest;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdRequest;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Utility;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    private $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        DB::connection()->enableQueryLog();
        $this->itemRepository = $itemRepository;
    }

    public function getForm()
    {
        $screen = "Show Item Form !!";
        try {
            Utility::saveInfoLog($screen);
            return view('backend.item.form');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }

    }

    public function store(ItemStoreRequest $request)
    {
        $screen = "Item Post Method !!";
        try {
            $response = $this->itemRepository->createItem($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/item/list')->with(['successMessage' => 'Create Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
            return redirect('sg-backend/item/list')->with(['errorMessage' => ' Create Item Fail'])->withInput();
        }

    }

    public function getList()
    {
        $screen = "Show item List !!";
        try {
            $items = $this->itemRepository->selectAllItems((bool) false);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.item.list', compact('items'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }

    }

    public function getEdit($id)
    {
        $screen = "Item Edit Screen !!";
        try {
            $item = $this->itemRepository->selectItem((bool) false, (int) $id);
            if ($item == null) {
                return response()->view('errors.404', [], 404);
            }
            return view('backend.Item.form', compact('item'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function updateForm(ItemUpdRequest $request)
    {
        $screen = "Item Update Method !!";
        try {
            $response = $this->itemRepository->updateItem($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/item/list')->with(['successMessage' => 'Update Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            return redirect('sg-backend/item/list')->with(['errorMessage' => 'Update Item Fail'])->withInput();
        }
    }

    public function itemDelete(ItemDelRequest $request)
    {
        $screen = "Item Delete Method!!";
        try {
            $response = $this->itemRepository->deleteItem($request->id);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/item/list')->with(['successMessage' => 'Delete Item Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            return redirect('sg-backend/item/list')->with(['errorMessage' => 'Delete Item Fail'])->withInput();
        }

    }
}