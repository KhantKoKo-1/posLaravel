<?php

namespace App\Http\Controllers\Order;


use App\Utility;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\Frontend\ChangeStatusRequest;
use App\Http\Requests\Frontend\FetchOrderItemRequest;
use App\Http\Requests\Frontend\FetchOrderDetailRequest;
use App\Http\Requests\Frontend\GetCategoryRequest;
use App\Http\Requests\Frontend\GetItemRequest;
use App\Http\Requests\Frontend\GetOrdersRequest;
use App\Http\Requests\Frontend\UpdateOrderRequest;
use App\Http\Requests\Frontend\OrderItemRequest;
use App\Http\Requests\Frontend\StoreOrderRequest;
use App\Http\Resources\Item\ItemResource;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderListResource;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderFrontendController extends Controller
{
    private $categoryRepository;
    private $itemRepository;
    private $orderRepository;
    
    public function __construct(CategoryRepositoryInterface $categoryRepository,ItemRepositoryInterface $itemRepository,OrderRepositoryInterface $orderRepository)
    {
        DB::connection()->enableQueryLog();
        $this->categoryRepository = $categoryRepository;
        $this->itemRepository = $itemRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getOrder()
    {
        $screen = "Show Get Order From OrderFrontendController";
        Utility::saveInfoLog($screen);
        return view('frontend.order.form');
    }

    public function getList()
    {
        $screen = "Show Get List From OrderFrontendController";
        Utility::saveInfoLog($screen);
        return view('frontend.order.list');
    }

    public function getEditOrder($id)
    {
        $screen = "Show Edit Form From OrderFrontendController";
        Utility::saveInfoLog($screen);
        return view('frontend.order.form', compact('id'));
    }
    public function getOrderDetail($id)
    {
        $screen = "Show Get Order Detail From OrderFrontendController";
        Utility::saveInfoLog($screen);
        return view('frontend.order.order_detail', compact('id'));
    }

    public function getCategory(GetCategoryRequest $request)
    {
        $screen = "Show Get Category Method From OrderFrontendController";  
        try {
            $categories = $this->categoryRepository->selectCategoryByParent($request->parent_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function getItems(GetItemRequest $request) 
    {   
        $screen = "Show getItems Method From OrderFrontendController";
        try {
            $items = $this->itemRepository->selectItem((bool) true,$request->category_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return ItemResource::collection($items);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function getAllItems() 
    {   
        $screen = "Show Get All Items Method From OrderFrontendController";
        try {
            $items = $this->itemRepository->selectAllItems((bool) true);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return ItemResource::collection($items);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function orderItem(OrderItemRequest $request) 
    {   
        $screen = "Show orderItem Method From OrderFrontendController";
        try {
            $item = $this->orderRepository->orderItem($request->item_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return OrderResource::collection([$item]);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function makeOrder(StoreOrderRequest $request) 
    {   
        $screen = "Show makeOrder Method From OrderFrontendController";
        try {
            $response = $this->orderRepository->store($request->all());
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return response()->json(['status' => $response, 'message' => 'success']);
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function getOrders(GetOrdersRequest $request) 
    {   
        $screen = "Show getOrders Method From OrderFrontendController";
        try {
            $orders = $this->orderRepository->selectOrdersByShiftId((int) $request->shift_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return OrderListResource::collection($orders);        
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function changeStatus(ChangeStatusRequest $request) 
    {
        $screen = "Show Change Status Method From OrderFrontendController";
        try {
            $response = $this->orderRepository->changeOrderStatus((int) $request->order_id,(int) $request->status);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return response()->json(['status' => $response, 'message' => 'success']);
            }        
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function fetchOrderItems(FetchOrderItemRequest $request) 
    {
        $screen = "Show Edit Order Method From OrderFrontendController";
        try {
            $order_items = $this->orderRepository->fetchOrderItemByOrderId((int) $request->order_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return OrderResource::collection($order_items); 
        } catch (\Exception $e) {
            dd($e->getMessage());
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function editOrder(UpdateOrderRequest $request) 
    {
        $screen = "Show Edit Order Method From OrderFrontendController";
        try {
            $response = $this->orderRepository->updateOrder((array) $request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return response()->json(['status' => $response, 'message' => 'success']);
            }          
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function fetchOrderDetail(FetchOrderDetailRequest $request)
    {
        $screen = "Show Fetch Order Detail From OrderFrontendController";
        try {
            $order = $this->orderRepository->selectOrdersByOrderId((int) $request->order_id,(int) $request->shift_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return new OrderListResource($order);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

}
