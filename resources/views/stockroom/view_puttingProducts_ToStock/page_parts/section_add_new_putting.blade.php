@section('section_add_new_putting')

<div ng-show="add_new_putting_in_Dimmer">
  <div   class="dimmer_form new ui segment" style="height: auto; ">
    <h3 class="dimmer-title">@{{ FormTitle }}</h3>
    <hr/>
    <!-- Notifications-->
    <div id="publicNotificationMessage" class="publicNotificationMessage" >
      <ul>
      <li   ng-repeat="er in errors" >@{{ er }} </li>
      </ul>
    </div>

        <form class="ui form">
            <!-- Serach For PartNumber Or Product ID -->
            <div id="ui-button-puttingtoStock" class="ui buttons">
              <button id="mode0" class="ui positive button" ng-click="fiald_mode(0)">{{ Lang::get('labels.add_by_partNumber') }}</button>
              <div class="or"></div>
              <button id="mode1"class="ui  button" ng-click="fiald_mode(1)" >{{ Lang::get('labels.add_by_brand_typeInfo') }}</button>
            </div>
            <!-- Option Mode 0  -->
            <hr/>
            <div class="mode_div" ng-show="mode0_fiald" >
              <div class="three fields">
                <div class="field"></div>
                <div class="field">
                  <label>{{ Lang::get('labels.partNumber') }}</label>
                  <select  ng-model="partnumbers_id" ng-change="selectProduct(0)"  class="partnumbers_id ui search selection dropdown search-select" name="OrderStatus"  >
                    <option ng-repeat="partnum in partnumbers" value="@{{partnum.id}}" >
                      @{{partnum.stkr_prodct_partnumber_commercial}}
                    </option>
                  </select>
                </div>
                <div class="field"></div>
              </div>
            </div>
            <!-- Option Mode 1  -->
            <div class="mode_div" ng-show="mode1_fiald" >
              <div class="three fields">
                <div class="field">
                  <label>{{ Lang::get('labels.Product_brand') }}</label>
                  <select  ng-model="brandsID" ng-change="getRelatedType()"  class="brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                  <option ng-repeat="brand in brands" value="@{{brand.id}}"  >
                    @{{brand.stkr_prodct_brand_title}}
                  </option>
                  </select>
                </div>
                <div class="field">
                  <label>{{ Lang::get('labels.Product_type') }}</label>
                  <select id="TypeID"  ng-model="TypeID" ng-change="getRelatedProducts()"  class="TypeID ui search selection  dropdown search-select" name="OrderStatus"  >
                    <option ng-repeat="type in types" value="@{{type.id}}"  >
                      @{{type.stkr_prodct_type_title}}
                    </option>
                  </select>
                </div>
                <div class="field">
                <label>{{ Lang::get('labels.Product_title') }}</label>
                <select id="product_prtNum" ng-model="product_prtNum" ng-change="selectProduct(1)"  class="product_prtNum ui search selection dropdown search-select" name="OrderStatus"  >
                  <option ng-repeat="product in products" value="@{{product.id}}"  >
                    @{{product.stkr_prodct_title}}
                  </option>
                </select>
                </div>
              </div>
            </div>
            <!--- -->

            <div ng-show="resultProduct" class="resultProduct four fields">

              <div class="field">
                <label >{{ Lang::get('labels.Product_type_cat') }}  : </label> @{{ prodct_type_cat | pTypeCat }}
                <input ng-model="prodct_type_cat" type="hidden" value="prodct_type_cat" />
             </div>
              <div class="field"><label >{{ Lang::get('labels.Brand_name') }}  \ {{ Lang::get('labels.productType') }} : </label> @{{ echo_Brand }}@{{ echo_Type }} </div>
              <div class="field"><label >{{ Lang::get('labels.Product_title') }} : </label> @{{ echo_ProductTitle  }} </div>
              <div class="field"><label > {{ Lang::get('labels.Product_id') }}: </label><span style="float:  right;margin-right:  -10px;">@{{ echo_ProductID}} </span><input id="ProductID" name="ProductID" type="hidden" value="@{{ echo_ProductID}}" /></div>
            </div>
            <!--- -->
            <div ng-show="OrderStatus" class="OrderStatus four fields">

                <div class="field">
                  <!--- Order Date -->
                  <div class="field">
                    <div class="three fields">
                      <div class="field">
                        <label >{{ Lang::get('labels.day') }}   </label>
                        <select id="days" ng-model="Cdays"   class="calender days  ui search selection dropdown search-selectx" name="days" style="width:  10px !important;padding-right: 20px !important;"  >
                        <option ng-repeat="day in days" value="@{{day}}"  >
                          @{{day}}
                        </option>
                        </select>
                      </div>
                      <div class="field">
                        <label >{{ Lang::get('labels.month') }} </label>
                        <select id="months" ng-model="Cmonths"   class="calender months  ui search selection dropdown search-selectx" name="months" style="width:  10px !important;padding-right: 20px !important;" >
                        <option ng-repeat="month in months" value="@{{month}}"  >
                          @{{month}}
                        </option>
                        </select>
                      </div>
                      <div class="field">
                        <label >{{ Lang::get('labels.year') }}</label>
                        <select id="years" ng-model="Cyears"   class="calender years  ui search selection dropdown search-selectx" name="years" style="width:  10px !important;padding-right: 14px !important;"  >
                        <option ng-repeat="year in years" value="@{{year}}"  >
                          @{{year}}
                        </option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="field" >
                    <label >{{ Lang::get('labels.Product_PartNumber_comersial') }} : </label>
                    <div style="width: 85% !important;font-size:  18px;padding-top: 30px !important;"> @{{ echo_partNumber}} </div>
                  </div>

                  <!--- Order Title-->
                  <div class="wide six field">
                    <label >{{ Lang::get('labels.Order') }} ({{ Lang::get('labels.Orders_Seller_name') }})  :</label>
                    <select id="OderList" ng-model="OderList" ng-change="selectOrderId(0)"  class="OderList ui search selection dropdown search-select" name="OrderStatus"  >
                    <option ng-repeat="Oder in Oders" value="@{{Oder.orderID}}"  >
                    @{{Oder.stk_ordrs_id_code}} &nbsp;  | &nbsp;   @{{Oder.stkr_ordrs_slr_name}} ( @{{Oder.stkr_ordrs_stus_title}} )
                    </option>
                    </select>
                  </div>

                  <!--- Order Quantity -->
                  <div class="wide six field">
                    <label >{{ Lang::get('labels.qty') }} : </label>
                    <input type="text" ng-model="Quantity" ng-blur="makeSertilInput()"  />
                  </div>
            </div>
            <!--- -->
            <div ng-show="ProductStatus" class="ProductStatus inline fields">
              <div class="six wide field">
                <label style="padding-right: 5px;">{{ Lang::get('labels.partNumber_Technical') }}</label>
                <input ng-model="partNumber" type="text" >
              </div>
              <div ng-show="show_Chassis_number" class="five wide field">
                <label>{{ Lang::get('labels.Chassis_number') }}</label>
                <input ng-model="Chassis_number" type="text" >
              </div>
              <div ng-show="show_SO_number" class="five wide field">
                <label>{{ Lang::get('labels.SO_number') }}</label>
                <input ng-model="SO_number" type="text" >
              </div>
            </div>
            <!--- -->



      <div  class="SerialNumber_MainLevel "  ng-show="OrderStatus" >
          <div class="two fields">
            <div class="field">{{ Lang::get('labels.serialNumber') }} <strong> @{{ prodct_type_cat | pTypeCat }} </strong></div>
            <div class="field"></div>
          </div>
          <div class="two fields">
              <div class="field">
                <div data-ng-repeat="choice in choices">
                      <input type="text" ng-model="choice.serial_A" name="ss" placeholder="{{ Lang::get('labels.serialNumber_first') }} @{{choice.id}} "  style="width: 295px!important;    float: right;">
                      <input type="text" ng-model="choice.serial_B" name="dd" placeholder="{{ Lang::get('labels.serialNumber_last') }} @{{choice.id}}" style="width: 295px!important;">
                      <hr style="margin-top: 5px !important;margin-bottom: 5px !important;"/>
                  <button class="remove" ng-show="$last" ng-click="addNewChoice()">+</button>
                  <button class="remove" ng-show="$last" ng-click="removeChoice()">-</button>

                </div>
              </div>
              <div class="field"></div>
          </div>
    </div>


            <div class="field" ng-show="new_form_control_SaveAndNext">
              <button ng-click="addNewTo_DB(1)" class="btn btn-success">{{ Lang::get('labels.saveAndNextStep') }}</button>
              <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
            </div>

            <div class="field" ng-show="new_form_control">
              <button ng-click="addNewTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
              <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
            </div>

            <div class="field" ng-show="edit_form_control">
              <button ng-click="EditRow" class="btn btn-success">{{ Lang::get('labels.edit') }}</button>
              <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
            </div>
        </form>
  </div>
</div>

@endsection
