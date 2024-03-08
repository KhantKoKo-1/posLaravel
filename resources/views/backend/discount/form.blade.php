@extends('layouts.backend.master')
<!-- page content -->
@section('title', isset($discount) ? 'Discount Update' : 'Discount Create')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{isset($discount) ? 'Discount Promotion Update' : 'Discount Promotion Create'}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if(isset($discount))
                            <form action="{{route('updateDiscountForm')}}" method="POST" >
                            <input name="id" type="hidden" value="{{  $discount->id  }}" />
                        @else
                            <form action="{{route('storeDiscountForm')}}" method="POST" >
                        @endif
                            @csrf
                            <!-- <span class="section"> Promotion Info</span> -->
                            <div class="field item form-group">
                                <label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Promotion Name<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input id="name" class="form-control" name="name" value="{{ old('name',isset($discount) ? $discount->name : '') }}" />   
                                </div>
                                @if ($errors -> has('name')) <span class="errorMessage">{{$errors->first('name')}}</span> @endif
                            </div>
                          
                            <div class="field item form-group">
                            <label for="discount_type" class="col-form-label col-md-3 col-sm-3  label-align">Discount Type<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <div style="margin-top:9px;">
                                        <input type="radio" id="percentage" name="discount_type" value="percentage" {{ (old('discount_type') == 'percentage' || (isset($discount) && $discount->percentage !== null)) ? 'checked' : '' }} />
                                        <label for="percentage">Percentage</label>
                                        <input type="radio" id="cash" name="discount_type" value="cash" {{ (old('discount_type') == 'cash' || (isset($discount) && $discount->amount !== null)) ? 'checked' : '' }} />
                                        <label for="cash">Cash</label>  
                                    </div>
                                </div>
                                @if ($errors -> has('discount_type')) <span class="errorMessage">{{$errors->first('discount_type')}}</span> @endif
                                </div>
                                <div class="field item form-group">
                                <label for="amount" class="col-form-label col-md-3 col-sm-3  label-align"><span class = "discount_amount">Discount Percentage Amount</span><span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', isset($discount) ? ($discount->amount ?? $discount->percentage) : '') }}" />
                                    </div>
                                    @if ($errors -> has('amount')) <span class="errorMessage">{{$errors->first('amount')}}</span> @endif
                                </div>
                                @if(isset($discount))	
                                    <div class="field item form-group">
                                    <label for="Status" class="col-form-label col-md-3 col-sm-3  label-align">Status<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                    <select id="Status" name="status" class="select2_group form-control">
                                        <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>SELECT ONE</option>
                                        <option value="0" {{ old('status') == 0 || (!old('status') && isset($discount) && $discount->status == 0) ? 'selected' : '' }}>Enable</option>
                                        <option value="1" {{ old('status') == 1 || (!old('status') && isset($discount) && $discount->status == 1) ? 'selected' : '' }}>Disable</option>
                                    </select>
                                    </div>
                                    </div>
                                @endif
                            <div class="field item form-group">
                                <label for="start_date" class="col-form-label col-md-3 col-sm-3  label-align">Start Date<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="start_date" id="start_date" value="{{ old('start_date', isset($discount) ? dateFormatmdY($discount->start_date) : '') }}" aria-describedby="inputSuccess2Status" readonly>
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                @if ($errors -> has('start_date')) <span class="errorMessage">{{$errors->first('start_date')}}</span> @endif
                            </div>
                            <div class="field item form-group">
                                <label for="end_date" class="col-form-label col-md-3 col-sm-3  label-align">End Date<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="end_date" id="end_date" value="{{ old('end_date',isset($discount) ? dateFormatmdY($discount->end_date) : '') }}" aria-describedby="inputSuccess2Status2" readonly>
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                </div>
                                @if ($errors -> has('end_date')) <span class="errorMessage">{{$errors->first('end_date')}}</span> @endif
                            </div>
                            <div class="field item form-group">
                                <label for="Parent" class="col-form-label col-md-3 col-sm-3  label-align">Item<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <div class = "row">
                                    @foreach($items as $item) 
                                        <div class="col-md-5">
                                            <input type="checkbox" class="flat" id="item{{ $item->id }}" name="item[]" value="{{ $item->id }}" {{ (old('item') && in_array($item->id, old('item'))) || (!old('item')) && (isset($discount) && is_array($itemIds) && in_array($item->id, $itemIds)) ? 'checked' : '' }} />
                                            <label for="item{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach

                                    </div>             				
                                </div>
                                @if ($errors -> has('item')) <span class="errorMessage">{{$errors->first('item')}}</span> @endif
                            </div>
                            <div class="field item form-group">
                            <label for="single_cal2" class="col-form-label col-md-3 col-sm-3  label-align">Description<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                            <textarea id="description" class="form-control" name="description">{{ old('description', isset($discount) ? $discount->description : '') }}</textarea>
                            </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit' class="btn btn-primary">Submit</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <input type="hidden" name="form_sub" value = "1"/>
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

			
@include('layouts.backend.partial.footer_start')	
@include('layouts.backend.partial.footer_end')
<!-- /footer end -->

<!-- jquery is here -->
<!-- jquery end -->
@include('layouts.backend.partial.footer_end_html')
@endsection