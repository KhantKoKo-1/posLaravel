@extends('layouts.frontend.master')
@section('title', isset($id) ? 'Order Update' : 'Order Create')
@section('content')
    <!-- ========================= SECTION CONTENT ========================= -->
    @if (isset($id))
        <section class="section-content padding-y-sm bg-default" ng-app="myApp" ng-controller="myCtrl"
            ng-init="init({{ $id }})">
        @else
            <section class="section-content padding-y-sm bg-default" ng-app="myApp" ng-controller="myCtrl" ng-init="init('0')">
    @endif
    <div class="loading" style="display: none">Loading&#8230;</div>
    <div class="container-fluid">
        <button class="btn btn-danger" style="margin-left:97%;" href="" onClick="backPage()">
            <img src="{{ asset('asset/images/frontend/payment/previous_img.png') }}" alt="Previous" class="heightLine_06">
        </button>
        <div class="row">
            <div class="col-md-8 card padding-y-sm card ">
                <div class="input-group" style="margin-bottom: 10px;">
                    <button class="btn btn-primary" ng-click="returnBack()">
                        <img src="{{ asset('asset/images/frontend/payment/previous_img.png') }}" alt="Previous"
                            class="heightLine_06" />
                    </button>
                    <input type="text" class="form-control" placeholder="Search" ng-model="searchData"
                        ng-keyup="searchItem()" style="margin-left:10px;">
                </div>
                <span id="items">
                    <div class="row">
                        <div class="col-md-3" ng-if="showCategories" ng-repeat="category in categories">
                            <figure class="card card-product" ng-click="getChildCategory(category.id)">
                                <span class="badge-new"> Category </span>
                                <div class="img-wrap">
                                    <img ng-src="@{{ base_url }}storage/upload/category/@{{ category.id }}/@{{ category.image }}"
                                        class="img-responsive">
                                </div>
                                <figcaption class="info-wrap">
                                    <div class="action-wrap">
                                        <div class="tile_name h5">
                                            <span class="name_">@{{ category.name }}</span>
                                        </div> <!-- tile_name.// -->
                                    </div> <!-- action-wrap -->
                                </figcaption>
                            </figure> <!-- card // -->
                        </div> <!-- col // -->

                        <div class="col-md-3" ng-if="showItem" ng-repeat="item in items">
                            <figure class="card card-product" ng-click="fetchItemId(item.id)">
                                <span class="badge-new"> Item </span>
                                <div class="img-wrap">
                                    <img ng-src="@{{ base_url }}storage/upload/item/@{{ item.id }}/@{{ item.image }}"
                                        class="img-responsive">
                                </div>
                                <figcaption class="info-wrap">
                                    <div class="action-wrap">
                                        <div class="tile_name h5">
                                            <span class="name_">@{{ item.name }}</span>
                                        </div> <!-- tile_name.// -->
                                    </div> <!-- action-wrap -->
                                </figcaption>
                            </figure> <!-- card // -->
                        </div> <!-- col // -->

                    </div> <!-- row.// -->
                </span>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <span id="cart">
                        <table class="table table-hover shopping-cart-wrap">
                            <thead class="dlist-align">
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col" width="120">Qty</th>
                                    <th scope="col" width="120">Price</th>
                                    <th scope="col" width="120">Discount</th>
                                    <th scope="col" width="120">Amount</th>
                                    <th scope="col" class="text-right" width="200">Cancel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="itemData in itemDatas">
                                    <td>
                                        <h6 class="title text-truncate">@{{ itemData.name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group"
                                            aria-label="...">
                                            <button type="button"
                                                ng-class="{ 'm-btn btn btn-sm btn-primary': itemData.quantity != 1, 'm-btn btn btn-sm btn-default': itemData.quantity == 1 }"
                                                ng-click="itemQuantity('minus',itemData.id)"><i
                                                    class="fa fa-minus fa-sm"></i></button>
                                            <button style="font-weight: bold; color: #000;" type="button"
                                                class="m-btn btn btn-sm btn-default"
                                                disabled>@{{ itemData.quantity }}</button>
                                            <button type="button" class="m-btn btn btn-sm btn-danger"
                                                ng-click="itemQuantity('plus',itemData.id)"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="text-right price">@{{ itemData.price }}</var>
                                        </div> <!-- price-wrap .// -->
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="text-right price">@{{ itemData.discount_amount }}</var>
                                        </div> <!-- price-wrap .// -->
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="text-right price">@{{ itemData.total_amount }}</var>
                                        </div> <!-- price-wrap .// -->
                                    </td>
                                    <td class="text-right">
                                        <button href="" class="btn btn-outline-danger btn-sm"
                                            ng-click="cancelItem(itemData.id)"> <i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </span>
                </div> <!-- card.// -->
                <div class="box">
                    <dl class="dlist-align">
                        <dt>Total: </dt>
                        <dd class="text-right">@{{ totalPrice }}</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Discount: </dt>
                        <dd class="text-right">@{{ totalDiscount }}</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Sub Total: </dt>
                        <dd class="text-right h4 b">@{{ subTotal }}</dd>
                    </dl>
                    <div class="row">
                        <div class="col-md-5" style="margin-left:60%;">
                            @if (isset($id))
                                <a href="#" class="btn  btn-primary btn-lg btn-block"
                                    ng-click="orderConfirm('edit',{{ $id }})" ng-show="haveItem"
                                    ng-disabled="!haveItem"><i class="fa fa-shopping-bag"></i> Order </a>
                            @else
                                <a href="#" class="btn  btn-primary btn-lg btn-block"
                                    ng-click="orderConfirm('create')" ng-show="haveItem" ng-disabled="!haveItem"><i
                                        class="fa fa-shopping-bag"></i> Order
                                </a>
                            @endif
                        </div>
                    </div>
                </div> <!-- box.// -->
            </div>
        </div>
    </div><!-- container //  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
    <script src="{{ asset('asset/js/page/order.js') }}"></script>
@endsection
