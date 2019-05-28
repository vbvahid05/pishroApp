

@section('section_new_edit')
  <div ng-show="section_new_edit_in_Dimmer">
    <div   class="ui segment" style="position: absolute !important;top: -300px;min-height:600px ;width: 190%!important;right: -300px;border-top: 4px solid #3fadff;">
      <h3 class="dimmer-title">@{{ FormTitle }}</h3>
      <hr/>
      <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage" >
      <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
      </div>

      <div class="main">
        <form class="ui form">
             <!-- View Stock Request Form -->
             <div ng-show ="ViewStockRequestForm" class="five fields resultProduct  greenblue " style="min-height:  65px;" >
                 <div class="field">
                   <Label>{{ Lang::get('labels.stockRequest_ID') }}  </Label>
                    @{{echo_StockRequestID}}
                  </div>
                   <div class="field">
                     <Label>{{ Lang::get('labels.stockRequest_type') }}  </Label>
                      @{{sr_type | stockRequestTYPE}}
                    </div>
                     <div class="field">
                       <Label>{{ Lang::get('labels.custommer') }} </Label>
                     @{{sr_Org_Name}} <br/>  @{{sr_custommer}}
                     </div>
                     <div class="field">
                       <label style="width:  200px;"> {{ Lang::get('labels.stockRequest_preFaktorNum') }} </Label>
                        @{{sr_preFaktorNum}}
                    </div>
                    <div class="field">
                      <Label>  {{ Lang::get('labels.stockRequest_deliveryDate') }}    </Label>
                      @{{sr_deliveryDate | Jdate}}
                    </div>
             </div> <!-- foum fields -->

               <!-- -->

