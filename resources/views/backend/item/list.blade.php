@extends('layouts.backend.master')
@section('title', 'Item List')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Item List </h2>
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
                                            <th class="column-title">Parent Category </th>
                                            <th class="column-title">Price </th>
                                            <th class="column-title">Quantity </th>
                                            <th class="column-title">Code </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title">Image </th>
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
                                        @foreach ($items as $item)
                                            <tr class="even pointer">
                                                <td class="a-center ">
                                                    <input type="checkbox" class="flat" name="table_records">
                                                </td>
                                                <td class=" ">{{ $item->name }}</td>
                                                <td class=" ">
                                                    @if ($item->getCategory != null)
                                                        {{ $item->getCategory->name }}
                                                    @endif
                                                </td>
                                                <td class=" ">{{ $item->price }}</td>
                                                <td class=" ">{{ $item->quantity }}</td>
                                                <td class=" ">{{ $item->code_no }}</td>
                                                <td class=" ">
                                                    <span class="badge badge-primary"
                                                        style="display:{{ $item->status === 0 ? 'inline' : 'none' }}">Enable</span>
                                                    <span class="badge badge-secondary"
                                                        style="display:{{ $item->status === 1 ? 'inline' : 'none' }}">Disable</span>
                                                </td>
                                                <td class=""><img
                                                        src="{{ asset('/storage/upload/item/' . $item->id . '/' . $item->image) }}"
                                                        alt="" style="width: 100px; height: auto;" /></td>
                                                <td class="last">
                                                    <div class="row">
                                                        <div class="col-6 col-md-4">
                                                            <a href="{{ url('sg-backend/item/edit/' . $item->id) }}"
                                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                                Edit
                                                            </a>
                                                        </div>
                                                        <div class="col-6 col-md-6 mr-10">
                                                            <form id="itemDelete"
                                                                action="{{ url('sg-backend/item/delete') }}" method="POST">
                                                                @csrf
                                                                <button type="button" class="btn btn-danger btn-xs"
                                                                    style=""
                                                                    onclick="confirmDelete('itemDelete',{{ $item->id }})">
                                                                    <i class="fa fa-trash-o"></i> Delete
                                                                </button>
                                                                <input name="id" id="delete_id" type="hidden"
                                                                    value="{{ $item->id }}" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <ul class="pagination" style="margin-left:82%;">
                                    {{ $items->links() }}
                                </ul>
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
