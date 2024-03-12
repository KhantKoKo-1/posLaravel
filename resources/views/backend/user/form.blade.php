@extends('layouts.backend.master')
@section('title', isset($account) ? 'Account Update Form' : 'Account Create Form')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ isset($account) ? 'Account Update' : 'Account Create' }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        @if (!isset($account))
                            <form id="accountSwitch" action="{{ url('sg-backend/account/store/') }}" method="GET">
                                <button type="button" value="admin"
                                    class="btn {{ isset($accountType) && $accountType === 'admin' ? 'btn-primary active' : 'btn-default' }}"
                                    @if (!isset($accountType) || $accountType !== 'admin') onclick="confirmBox('Are you sure switch admin account type', 'accountSwitch', event)" @endif>
                                    Admin
                                </button>
                                <button type="button" value="cashier"
                                    class="btn {{ !isset($accountType) || $accountType === 'cashier' ? 'btn-primary active' : 'btn-default' }}"
                                    @if (isset($accountType) && $accountType !== 'cashier') onclick="confirmBox('Are you sure switch cashier account type', 'accountSwitch', event)" @endif>
                                    Cashier
                                </button>
                            </form>
                        @endif
                        <div class="">
                            @if (isset($account))
                                <form action="{{ route('updateAccountForm') }}" method="POST" enctype="multipart/form-data"
                                    novalidate>
                                    <div>
                                        <button class="btn btn-sm btn-secondary">
                                            <a href="/sg-backend/item/list" style="color: white;">Back</a>
                                        </button>
                                    </div>
                                    <input name="id" type="hidden" value="{{ $account->id }}" />
                                @else
                                    <form action="{{ route('storeAccountForm') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                            @endif
                            @csrf
                            <span class="section">
                                {{ isset($accountType) && $accountType === 'admin' ? 'Admin Account Info' : 'Cashier Account Info' }}
                            </span>
                            <div class="row justify-content-end">
                                <div class="col-md-4 col-sm-6">
                                    <div class="btn-group btn-toggle">
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if (!isset($editType) || $editType == 'account_info')
                                <div class="field item form-group">
                                    <label for="username"
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ isset($accountType) && $accountType === 'admin' ? 'Admin Name' : 'Cashier Name' }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="username"
                                            type='{{ !isset($accountType) || $accountType !== 'admin' ? 'number' : '' }}'
                                            class="form-control" name="username"
                                            value="{{ old('username', isset($account) ? $account->username : '') }}" />
                                    </div>
                                    @if ($errors->has('username'))
                                        <span class="errorMessage">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                            @endif
                            @if (isset($editType) && $editType == 'password')
                                <div class="field item form-group">
                                    <label for="old_password" class="col-form-label col-md-3 col-sm-3  label-align">Old
                                        Password<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="old_password" class="form-control" name="old_password"
                                            value="{{ old('old_password') }}" />
                                    </div>
                                    @if ($errors->has('old_password'))
                                        <span class="errorMessage">{{ $errors->first('old_password') }}</span>
                                    @endif
                                </div>
                            @endif
                            @if (!isset($editType) || $editType == 'password')
                                <div class="field item form-group">
                                    <label for="password"
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ isset($editType) ? 'New password' : 'password' }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="password" id="password" class="form-control" name="password"
                                            value="" />
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="errorMessage">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="field item form-group">
                                    <label for="confirm_password"
                                        class="col-form-label col-md-3 col-sm-3  label-align">Confirm Password<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="confirm_password" value="" />
                                    </div>
                                    @if ($errors->has('confirm_password'))
                                        <span class="errorMessage">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                            @endif
                            @if (isset($account) && $editType == 'account_info')
                                <div class="field item form-group">
                                    <label for="status" class="col-form-label col-md-3 col-sm-3  label-align">Status<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select id="status" name = "status" class="select2_group form-control">
                                            <option value="" disabled>SELECT ONE</option>
                                            <option value="0"
                                                {{ old('status', isset($account) && $account->status == 0 ? 'selected' : '') }}>
                                                Enable</option>
                                            <option value="1"
                                                {{ old('status', isset($account) && $account->status == 1 ? 'selected' : '') }}>
                                                Disable</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit' class="btn btn-primary">Submit</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <input name= 'account_type' type='hidden'
                                            value="{{ !isset($accountType) || $accountType !== 'admin' ? 'cashier' : 'admin' }}"></input>
                                        <input name= 'editType' type='hidden'
                                            value="{{ isset($editType) && $editType !== 'password' ? 'company_info' : 'password' }}"></input>
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

    <!-- footer end -->
    @include('layouts.backend.partial.footer_end')
    <!-- /footer end -->

    <!-- jquery is here -->
    <!-- jquery end -->

    @include('layouts.backend.partial.footer_end_html')
@endsection
