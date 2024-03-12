@extends('layouts.backend.master')
@section('title', 'Setting List')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Setting List </h2>
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
                                            <th class="column-title"> Company Name </th>
                                            <th class="column-title"> Company Phone </th>
                                            <th class="column-title"> Company Email </th>
                                            <th class="column-title"> Company Address </th>
                                            <th class="column-title"> Image </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions
                                                    ( <span class="action-cnt"> </span> ) <i
                                                        class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($setting != null)
                                            <tr class="even pointer">
                                                <td class="a-center ">
                                                    <input type="checkbox" class="flat" name="table_records">
                                                </td>
                                                <td class=" ">{{ $setting->company_name }}</td>
                                                <td class=" ">{{ $setting->company_phone }}</td>
                                                <td class=" ">{{ $setting->company_email }}</td>
                                                <td class=" ">{{ $setting->company_address }}</td>
                                                <td class=""><img
                                                        src="{{ asset('/storage/upload/setting/' . $setting->id . '/' . $setting->image) }}"
                                                        alt="" style="width: 100px; height: auto;" /></td>
                                                <td class="last">
                                                    <div class="row">
                                                        <div class='col-12 col-md-8'>
                                                            <a href="{{ url('sg-backend/setting/edit/' . $setting->id) }}"
                                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                                Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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

    <!-- /footer end -->
    @include('layouts.backend.partial.footer_end')
    <!-- /footer end -->

    <!-- jquery is here -->
    <!-- jquery end -->

    @include('layouts.backend.partial.footer_end_html')
@endsection
