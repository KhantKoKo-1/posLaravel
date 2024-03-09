<?php
use App\Constant;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('parent_category')) {
    function parent_category($parent_id, $screen)
    {

        global $count;
        $count = 1;
        $categories = Category::where('parent_id', 0)
                    ->where('status', Constant::ENABLE_STATUS)
                    ->whereNull('deleted_at')
                    ->get();

        foreach ($categories as $category) {
            $enabled = '';
            $category_id = $category['id'];
            $category_name = $category['name'];
            if ($screen[0]) {
                $child_count = check_child_category($category_id);
                if ($child_count > 0) {
                    $enabled = 'disabled';
                }
            }
            if ($screen[1]) {
                $item_count = check_items_for_category($category_id);
                if ($item_count > 0) {
                    $enabled = 'disabled';
                }
            }
            $selectedAttribute = ($category_id == $parent_id) ? 'selected' : '';
            echo "<option name='parent_id' value='$category_id' $selectedAttribute $enabled> $category_name</option>";
            child_category($category_id, $parent_id, $count, $screen);
        }
    }

    if (!function_exists('child_category')) {
        function child_category($parent_id, $child_parent_id, $count, $screen)
        {

            $count++;
            $dash = "";
            $child_categories = Category::WHERE('parent_id', $parent_id)
                                ->WHERE('status', Constant::ENABLE_STATUS)
                                ->whereNull('deleted_at')
                                ->get();
            for ($i = 0; $i < $count - 1 ; $i++) {
                $dash .= ' --';
            }

            foreach ($child_categories as $child_category) {
                $child_category_id   = $child_category['id'];
                $child_category_name = $child_category['name'];
                $enabled = '';
                if ($screen[0]) {
                    $child_count = check_child_category($child_category_id);
                    if ($child_count > 0) {
                        $enabled = 'disabled';
                    }
                }
                if ($screen[1]) {
                    $item_count = check_items_for_category($child_category_id);
                    if ($item_count > 0) {
                        $enabled = 'disabled';
                    }
                }
                $selectedAttribute = ($child_category_id == $child_parent_id) ? 'selected' : '';
                echo "<option name='parent_id' value='$child_category_id' $selectedAttribute $enabled>$dash $child_category_name</option>";
                child_category($child_category_id, $child_parent_id, $count, $screen);
            }

        }
    }

    if (!function_exists('check_child_category')) {
        function check_child_category($parent_id)
        {
            $total = Category::where('parent_id', $parent_id)
                    ->where('status', Constant::ENABLE_STATUS)
                    ->whereNull('deleted_at')
                    ->count();

            return $total;
        }
    }

    if (!function_exists('check_items_for_category')) {
        function check_items_for_category($category_id)
        {
            $total = Item::where('category_id', $category_id)
                    ->where('status', Constant::ENABLE_STATUS)
                    ->whereNull('deleted_at')
                    ->count();

            return $total;
        }
    }

    if (!function_exists('getItemsWithoutComma')) {
        function getItemsWithoutComma($items_name)
        {
            $name_string = '';
            foreach ($items_name as $item_name) {
                $name_string .= $item_name . ',';
            }
            $name_string = rtrim($name_string, ',');
            return $name_string;
        }
    }

    if (!function_exists('dateFormatmdY')) {
        function dateFormatmdY($date)
        {
            $formatted_date = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
            return $formatted_date;
        }
    }

    if (!function_exists('dateFormatYmToYF')) {
        function dateFormatYmToYF($date)
        {
            $formatted_date = Carbon::createFromFormat('Y-m', $date)->format('Y-F');
            return $formatted_date;
        }
    }

    if (!function_exists('convertTimeFormatHis')) {
        function convertTimeFormatHis($time)
        {
            $time = Carbon::now()->format('H:i:s');
            $formatted_time = Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
            return $formatted_time;
        }
    }

    if (!function_exists('getLoginUser')) {
        function getLoginUser($cashier = false)
        {
            if ($cashier) {
                $user_name    = Auth::guard('cashier')->user()->username;
            } else {
                $user_name    = Auth::guard('admin')->user()->username;
            }
            return $user_name;
        }
    }
}
