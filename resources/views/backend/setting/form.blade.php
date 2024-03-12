@extends('layouts.backend.master')
@section('title', isset($setting) ? 'Setting Update Form' : 'Setting Create Form')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ isset($setting) ? 'Setting Update' : 'Setting Create' }}</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            @if (isset($setting))
                                <form action="{{ route('updateSettingForm') }}" method="POST" enctype="multipart/form-data"
                                    novalidate>
                                    <div>
                                        <button class="btn btn-sm btn-secondary">
                                            <a href="/sg-backend/item/list" style="color: white;">Back</a>
                                        </button>
                                    </div>
                                    <input name="id" type="hidden" value="{{ $setting->id }}" />
                                @else
                                    <form action="{{ route('storeSettingForm') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                            @endif
                            @csrf
                            <span class="section"> Setting Info</span>
                            <div class="field item form-group">
                                <label for="company_name" class="col-form-label col-md-3 col-sm-3  label-align">Company
                                    Name<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="company_name" class="form-control" name="company_name"
                                        value="{{ old('company_name', isset($setting) ? $setting->company_name : '') }}" />
                                    @if ($errors->has('company_name'))
                                        <span class="errorMessage">{{ $errors->first('company_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="company_phone" class="col-form-label col-md-3 col-sm-3  label-align">Company
                                    Phone<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="company_phone" type="number" class="form-control" name="company_phone"
                                        value="{{ old('company_phone', isset($setting) ? $setting->company_phone : '') }}" />
                                    @if ($errors->has('company_phone'))
                                        <span class="errorMessage">{{ $errors->first('company_phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="company_email" class="col-form-label col-md-3 col-sm-3  label-align">Company
                                    Email<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="company_email" type="email" class="form-control" name="company_email"
                                        value="{{ old('company_email', isset($setting) ? $setting->company_email : '') }}" />
                                    @if ($errors->has('company_email'))
                                        <span class="errorMessage">{{ $errors->first('company_email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="company_address" class="col-form-label col-md-3 col-sm-3  label-align">Company
                                    Address<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="company_address" class="form-control" name="company_address">{{ old('company_address', isset($setting) ? $setting->company_address : '') }}</textarea>
                                    @if ($errors->has('company_address'))
                                        <span class="errorMessage">{{ $errors->first('company_address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label for="image" class="col-form-label col-md-3 col-sm-3  label-align">Company
                                    Image<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <div id="previous_wrapper"
                                        style="{{ empty($setting) ? 'display:block' : 'display:none' }}">
                                        <label class="chooseFile" for="upload" onclick="fileInput()">Choose
                                            Photo</label>
                                    </div>
                                    <div id="previous_wrapper-img"
                                        style="{{ empty($setting) ? 'display:none' : 'display:block' }}">
                                        <div class="vertical-center">
                                            <img src="{{ isset($setting) ? asset('/storage/upload/setting/' . $setting->id . '/' . $setting->image) : '' }}"
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
                            </form>
                        </div>
                    </div>
                    <input class="hide" type="file" id="fileInput" name="upload_photo" onchange='previewImage(this)'>
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