<!-- -->
       <div class="tabelContainer" ng-show="tabelContainer">
         <div class="divTableHeader col-md-12" style="margin-top:  20px;">
            <div class="col-md-1 pull-right" style="width: 2px;"> #</div>
            <div class="col-md-3 pull-right"> {{ Lang::get('labels.Product_brand') }} - {{ Lang::get('labels.Product_type') }}</div>
            <div class="col-md-5 pull-right"> {{ Lang::get('labels.Product_title') }}   </div>
            <div class="col-md-2 pull-right"> {{ Lang::get('labels.Product_PartNumber_comersial') }} </div>
            <div class="col-md-1 pull-right"> {{ Lang::get('labels.QTY') }} </div>
         </div>
         <!-- -->
         <div ng-show="Loading_waitForDB" class="Loading_waitForDB Loading_waitForDB_Small" style="margin-right: -15px;height: 50%!important;"></div>
         <!--- -->

         <div ng-repeat="SRPA in stockRequestProductsArray"   class="divTableRowB col-md-12 ng-scope" id="DivRow@{{SRPA.StockRequestRowID}}" >
           <div ng-click="selectRow(SRPA.productID,SRPA.product_QTY,echo_StockRequestID,SRPA.StockRequestRowID)">
               <div class="col-md-1 pull-right"  style="width: 2px;"> @{{$index+1}}    </div>
               <div class="col-md-3 pull-right"> @{{SRPA.StockRequestRowID}}   @{{SRPA.typeCat | pTypeCat}} -      @{{SRPA.ProductBrand}}  @{{SRPA.ProductType}}  </div>
               <div class="col-md-5 pull-right"> @{{SRPA.ProductTitle}}  </div>
               <div class="col-md-2 pull-right"> @{{SRPA.product_partnumbers}}  </div>
               <div class="col-md-1 pull-right"> @{{SRPA.product_QTY}}  </div>
          </div>
               <!-- SUB Row -->

               <div class="subrow col-sm-12 col-md-12">
               <i ng-show="showspinner_Loading" class="fa fa-spinner fa-spin" style="position: absolute;z-index: 1000;font-size: 30px;color: #F44336;background: #fff;border-radius: 100px;right: 50%;"></i>

                  <div class="row" ng-repeat="chcs in choicesx" >
                    <div class="col-md-6 col-sm-6 pull-right" style="margin-bottom:  8px;" >
                      <label>@{{$index+1}}</label>
                      <input ng-if="$index<SRPA.product_QTY"  ng-model="chcs.SerialA"  ng-keypress="checkEnterpressdB($event ,$index+1)" class="A@{{$index+1}}"  ng-blur="checkThisSerial(1,SRPA.productID,$index+1)" id="serialA@{{SRPA.productID}}@{{$index+1}}" type="text" placeholder="{{ Lang::get('labels.serialNumber_first') }}">
                        <i class="serialIcon" id="serialIcon@{{SRPA.productID}}@{{$index+1}}" ></i>
                    </div>

                    <div  class="col-md-6 col-sm-6 pull-right" style="margin-bottom:  8px;">
                        <div ng-show="haveTwoSerial">
                            <label>@{{$index+1}}</label>
                            <input  ng-model="chcs.SerialB" ng-blur="checkThisSerial(2,SRPA.productID,$index+1)" ng-keypress="checkEnterpressdBinputs($event ,$index+1)" class="B@{{$index+1}}"  id="serialB@{{SRPA.productID}}@{{$index+1}}" type="text" placeholder="{{ Lang::get('labels.serialNumber_last') }}">
                            <i class="serialIcon" id="serialIconB@{{SRPA.productID}}@{{$index+1}}" ></i>
                        </div>
                    </div>
                  </div>

                  <div ng-repeat="ADSLS in addedSerials"  ng-show="(serialList !=null)" class="serialList">
                    {{--@{{ADSLS.sl_top_product_serialnumber_id | ifNotnullEchoLabel}}--}}
                      <div class="row  DivMouseOver">
                          <div class="col-md-6 pull-right">
                            {{ Lang::get('labels.serial_Product') }}
                              @{{$index+1}} :
                              {{ Lang::get('labels.serialNumber_first') }}
                            <span class="label label-primary"> @{{ ADSLS.stkr_srial_serial_numbers_a }}</span>
                          </div>
                          <div ng-show="haveTwoSerial" class="col-md-5 pull-right">
                              {{ Lang::get('labels.serialNumber_last') }}
                            <span class="label label-success">@{{ ADSLS.stkr_srial_serial_numbers_b }}</span>
                          </div>
                          <div   class="col-md-1 pull-right">
                              @can('TakeOutProducts_Delete',0)
                              <i class="fa fa-trash gray "
                                 ng-click="deleteSubChassisSerialFromTakeOutProducts(ADSLS.sl_top_StockRequestRowID,
                                                                                     ADSLS.sl_top_product_serialnumber_id ,
                                                                                     ADSLS.sl_top_productid,
                                                                                     ADSLS.sl_top_stockrequest_id,
                                                                                     sr_type)" aria-hidden="true">
                              </i>
                              @endcan
                          </div>
                      </div>
                  </div>

                   @can('TakeOutProducts_create', 1)
                   <div ng-show="save_takeOut_Btn" class="btn btn-success" ng-click="takeOutSerials(echo_StockRequestID,SRPA.productID,SRPA.StockRequestRowID,sr_type)" >
                      {{ Lang::get('labels.save') }}
                  </div>
                   @endcan

                   <div class="row"  ng-show="SRPA.typeCat ==3 ">
                       <div class="col-md-8 pull-right">
                           <div class="SubChassisPartView  ">
                               <i ng-show="showspinner_LoadingSerials" class="fa fa-spinner fa-spin" style="position: absolute;z-index: 1000;font-size: 30px;color: #956bf4;background: #fff;border-radius: 100px;right: 50%;"></i>
                               <div ng-repeat="SCPZ in subChassisParts"  class="row" ng-click="selectSubChassis(SCPZ.id)">
                                   <div   class="singleRow col-md-12 pull-right  SubChassis@{{ SCPZ.id }}"
                                          ng-click="ShowSerialToSubChassis(SCPZ.ssr_d_stockrequerst_id ,SCPZ.ssr_d_product_id , SCPZ.stockrequests_id)">
                                       <i class="fa fa-caret-left "></i>
                                       @{{ SCPZ.stockrequests_id }} /
                                       @{{ SCPZ.products_id }}
                                       @{{ SCPZ.id }}
                                       @{{ SCPZ.stkr_prodct_partnumber_commercial }}
                                       @{{ SCPZ.stkr_prodct_title }}
                                       تعداد
                                       @{{ SCPZ.ssr_d_qty}}
                                   </div>
                               </div>
                           </div>
                       </div>
                      <div class="col-md-4 pull-right">
                          <h4 style="border-top: 1px solid #efeeef;padding-top: 5px;margin-top: 10px;">
                          {{lang::get('labels.serialNumber')}} : </h4>
                          <i ng-show="showspinner" class="fa fa-spinner fa-spin" style="position: absolute;font-size:36px;margin-right: 45%;margin-top: 10%;color: #5cb85b;"></i>
                        {{-------------------------------------}}
                          <div ng-repeat="SSV in showSerialValue ">
                              @{{$index+1}} :
                              {{ Lang::get('labels.serialNumber_first') }}
                              <span class="label label-primary ng-binding">
                                @{{ SSV.stkr_srial_serial_numbers_a }}
                                </span>
                                 <span ng-show="SSV.stkr_srial_serial_numbers_b !=null" style="padding-right: 10px;"> {{ Lang::get('labels.serialNumber_last') }}</span>
                                <span class="label label-success ng-binding" ng-show="SSV.stkr_srial_serial_numbers_b !=null">
                                @{{ SSV.stkr_srial_serial_numbers_b }}
                                </span>
                              <span>
                              @can('TakeOutProducts_Delete', 1)
                                  <i class="fa fa-trash gray "  ng-click="deleteSubChassisSerialFromTakeOutProducts(SSV.sl_top_StockRequestRowID,SSV.sl_top_product_serialnumber_id ,SSV.sl_top_productid,SSV.sl_top_stockrequest_id)" aria-hidden="true"></i>
                              @endcan
                             <br/>


                              </span>
                          </div>
                          {{-------------------------------------}}
                          <hr/>
                          {{--<div ng-show="ShowSerialInput !=0" class="btn btn-success" style="display: block;margin-bottom: 10;">Save</div>--}}


                          <div ng-repeat="n in [] | range:ShowSerialInput">
                              @can('TakeOutProducts_create', 1)
                              <table class="SerialInput">
                                  <tr class="serialInputRow@{{$index+1}}" >
                                      <td>@{{$index+1}}</td>
                                      <td>
                                          <input  id="inptA@{{SRPA.StockRequestRowID}}@{{$index+1}}"   class="inptA@{{$index+1}}" type="text" ng-keypress="checkSubInputEnterpressdA($event ,$index+1,SRPA.StockRequestRowID ,sr_type )" >
                                      </td>
                                      <td ng-show="towSerial ==1">-</td>
                                      <td ng-show="towSerial ==1">
                                          <input   id="inptB@{{SRPA.StockRequestRowID}}@{{$index+1}}"  class="inptB@{{$index+1}}" type="text" ng-keypress="checkSubInputEnterpressdB($event ,$index+1,SRPA.StockRequestRowID ,sr_type)">
                                      </td>
                                  </tr>
                               </table>
                              @endcan
                          </div>
                          @cannot('TakeOutProducts_create', 1)
                              <div class=""><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
                          @endcannot
                      </div>

               </div>
                   <!-- SUB Row -->
         </div>

             <i  class="fa fa-close closeSubRow@{{ SRPA.StockRequestRowID }} hide " ng-click="removeActiveSubchassis(SRPA.StockRequestRowID)" style="font-size:25px;color:red;position: absolute;top: 7px;left: 10px;"></i>

       </div>
<!-- -->
       <div class="col-md-12">
         <div class="col-md-4"> </div>
            <div class="col-md-4" ng-show="addNew_form_control">
              <br/>
              <div ng-click="addNewTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</div>
              <div ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</div>
            </div>

            <div class="col-md-4" ng-show="edit_form_control">
              <br/>
              <div ng-click="edit_DB(0)" class="btn btn-success">{{ Lang::get('labels.edit') }}</div>
              <div ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</div>
            </div>
         <div class="col-md-4"></div>
       </div>


    </div>
  </div>
  @endsection
