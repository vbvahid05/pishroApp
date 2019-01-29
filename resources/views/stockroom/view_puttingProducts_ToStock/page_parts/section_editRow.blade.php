@section('section_editRow')
  <div ng-show="editRow_in_Dimmer">
      <div class="ui segment" style="border-top: 5px solid #3fadff;position: fixed;top: 0em !important;right: 0em !important;width: 100% !important;height: 100% !important;">
          <div ng-click="closeEditDimmer()" class="btn btn-info btn-s" style="float:  left;top: 28px !important;position: relative;">
              {{ Lang::get('labels.back') }}
              <i class="fa fa-arrow-left" aria-hidden="true" ></i>
          </div>
        <h3 class="dimmer-title">@{{ FormTitle }}</h3>
        <hr/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage" >
          <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
        </div>


<div class="main">
    <div class="col-md-12">
        <input ng-model="lastId" type="hidden"  />
        <div class="col-md-3 pull-right" style="background:  #f4f4f4;border-radius:  5px;line-height:  3;
        border-right: 5px solid #4CAF50;">
        <label>{{ Lang::get('labels.Order_code') }} </label> <strong class="ng-binding" style="font-size:  18px;"> @{{ordrs_id_code}}</strong>  |  @{{ordrs_id_number}}  </div>
        <div class="col-md-3 pull-right"> <label>{{ Lang::get('labels.Order') }} </label>@{{seler_name}} </div>
        <div class="col-md-3 pull-right"> <label>{{ Lang::get('labels.Orders_puttingDate') }}  </label>  @{{ordrs_putting_date | Jdate}}</div>
        <div class="col-md-3 alert-warning pull-right" >
            <div   ng-repeat="operr in onPageError"> @{{operr}}</div>
        </div>
    </div>

  <hr/>
  <div   >...</div>

  <div class="orderForm">
  <div class="divTableHeader col-md-12">
     <div class="col-md-1 pull-right"> # </div>
     <div class="col-md-2 pull-right">  {{Lang::get('labels.Product_brand')}}  {{Lang::get('labels.Product_type')}} </div>
     <div class="col-md-2 pull-right">  {{Lang::get('labels.Product_PartNumber_comersial')}}</div>
     <div class="col-md-1 pull-right"> {{Lang::get('labels.Product_type_cat')}} </label> </div>
     <div class="col-md-4 pull-right"> {{Lang::get('labels.Product_title')}} </div>
     <div class="col-md-1 pull-right">{{ Lang::get('labels.QTY') }} </div>
  </div>


  <div ng-repeat="APIO in AllProductsInOrder" class="divTableRowB subBTNinRow col-md-12" id="productRowId@{{APIO.stkr_stk_putng_prdct_product_id}}"  >
      <div class="col-md-1 pull-right"> <span class="numberBorder purple" >@{{$index + 1}} </span></div>
       <div class="col-md-2 pull-right"> @{{ APIO.stkr_prodct_brand_title}}  @{{ APIO.stkr_prodct_type_title}}</div>
       <div class="col-md-2 pull-right"> @{{ APIO.stkr_prodct_partnumber_commercial}}
       <div class="subRow-Box">
           <div class="subRow-btn">
               <?php $r=false;$t=false;?>
               @can('PuttingProduct_create', 1) <?php $r=true;?> @endcan
               @can('PuttingProduct_update', 1)<?php $t=true; ?>@endcan

               @if ($r || $t)
                    <a class="btn btn-info" ng-click="show_serial_fields('Insert_Serila',APIO.stkr_stk_putng_prdct_product_id,APIO.stkr_stk_putng_prdct_qty,APIO.putting_productsID)" style="padding: 2px;">{{ Lang::get('labels.insert_serialNumber') }} </a>
               @endif



                <a class="btn btn-primary" ng-click="show_serial_fields('Show_Serila',APIO.stkr_stk_putng_prdct_product_id,APIO.stkr_stk_putng_prdct_qty,APIO.putting_productsID)" style="padding:  2px;"> {{ Lang::get('labels.show_serialNumber') }}  </a>
           </div>
       </div>
       </div>
       <div class="col-md-1 pull-right"> @{{ APIO.stkr_prodct_type_cat | pTypeCat}} </div>
       <div class="col-md-4 pull-right"> @{{ APIO.stkr_prodct_title}} </div>
       <div class="col-md-1 pull-right"> @{{ APIO.stkr_stk_putng_prdct_qty}} </div>
       <hr/>
{{-- *****Sub Row ***** --}}
    <div class="subrow">

        <div ng-show="subrowMessage_editMode" class="subrowMessage"  ng-if="choicesx.length===0" > {{lang::get('labels.msg_allserialsadded')}}</div>
        <div data-ng-repeat="choice in choicesx" class="row srtialRow  ng-scope col-md-12 pull-right">
            <div class="col-md-6 pull-right"><label>  @{{$index + 1}} </label>
            <input  ng-model="choice.SerialA" class="form-control A@{{$index + 1}}"  ng-keypress="checkEnterpressd($event ,$index+1)"   type="text" placeholder="{{ Lang::get('labels.serialNumber_first') }}"/>  </div>
            <div ng-show="haveTwoSerial" class="col-md-6 pull-left "> <label> @{{$index + 1}}</label>
            <input  ng-model="choice.SerialB" class="form-control B@{{$index + 1}}"  ng-keypress="checkEnterpressdBinputs($event ,$index+1)" type="text" placeholder="{{ Lang::get('labels.serialNumber_last') }}" /> </div>
        </div>
        <button ng-show="editSerialBTN_inLine" class="btn  editSerialBTN_inLine btn-success" ng-click="EditSerialNumbers(APIO.stkr_stk_putng_prdct_product_id ,APIO.putting_productsID, APIO.stkr_stk_putng_prdct_qty)" > <i class="fa fa-save"></i>  {{ Lang::get('labels.insert_serialNumber') }} </button>
        {{--Table--}}
        <div class="divTablez col-md-12 col-sm-12">
             <div class="row">
                 <div class="col-md-1 pull-right divTableRowCHeader"> #</div>
                 <div class="col-md-1 pull-right divTableRowCHeader"> {{ Lang::get('labels.id') }} </div>
                 <div class="col-md-2 pull-right divTableRowCHeader"> {{ Lang::get('labels.management') }} </div>
                 <div class="col-md-2 pull-right divTableRowCHeader"> {{ Lang::get('labels.serialNumber_first') }} </div>
                 <div class="col-md-2 pull-right divTableRowCHeader"> {{ Lang::get('labels.serialNumber_last') }} </div>
                 <div class="col-md-2 pull-right divTableRowCHeader"> {{ Lang::get('labels.serialNumberQty') }} </div>
                 <div class="col-md-1 pull-right  divTableRowCHeader"> {{ Lang::get('labels.serialStatus') }} </div>
                 <div class="col-md-1 pull-right  divTableRowCHeader"> &nbsp; </div>
             </div>
             <div data-ng-repeat="sns in SerialNumbers" class="row serialsInDB  col-md-12 pull-right">
               <div id="Row@{{sns.id}}">
                 <div class="col-md-1 pull-right">  @{{$index+1}}  </div>
                 <div class="col-md-1 pull-right">  @{{APIO.putting_productsID}}* @{{sns.id}} </div>
                 <div class="col-md-2 pull-right">
                     @can('PuttingProduct_delete', 1)
                        <i ng-click="deleteSerialNumber(sns.id,APIO.stkr_stk_putng_prdct_product_id,APIO.stkr_stk_putng_prdct_qty,APIO.putting_productsID,APIO.stkr_prodct_type_cat)" class="fa fa-trash gray" aria-hidden="true" style="font-size:  18px;padding:  4px;"></i>
                     @endcan
                     <span  ng-if="APIO.stkr_prodct_type_cat ==3"  class="subChassisSerialBTN">
                         <button  ng-click="Show_SubChassis_Parts(sns.id,APIO.putting_productsID ,sns.S1,sns.S2,APIO.stkr_prodct_type_cat ,APIO.stkr_stk_putng_prdct_product_id,APIO.stkr_stk_putng_prdct_qty,APIO.putting_productsID)" type="button"  class="btn btn-warning">
                            <i class="fa fa-puzzle-piece" aria-hidden="true" style=" font-size:15px;"></i>
                             {{lang::get('labels.subchassisSerials')}}
                         </button>
                     </span>
                 </div>
                 <div class="col-md-2 pull-right "> @{{sns.S1}} </div>
                 <div class="col-md-2 pull-right">  @{{sns.S2}} </div>
                 <div class="col-md-2 pull-right">  @{{sns.count | checkTotal:sns.totalQTY :sns.id}} </div>
                 <div class="col-md-1 pull-right "> <div class="red"> @{{sns.SrialStatus | checkSerialStatus}} </div> </div>
                 <div class="col-md-1 pull-right"> &nbsp; </div>
               </div>
             </div>
        </div>
   </div>
{{-- *****Sub Row ***** --}}
  </div>

{{--EndMain--}}
</div>


        <!-- Form Body -->

  </div>
@endsection
