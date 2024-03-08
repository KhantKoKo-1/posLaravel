@extends('layouts.frontend.master')
@section('title','Payment')
@section('content')

<!-- ========================= SECTION CONTENT ========================= -->
<div class="wrapper" ng-app="myApp" ng-controller="myCtrl" ng-init="init({{$id}})"> 
<div class="container-fluid receipt" >  
<div class="row cmn-ttl cmn-ttl2">
<div class="container">
<div class="row" >
    <input type="hidden" class="void-value" id="" />
    <input type="hidden" class="void-type" id="" />
    <div class="col-lg-4 col-md-5 col-sm-6 col-6">
        <h3>Order no : @{{orderDetail.order_no}}</h3>
    </div>
  <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
        <button class="btn print-modal" id="printInvoice">
            <img src="{{asset('asset/images/frontend/payment/print_img.png')}}" alt="Print Image" class="heightLine_06">
        </button>

    <button class="btn" href="" onClick="backPage()">
        <img src="{{asset('asset/images/frontend/payment/previous_img.png')}}" alt="Previous" class="heightLine_06">
    </button>
  </div>
</div> 
</div> 
</div>
<div class="row"> 
  <div class="container"> 
    <div class="row">
        <div class="col-md-4 col-sm-4 col-6">
        <span style="font-size: 14px;margin-left:10px;">Date : @{{orderDetail.created_at['date']}}</span>
        &nbsp;&nbsp;&nbsp;
        <span style="font-size: 14px;">Time : @{{orderDetail.created_at['time']}}</span>
            <div class="table-responsive">
                <table class="table receipt-table">
                    <tr>
                        <td>Sub Total</td>
                        <td>@{{totalAmount}}</td>
                    </tr>
                    <tr >
                        <td colspan="2" class="bg-gray">Item</td>
                        <td colspan="2" class="bg-gray">Quantity</td>
                        <td colspan="2" class="bg-gray">Amount</td>
                    </tr>
                    <tr ng-repeat="item in orderItems">
                        <td colspan="2">@{{item['items'][0].name}}</td>
                        <td colspan="2">@{{item.quantity}}</td>
                        <td colspan="2" style="text-align: left;">@{{item.sub_total}}</td>
                    </tr> 

                </table>
            </div><!-- table-responsive -->

            <h3 class="receipt-ttl">TOTAL - @{{totalAmount}}</h3>
            <div class="table-responsive">
                <table class="table receipt-table" id="invoice-table">
                    <tr class="before-tr" style="height: 32px;">
                        <td colspan="2" class="bl-data"></td>
                    </tr>
                    <tr class="tender" ng-repeat = "cashAmount in cashAmounts" ng-class="{ 'bg-gray': selectIndex.includes(cashAmount.index) }">
                        <td>
                  
                        </td>
                        <td class="selectedAmount" ng-click="cashMoneyClick(cashAmount.index)" >@{{cashAmount.cash}}</td>
                    </tr>
                      <tr>
                        <td>Customer Pay</td>
                        <td class="balance">@{{payMoney}}</td>
                      </tr>
                      <tr>
                        <td>Refund</td>
                        <td class="change">
                        @{{refund}}
                        </td>
                      </tr>
                    </table>
                  </div><!-- table-responsive -->
                    <div class="row receipt-btn02">
                        <!-- <div class="col-md-6 col-sm-6 col-6">
                            <button class="btn btn-primary item-modal" data-toggle="modal" data-target="#printModal">ITEM LISTS</button>
                        </div> -->
                        <div class="col-md-6 col-sm-6 col-6">
                          <a class="btn btn-primary view-btn" href="{{asset('order-detail')}}/@{{orderDetail.id}}">VIEW DETAILS</a>
                        </div>
                    </div>

                </div> 
                <div class="col-md-8 col-sm-8 col-6">
                  <div class="row"> 
                    <div class="col-md-12 list-group" id="myList" role="tablist">
                        <a class="list-group-item list-group-item-action heightLine_05 active" data-toggle="list" href="#home" role="tab" id="payment-cash">
                          <span class="receipt-type cash-img"></span><span class="receipt-txt">Cash</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#profile" role="tab" id="payment-card">
                          <span class="receipt-type card-img"></span><span class="receipt-txt">Card</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#messages" role="tab" id="payment-voucher">
                          <span class="receipt-type voucher-img"></span><span class="receipt-txt">Voucher</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-nocollection">
                          <span class="receipt-type collection-img"></span><span class="receipt-txt">No Collection</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-loyalty">
                          <span class="receipt-type loyality-img"></span><span class="receipt-txt">Loyalty</span>
                        </a>
                    </div> <!-- list-group -->
                    <div class="col-md-12">
                    <div class="tab-content row">
                      <div class="tab-pane active" id="home" role="tabpanel" >
                        <button class="btn heightLine_04 cash-payment" id="CASH" ng-click = "cashPayment(0)" ng-disabled="isDisabled"><span class="extra-cash"></span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH50" ng-click = "cashPayment(50)" ng-disabled="isDisabled"><span class="money">50</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH100" ng-click = "cashPayment(100)" ng-disabled="isDisabled"><span class="money">100</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH200" ng-click = "cashPayment(200)" ng-disabled="isDisabled"><span class="money">200</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH500" ng-click = "cashPayment(500)" ng-disabled="isDisabled"><span class="money">500</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH1000" ng-click = "cashPayment(1000)" ng-disabled="isDisabled"><span class="money">1000</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH5000" ng-click = "cashPayment(5000)" ng-disabled="isDisabled"><span class="money">5000</span><span>Kyats</span> </button>
                        <button class="btn heightLine_04 cash-payment" id="CASH10000" ng-click = "cashPayment(10000)" ng-disabled="isDisabled"><span class="money">10000</span><span>Kyats</span></button>
                      </div>
                      <div class="tab-pane" id="profile" role="tabpanel">
                            <button class="btn heightLine_05 mpu-type agd-mpu card-payment" id="MPU_AGD"><span class="receipt-type cash-img"></span><span class="receipt-txt">AGD</span></button>
                            <button class="btn heightLine_05 mpu-type kbz-mpu card-payment" id="MPU_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type uab-mpu card-payment" id="MPU_UAB"><span class="receipt-type cash-img"></span><span class="receipt-txt">UAB</span></button>
                            <button class="btn heightLine_05 mpu-type mob-mpu card-payment" id="MPU_MOB"><span class="receipt-type cash-img"></span><span class="receipt-txt">MOB</span></button>
                            <button class="btn heightLine_05 mpu-type chd-mpu card-payment" id="MPU_CHD"><span class="receipt-type cash-img"></span><span class="receipt-txt">CHD</span></button>
                            <button class="btn heightLine_05 mpu-type kbz-visa card-payment" id="VISA_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type cb-visa card-payment" id="VISA_CB"><span class="receipt-type cash-img"></span><span class="receipt-txt">CB</span></button>
                      </div>
                    </div>
                    </div>
                    <div class="payment-cal col-md-12"> 
                      <div class="row"> 
                        <div class="col-md-12 payment-show">
                          <p class="amount-quantity" style="min-height: 33px;">@{{paymentQty}}</p>
                        </div>
                        <div class="col-md-12 receipt-btn3"> 
                          <button class="btn quantity" id="1" ng-click = "numberClick(1)">1</button>
                          <button class="btn quantity" id="2" ng-click = "numberClick(2)">2</button>
                          <button class="btn quantity" id="3" ng-click = "numberClick(3)">3</button>
                          <button class="btn quantity" id="4" ng-click = "numberClick(4)">4</button>
                          <button class="btn quantity" id="5" ng-click = "numberClick(5)">5</button>
                          <button class="btn quantity" id="6" ng-click = "numberClick(6)">6</button>
                          <button class="btn quantity" id="7" ng-click = "numberClick(7)">7</button>
                          <button class="btn quantity" id="8" ng-click = "numberClick(8)">8</button>
                          <button class="btn quantity" id="9" ng-click = "numberClick(9)">9</button>
                          <button class="btn quantity" id="0" ng-click = "numberClick(0)">0</button>
                        </div>
                        <div class="col-md-12 receipt-btn4">                       
                            <button class="btn btn-primary void-btn" id = 'void-item' ng-click = "void()">VOID <i class="fas fa-trash-alt"></i></button>
                            <button class="btn clear-input-btn" ng-click = "clearInput()">CLEAR INPUT</button>
                            <button class="btn btn-primary foc-btn" ng-click = "storePayment(orderDetail.id)" ng-disabled="!isDisabled">To Pay</button>
                        </div>
                      </div>
                    </div>
                  </div> <!-- row -->     
                </div> <!-- col-md-8 -->

              </div>

            </div> 
          </div>
    </div><!-- container-fluid -->
</div><!-- wrapper -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->
<script src="{{asset('asset/js/page/payment.js')}}"></script>
@endsection