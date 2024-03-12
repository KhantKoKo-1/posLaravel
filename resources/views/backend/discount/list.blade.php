@extends('layouts.backend.master')
@section('title', 'Discount List')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Discount Promotion List </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Name </th>
                                            <th class="column-title">Discount</th>
                                            <th class="column-title">Start_date </th>
                                            <th class="column-title">End_date </th>
                                            <th class="column-title">Items </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($discountData as $discount)
                                            <tr class="even pointer">
                                                <td class="a-center ">
                                                    <input type="checkbox" class="flat" name="table_records">
                                                </td>
                                                <td class=" ">{{ $discount->name }}</td>
                                                <td class=" ">{{ $discount->discount_value }}</td>
                                                <td class=" ">{{ $discount->start_date }}</td>
                                                <td class=" ">{{ $discount->end_date }}</td>
                                                <td class=" ">
                                                    @if ($discount->getPromotion != null)
                                                        @php
                                                            $namesArray = [];
                                                        @endphp
                                                        @foreach ($discount->getPromotion as $item)
                                                            @if ($item->getPromotionByItem != null)
                                                                @php
                                                                    $namesArray[] = $item->getPromotionByItem->name; // Push each name into the
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        {{ getItemsWithoutComma($namesArray) }}
                                                    @endif
                                                </td>
                                                <td class=" ">
                                                    <span class="badge badge-primary"
                                                        style="display: {{ $discount->status == 0 ? 'block' : 'none' }}">Enable</span>
                                                    <span class="badge badge-secondary"
                                                        style="display: {{ $discount->status != 0 ? 'block' : 'none' }}">Disable</span>
                                                </td>
                                                <td class="last">
                                                    <div class="row">
                                                        <div class="col-6 col-md-5">
                                                            <a href="{{ url('sg-backend/discount/edit/' . $discount->id) }}"
                                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                                Edit
                                                            </a>
                                                        </div>
                                                        <div class="col-6 col-md-6 mr-20">
                                                            <form id="discountDelete"
                                                                action="{{ url('sg-backend/discount/delete') }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="button" class="btn btn-danger btn-xs"
                                                                    style=""
                                                                    onclick="confirmDelete('discountDelete',{{ $discount->id }})">
                                                                    <i class="fa fa-trash-o"></i> Delete
                                                                </button>
                                                                <input name="id" id="delete_id" type="hidden"
                                                                    value="" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
    <!-- footer start -->
    @include('layouts.backend.partial.footer_start')
    <!-- /footer start -->

    <!-- footer end -->
    @include('layouts.backend.partial.footer_end')
    <!-- /footer end -->

    <!-- jquery is here -->
    <!-- jquery end -->

    @include('layouts.backend.partial.footer_end_html')
@endsection
