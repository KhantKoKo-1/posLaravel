@extends('layouts.backend.master')
@section('title', isset($item) ? 'Item Update Form' : 'Item Create Form')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ isset($item) ? 'Item Update' : 'Item Create' }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="">
                            @if (isset($item))
                            <div>
                                <button class="btn btn-sm btn-secondary">
                                    <a href="/sg-backend/item/list" style="color: white;">Back</a>
                                </button>
                            </div>
                                <form action="{{ route('updateItemForm') }}" method="POST" enctype="multipart/form-data"
                                    novalidate>

                                    <input name="id" type="hidden" value="{{ $item->id }}" />
                                @else
                                    <form action="{{ route('storeItemForm') }}" method="POST" enctype="multipart/form-data"
                                        novalidate>
                            @endif
                            @csrf
                            <!-- <span class="section"> Category Info</span> -->
                            <div class="field item form-group">
                                <label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Item
                                    Name<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="name" class="form-control" name="name"
                                        value="{{ old('name', isset($item) ? $item->name : '') }}" />
                                    @if ($errors->has('name'))
                                        <span class="errorMessage">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="Parent"
                                    class="col-form-label col-md-3 col-sm-3  label-align">Parent-Category<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="Parent" name="category_id" class="select2_group form-control">
                                        <option value="" disabled>Choose Category</option>
                                        {{ parent_category(old('category_id', isset($item) ? $item->category_id : ''), [true, false]) }}
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="errorMessage">{{ $errors->first('category_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="price" class="col-form-label col-md-3 col-sm-3  label-align">Price<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="name" type="number" class="form-control" name="price"
                                        value="{{ old('price', isset($item) ? $item->price : '') }}" />
                                    @if ($errors->has('price'))
                                        <span class="errorMessage">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="quantity" class="col-form-label col-md-3 col-sm-3  label-align">Quantity<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="quantity" type="number" class="form-control" name="quantity"
                                        value="{{ old('quantity', isset($item) ? $item->quantity : '') }}" />
                                    @if ($errors->has('quantity'))
                                        <span class="errorMessage">{{ $errors->first('quantity') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if (isset($item))
                                <div class="field item form-group">
                                    <label for="status" class="col-form-label col-md-3 col-sm-3  label-align">Status<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select id="status" name="status" class="select2_group form-control">
                                            <option value="" disabled>SELECT ONE</option>
                                            <option value="0"
                                                {{ old('status', isset($item) && $item->status == 0 ? 'selected' : '') }}>
                                                Enable</option>
                                            <option value="1"
                                                {{ old('status', isset($item) && $item->status == 1 ? 'selected' : '') }}>
                                                Disable</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="field item form-group">
                                <label for="image" class="col-form-label col-md-3 col-sm-3  label-align">Item
                                    Image<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <div id="previous_wrapper"
                                        style="{{ empty($item) ? 'display:block' : 'display:none' }}">
                                        <label class="chooseFile" for="upload" onclick="fileInput()">Choose
                                            Photo</label>
                                    </div>
                                    <div id="previous_wrapper-img"
                                        style="{{ empty($item) ? 'display:none' : 'display:block' }}">
                                        <div class="vertical-center">
                                            <img src="{{ isset($item) ? asset('/storage/upload/item/' . $item->id . '/' . $item->image) : '' }}"
                                                id="image" alt="" style="width:100%;">
                                            <label class="chooseFile" for="upload" onclick="fileInput()">Choose
                                                Photo</label>
                                        </div>
                                    </div>
                                    @if ($errors->has('upload_photo'))
                                        <span class="errorMessage">{{ $errors->first('upload_photo') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input class="hide" type="file" id="fileInput" name="upload_photo"
                            onchange='previewImage(this)'>
                        <div class="ln_solid">
                            <div class="form-group">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-primary">Submit</button>
                                    <button type='reset' class="btn btn-success">Reset</button>
                                </div>
                            </div>
                        </div>
                        </form>
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
    <script>
        function fileInput() {
            $('#fileInput').click();
        }

        function previewImage(input) {
            const file = input.files[0];
            let fileExtension = file.name.split('.').pop();
            let allow_file_type = ['jpg', 'jpeg', 'svg', 'png', 'gif'];
            if (fileExtension && allow_file_type.includes(fileExtension.toLowerCase())) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result);
                };
                $('#previous_wrapper').hide();
                $('#previous_wrapper-img').show();
                reader.readAsDataURL(file);
            } else {
                console.log('File extension is invalid:', fileExtension);
            }
        }
    </script>
    <!-- jquery end -->

    @include('layouts.backend.partial.footer_end_html')
@endsection
