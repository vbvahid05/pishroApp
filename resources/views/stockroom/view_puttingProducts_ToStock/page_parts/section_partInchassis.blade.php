@section('section_partInchassis')
  <div ng-show="partInChassis_in_Dimmer">
    <div   class="ui segment"
           style="min-height:600px ;width: 190%!important;
           right: -300px;border-top: 4px solid #f2711c;
           background-image: url('/img/subChassis.png');
           background-repeat: no-repeat;background-position-y: 100%;">
        <h3 class="dimmer-title">@{{ FormTitle }} </h3>
        <hr/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage" >
          <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
        </div>
        <!-- Form Body -->
        <div class="MainBodya">
             <div class="col-md-12 ">
                 <div class="col-md-7 pull-right">
                   <div class="col-md-3 pull-right" style="text-align:  left;">  {{ Lang::get('labels.ChassisParts') }} :</div>
                   <div class="col-md-6 pull-right" style="text-align:  right;"> <h2> @{{echo_serial_numbers_a}}  | @{{echo_serial_numbers_b}} </h2></div>
                   <div class="col-md-3 pull-right"> SerialParent: @{{echo_serialParent}}  ProductParent: @{{echo_ProductParent}} </div>
                 </div>
                 <div class="col-md-5 pull-right">
                   <i class="fa fa-puzzle-piece" aria-hidden="true" style="float:  left;font-size:  33px;color: #e03997;"></i>
                 </div>

             </div>
            <hr/>
             <br/>
            <div class="divTableHeader col-md-12">
              <div class="col-md-1 pull-right"> {{ Lang::get('labels.Orders_row') }}</div>
              <div class="col-md-2 pull-right"> {{ Lang::get('labels.partNumber') }}</div>
              <div class="col-md-5 pull-right"> {{ Lang::get('labels.Product_title') }}  </div>
              <div class="col-md-1 pull-right"> {{ Lang::get('labels.QTY') }} </div>
            </div>
            <div ng-repeat="SCPAY in SubChassisPartsArry" class="divTableRowB col-md-12 ng-scope" id="productRowId@{{SCPAY.stkr_stk_putng_prdct_product_id }}">
                <div ng-click="showSerialSubFields(SCPAY.stkr_stk_putng_prdct_product_id,echo_serialParent,echo_ProductParent,SCPAY.stkr_stk_putng_prdct_qty)">
                    <div class="col-md-1 pull-right">  @{{$index+1}} </div>
                    <div class="col-md-2 pull-right"> @{{SCPAY.stkr_prodct_partnumber_commercial}}</div>
                    <div class="col-md-5 pull-right"> @{{SCPAY.stkr_stk_putng_prdct_product_id}} |  @{{SCPAY.stkr_prodct_title}} </div>
                    <div class="col-md-1 pull-right">  @{{SCPAY.stkr_stk_putng_prdct_qty}} </div>
                </div>
                <div class="subrow">
                    {{lang::get('labels.registerdSerials')}}
                    <br/>
                    <div class="TopLevelSerialNum"> @{{echo_serial_numbers_a}}  | @{{echo_serial_numbers_b}} </div>
                    <div data-ng-repeat="sns in SerialNumbers" class="serialsInDB subChassisSerial ng-scope col-md-12 pull-right">
                        <div class="subSerialBox">
                            <i class="fa fa-caret-left"></i>
                              @{{sns.serialA}} @{{sns.serialB}}
                        </div>
                        <i  ng-click="Remove_SubChassisSerial(sns.serialID,sns.serialA,SCPAY.stkr_stk_putng_prdct_product_id,serialParentW,PuttingProductIDW,qtyW)" class="fa fa-trash gray" aria-hidden="true" style="font-size:  18px;padding:  4px;"></i>
                    </div>

                  <div ng-repeat="choice in choicesx" class="srtialRow">
                      <div class="row">
                    <div class="col-sm-6  col-md-6 pull-right">
                      <label> {{ Lang::get('labels.serialNumber') }} {{ Lang::get('labels.Product_type_part') }} @{{$index + 1}}</label>
                      <input ng-model="choice.SerialA"  ng-keypress="checkEnterpressd($event ,$index+1)"  class="form-control A@{{$index + 1}} ng-pristine ng-valid ng-empty ng-touched" type="text"  placeholder="{{ Lang::get('labels.serialNumber_first') }}" >
                    </div>
                    <div class="col-sm-6 col-md-6 pull-left">
                      <div ng-show="haveTwoSerial">
                        <label >{{ Lang::get('labels.serialNumber') }} {{ Lang::get('labels.Product_type_part') }} @{{$index + 1}}</label>
                        <input  ng-model="choice.SerialB" ng-keypress="checkEnterpressdBinputs($event ,$index+1)" class="form-control B@{{$index + 1}} ng-pristine ng-valid ng-empty ng-touched" type="text"  placeholder="{{ Lang::get('labels.serialNumber_last') }}">
                      </div>
                    </div>
                      </div>
                  </div>
                  <button class="btn btn-success" ng-show="BTN_SaveSubSerial" ng-click="SaveSubSerialFields(SCPAY.stkr_stk_putng_prdct_product_id,echo_serialParent,echo_ProductParent,SCPAY.stkr_stk_putng_prdct_qty)" style="margin-top:  20px;" >
                  {{ lang::get('labels.save')}}
                  </button>
                </div>
            </div>
            <button class="btn btn-danger" ng-click="close_partInChassisDimmer(product_id,qty,productsID)" style="margin-top: 20;">  {{ Lang::get('labels.back') }}   </button>
        </div>
    </div>
  </div>
@endsection
