<?php

namespace App;

use App\Constant;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class Utility
{
    public static function saveDebugLog($screen, $queryLog)
    {
        $formattedQueries = '';
        foreach ($queryLog as $query) {
            $sqlQuery = $query['query'];
            foreach ($query['bindings'] as $binding) {
                $sqlQuery = preg_replace('/\?/', "'" . $binding ."'", $sqlQuery, 1);
            }
            $formattedQueries .= $sqlQuery . PHP_EOL;
        }
        Log::debug($screen . "-\n" . $formattedQueries);
    }

    public static function saveInfoLog($screen)
    {
        Log::info($screen);
    }

    public static function saveErrorLog($screen, $errorLog)
    {
        Log::error($screen . "-\n" . $errorLog);
    }

    public static function saveCreated(array $data, bool $cashier = false)
    {
        if ($cashier) {
            $user_id  = Auth::guard('cashier')->user()->id;
        } else {
            $user_id  = Auth::guard('admin')->user()->id;
        }
        $data['created_by'] = $user_id;
        $data['updated_by'] = $user_id;
        return $data;
    }

    public static function saveUpdated(array $data, bool $cashier = false)
    {
        if ($cashier) {
            $user_id  = Auth::guard('cashier')->user()->id;
        } else {
            $user_id  = Auth::guard('admin')->user()->id;
        }
        $data['updated_by'] = $user_id;
        return $data;
    }

    public static function softDelete(bool $cashier = false)
    {
        $today_dt = date('Y:m:d H:i:s');
        if ($cashier) {
            $user_id  = Auth::guard('cashier')->user()->id;
        } else {
            $user_id  = Auth::guard('admin')->user()->id;
        }
        $data['deleted_by'] = $user_id;
        $data['deleted_at'] = $today_dt;
        return $data;
    }

    public static function getImageName($file)
    {
        $originalFileName = $file->getClientOriginalName();
        $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $extension        = $file->getClientOriginalExtension();
        $unique_name      = $fileNameWithoutExtension . "_" . strftime('%H%M%S') . "_" . uniqid() . "." . $extension;
        return $unique_name;
    }

    public static function cropAndResize($data, $id, $path_dir)
    {
        $file = $data['upload_photo'];
        $unique_name = $data['image'];
        $img = Image::make($file)
               ->resize(Constant::IMAGE_WIDTH, Constant::IMAGE_HEIGHT)
               ->crop(Constant::IMAGE_WIDTH, Constant::IMAGE_HEIGHT)
               ->encode();
        $full_path_dir = storage_path($path_dir . $id .'/');
        if (!file_exists($full_path_dir)) {
            mkdir($full_path_dir, 0777, true);
        }
        $img->save($full_path_dir.$unique_name);
        return $full_path_dir;
    }

    public static function generateCodeNo($category_id, $insert_id)
    {
        for ($i = 0; $i < 4; $i++) {
            $code_key = strtoupper(Str::random(4));
        }
        $code_no = $category_id . $insert_id . '-' .$code_key;
        return $code_no;
    }

    public static function dateFormatYmd($date)
    {
        $formatted_date = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        return $formatted_date;
    }

    public static function shiftValidation()
    {
        $shift_check_rows = Shift::select('id')
                            ->whereNotNull('start_date_time')
                            ->whereNull('end_date_time')
                            ->whereNull('deleted_at')
                            ->first();
        return $shift_check_rows;
    }

    public static function dailySaleDates($start = null, $end = null)
    {
        if ($start == null && $end == null) {
            $dateTime = date('Y-m-d');
            $date = Carbon::parse($dateTime);
            $dates[] = $dateTime;
            $dateDiff = 6;
        } else {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
            $date = $endDate;
            $dateDiff = $startDate->diffInDays($endDate);
        }

        for ($i = 0; $i < $dateDiff ; $i++) {
            $dates[] = $date->subDay()->format('Y-m-d');
        }
        $dates = array_reverse($dates);
        return $dates;
    }


    public static function monthlySaleDates($start_month, $end_month)
    {
        if ($start_month == null && $end_month == null) {
            $current_month = date('Y-m');
            $common_month  = Carbon::parse($current_month);
            $lastMonths    = 6;
            $months[]      = $current_month;
        } else {
            $start_month  = Carbon::createFromFormat('m/Y', $start_month)->startOfMonth()->format('Y-m');
            $end_month    = Carbon::createFromFormat('m/Y', $end_month)->startOfMonth()->format('Y-m');
            $start_date   = Carbon::parse($start_month);
            $common_month = Carbon::parse($end_month)->startOfMonth();
            $lastMonths   = $common_month->diffInMonths($start_date);
            $months[]     = $common_month;
        }
        for ($i = 0; $i < $lastMonths ; $i++) {
            $months[] = $common_month->subMonth()->format('Y-m');
        }
        $months = array_reverse($months);
        return $months;
    }

}
