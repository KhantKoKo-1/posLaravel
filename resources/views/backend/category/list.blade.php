@extends('layouts.backend.master')
@section('title', 'Category List')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Category List </h2>
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
                                            <th class="column-title"> Name </th>
                                            <th class="column-title"> Parent Category </th>
                                            <th class="column-title"> Status </th>
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
                                        @foreach ($categories as $category)
                                            <tr class="even pointer">
                                                <td class="a-center ">
                                                    <input type="checkbox" class="flat" name="table_records">
                                                </td>
                                                <td class=" ">{{ $category->name }}</td>
                                                <td class=" ">{{ $category->parent_name }}</td>
                                                <td class=" ">
                                                    <span class="badge badge-primary"
                                                        style="display:{{ $category->status === 0 ? 'inline' : 'none' }}">Enable</span>
                                                    <span class="badge badge-secondary"
                                                        style="display:{{ $category->status === 1 ? 'inline' : 'none' }}">Disable</span>
                                                </td>
                                                <td class=""><img
                                                        src="{{ asset('/storage/upload/category/' . $category->id . '/' . $category->image) }}"
                                                        alt="" style="width: 100px; height: auto;" /></td>
                                                <td class="last">
                                                    <div class="row">
                                                        <div class='col-6 col-md-3'>
                                                            <a href="{{ url('sg-backend/category/edit/' . $category->id) }}"
                                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                                Edit</a>
                                                        </div>
                                                        @if (check_items_for_category($category->id) == 0)
                                                            <div class='col-6 col-md-9 mr-10'>
                                                                <form id="categoryDelete"
                                                                    action="{{ url('sg-backend/category/delete') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-danger btn-xs"
                                                                        onclick="confirmDelete('categoryDelete',{{ $category->id }})">
                                                                        <i class="fa fa-trash-o"></i> Delete
                                                                    </button>
                                                                    <input type="hidden" name="id" id="delete_id"
                                                                        value="">
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <ul class="pagination" style="margin-left:82%;">
                                    {{ $categories->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
    <!-- /footer start -->
    @include('layouts.backend.partial.footer_start')
    <!-- footer start -->

    <!-- /footer end -->
    @include('layouts.backend.partial.footer_end')
    <!-- /footer end -->

    <!-- jquery is here -->
    <!-- jquery end -->

    @include('layouts.backend.partial.footer_end_html')
@endsection
