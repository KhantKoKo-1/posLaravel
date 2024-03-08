<?php

namespace App\Repositories\Discount;

use App\Constant;
use App\ReturnMessage;
use App\Utility;
use App\Models\DiscountItem;
use App\Models\DiscountPromotion;
use App\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\DB;

class DiscountRepository implements DiscountRepositoryInterface
{
    public function createDiscountItems(array $data)
    {

        if ($data['discount_type'] == 'percentage') {
            $data["percentage"] = $data["amount"];
            unset($data["amount"]);
        }
        $item_ids           = $data['item'];
        $start_date         = Utility::dateFormatYmd($data['start_date']);
        $end_date           = Utility::dateFormatYmd($data['end_date']);
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $ins_data           = Utility::saveCreated((array) $data);
        DB::beginTransaction();
        $result             = DiscountPromotion::create($ins_data);
        if ($result) {
            $discount_id = $result->id;
            $item_data = ['discount_id' => $discount_id];
            $ins_item_data  = Utility::saveCreated((array) $item_data);
            foreach ($item_ids as $item_id) {
                $ins_item_data['item_id'] = $item_id;
                $item_res = DiscountItem::create($ins_item_data);
                if ($item_res) {
                    $response = ReturnMessage::OK;
                    DB::commit();
                } else {
                    DB::rollback();
                    $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                }
            }
        } else {
            DB::rollback();
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectAllDiscountPromotion()
    {
        $discountPromotions = DiscountPromotion::select('id', 'name', 'start_date', 'end_date', 'status')
                            ->selectRaw('CASE 
                                                WHEN percentage IS NULL THEN CONCAT(amount, " kyats") 
                                                ELSE CONCAT(percentage, " %") 
                                            END AS discount_value')
                            ->whereNull('deleted_at')
                            ->orderByDesc('id')
                            ->paginate(5);

        return $discountPromotions;
    }

    public function selectDiscountPromotion(int $id)
    {
        $discount = DiscountPromotion::find($id);
        return $discount;
    }

    public function getItemIds(int $id)
    {
        $item_ids = DiscountItem::where('discount_id', $id)
                    ->whereNull('deleted_at')
                    ->where('status', Constant::ENABLE_STATUS)
                    ->pluck('item_id')
                    ->toArray();
        return $item_ids;
    }

    public function updateDiscountPromotion(array $data)
    {
        $id            = $data['id'];
        $update_form   = DiscountPromotion::find($id);
        if ($data['discount_type'] == 'percentage') {
            $data["percentage"] = $data["amount"];
            unset($data["amount"]);
        }
        $item_ids           = $data['item'];
        $start_date         = Utility::dateFormatYmd($data['start_date']);
        $end_date           = Utility::dateFormatYmd($data['end_date']);
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data   = Utility::saveUpdated((array) $data);
        DB::beginTransaction();
        $result = $update_form -> update($data);
        if ($result) {
            $delete_forms = DiscountItem::where('discount_id', $id)->get();
            foreach ($delete_forms as $delete_form) {
                $delete_form->delete();
            }
            $item_data = ['discount_id' => $id];
            $ins_item_data  = Utility::saveCreated((array) $item_data);
            foreach ($item_ids as $item_id) {
                $ins_item_data['item_id'] = $item_id;
                $item_res = DiscountItem::create($ins_item_data);
                if ($item_res) {
                    $response = ReturnMessage::OK;
                    DB::commit();
                } else {
                    DB::rollback();
                    $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                }
            }
            $response = ReturnMessage::OK;
        } else {
            DB::rollback();
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function delete(int $id)
    {
        $delete_data   = DiscountPromotion::find($id);
        $data          = Utility::softDelete();
        DB::beginTransaction();
        $result        = $delete_data->update($data);
        if ($result) {
            $delete_forms = DiscountItem::where('discount_id', $id)->get();
            foreach ($delete_forms as $delete_form) {
                $data      = Utility::softDelete();
                $item_res  = $delete_form->update($data);
                if ($item_res) {
                    $response = ReturnMessage::OK;
                    DB::commit();
                } else {
                    DB::rollback();
                    $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                }
            }
            $response  = ReturnMessage::OK;
        } else {
            DB::rollback();
            $response  = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

}
