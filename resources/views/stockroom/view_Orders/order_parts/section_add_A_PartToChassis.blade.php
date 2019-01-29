@section('section_add_A_PartToChassis')

<div ng-show="add_A_PartToChassis_in_Dimmer">
  <div class="dimmer_form other ui segment " >
    <h3 class="ui dividing header">@{{ FormTitle }} </h3>
    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>

      <form class="ui form">
          <div class="six fields">
              <div class="field">{{ Lang::get('labels.ChassisInfo') }} : </div>

              <div class="wide ten field">
                  <label > @{{chassis_partNumber}}</label>
                  <label style="width:  450px;" > @{{chassis_title}}</label>
                  <label > @{{chassis_Brand}}   @{{chassis_Type}}  </label>
              </div>


              <div class="field">
                   <label>{{ Lang::get('labels.Chassis_number') }} :  @{{chassis_id}}</label>
                  <label> {{ Lang::get('labels.Orders_ID') }} : @{{orderID}}</label>
              </div>
          </div>

          <div class="selectProduct two fields">
            <!-- -->
            <div class="field">
                <div id="ui-button-puttingtoStock" class="ui buttons">
                  <button id="modex0" class="ui positive button" ng-click="fiald_mode(0)">{{ Lang::get('labels.add_by_partNumber') }}</button>
                  <div class="or"></div>
                  <button id="modex1"class="ui  button" ng-click="fiald_mode(1)" >{{ Lang::get('labels.add_by_brand_typeInfo') }}</button>
                </div>
            </div>
            <!-- -->
              <div class="field">
                      <!-- Option Mode 0  -->
                      <div class="field" ng-show="mode0_fiald"> <!--Show mode 0-->
                          <label></label>

                          <select focus-me="focusInput"  ng-model="partnumbers_id" ng-change="selectProduct(0)"  class="partnumbers_id ui search selection dropdown search-select" name="OrderStatus"  >
                            <option ng-repeat="partnum in partnumbersByCatType" value="@{{partnum.id}}" >
                              @{{partnum.stkr_prodct_partnumber_commercial}}
                            </option>
                          </select>
                      </div>
                     <!-- Option Mode 1  -->
                     <div class="field">
                        <div class="three fields mode_div" ng-show="mode1_fiald" > <!--Show mode 1-->
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
                                <select id="TypeID"  ng-model="TypeID" ng-change="getRelatedProducts_ByType(2)"  class="TypeID ui search selection  dropdown search-select" name="OrderStatus"  >
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
              </div>
            <!-- -->
          </div>

          <div ng-show="resultProduct" class="OrderStatus  two fields" style="height:  100px;padding-top: 30px;">
            <div class="field" style="width:  45%;">
              <label > @{{prodct_type_cat | pTypeCat}}</label>
              <label > @{{echo_Brand}}</label>
              <label > @{{echo_Type}}</label>
              <label > @{{echo_ProductTitle}}</label>
            </div>
            <div class="four fields">
                <div class="two wide field"><label > {{ Lang::get('labels.QTY') }} :</label></div>
                <div class="field"> <input ng-model="product_QTY"  type="number" style="width: 70px !important;"></div>
                <div class="wide twelve field">
                    <button class="btn btn-info pull-right" ng-click="add_ChassesPart_to_DB(chassis_id,echo_ProductID,orderID,puttingStockID,putting_productsID)" style="float:  left;">
                        <i class="fa fa-plus-square" style="font-size:14px"></i>
                        {{ Lang::get('labels.Orders_add_product') }}
                    </button>
                </div>
                </div>
          </div>
          <button class="btn btn-danger" ng-click="backToEditPage(chassis_id)"   style="float:  left;margin-top:  15px;margin-left:  -10px;"     >{{ Lang::get('labels.back') }}</button>
      </form>


  </div>
</div>
@endsection
