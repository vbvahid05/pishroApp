<?php use App\Mylibrary\Sell\Invoice\Invoice;
$All_PartNumbers =Invoice::All_PartNumbers();
?>


@section('section_add_ProductToOrder')
<div ng-show="add_ProductToOrder_in_Dimmer">
  <div class="dimmer_form other ui segment " >
    <h3 class="ui dividing header">@{{ FormTitle }}    </h3>
    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>

      <form class="ui form">
              <div class="three fields resultProduct" style="height:  70px;">
                <div class="five  wide field"><label>{{ Lang::get('labels.Order') }} </label>  @{{sellerName}}    </div>
                <div class="five   wide field"><label>{{ Lang::get('labels.Order_code') }} </label> <strong>@{{Order_code}}</strong> | @{{ordrs_id_number}}  >   </div>
                <div class="two   wide field"><label>{{ Lang::get('labels.Orders_puttingDate') }} </label> @{{Order_Date | Jdate }} </div>
                  <div class="nine  wide field">
                    <label>{{ Lang::get('labels.Orders_Status') }} </label>
                    <select id="ordStatus"  ng-model="ordStatus" class="ui search selection dropdown ng-pristine ng-valid ng-not-empty ng-touched" name="ordStatus" required   style="height: 40px !important;width: 110px !important;float: right;">
                       <option ng-repeat="status in allstatus"  value="@{{status.id}}" >
                          @{{status.stkr_ordrs_stus_title}}
                       </option>
                    </select>
                  </div>
              </div>
              <div class="field resultProduct greenblue"  style="text-align:  right;padding-right:  50px;height: auto">
              <label>{{ Lang::get('labels.Orders_comment') }} </label>
                  <div ng-if="!order_Desc_showing" class="edit_link" style="padding-left: 100px;" ng-click="edit_order_info()" >@{{orderComment}}</div>
                  <div  ng-if="order_Desc_showing" >
                    <input type="text" id="orderComment" value="@{{orderComment}}" style="width: 80% !important;">
                    {{--<textarea  id="orderComment" class="article-input"  type="text" rows="3" style="width: 80%;margin-right: 115px;" ></textarea>--}}
                    <i ng-click="update_Order_field('orderComment')" class="fa fa-check saveCheck" ></i>
                   </div>
                   <hr/>
              </div>

            <!-- -->
              <div class="selectProduct two fields">
                <!-- -->
                <div class="field">
                    <div id="ui-button-puttingtoStock" class="ui buttons">
                      <button id="mode0" class="ui positive button" ng-click="fiald_mode(0)">{{ Lang::get('labels.add_by_partNumber') }}</button>
                      <div class="or"></div>
                      <button id="mode1"class="ui  button" ng-click="fiald_mode(1)" >{{ Lang::get('labels.add_by_brand_typeInfo') }}</button>
                    </div>
                </div>
                <!-- -->
                  <div class="field">
                          <!-- Option Mode 0  -->
                          <div class="field" ng-show="mode0_fiald"> <!--Show mode 0-->

                              <label>{{ Lang::get('labels.partNumber') }}</label>
                              <select class="selectpicker" data-live-search="true"   focus-me="focusInput"  id="partnumber_list_in_Order"   >
                                  <?php echo $All_PartNumbers ?>
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
                  </div>
                <!-- -->
              </div>

              <!--- -->

              <input type="hidden" ng-model="currentChassis"></input>
              <div ng-show="resultProduct" class="OrderStatus  two fields" style="height:  60px;">
                <div class="field" style="width:  45%;">
                  <label > @{{prodct_type_cat | pTypeCat}}</label>
                  <label > @{{echo_Brand}}</label>
                  <label > @{{echo_Type}}</label>
                  <label > @{{echo_ProductTitle}}</label>
                </div>
                <div class="four fields">
                  <div class="two wide field"><label > {{ Lang::get('labels.QTY') }} :</label></div>
                  <div class="field"> <input ng-model="product_QTY"  type="number" style="width: 70px !important;"></div>

                  <div class="field">
                      <button class="btn btn-info" ng-click="add_product_to_order(formStatus)">
                      <i class="fa fa-plus-square" style="font-size:14px"></i>
                      {{ Lang::get('labels.Orders_add_product') }}
                      </button>
                  </div>

                </div>

              </div>
          <div class="btn refreshBtn" ng-click="ReloadData(OrderID)">
              <i class="fa fa-refresh"></i>
               {{lang::get('labels.refresh')}}
          </div>
              <!--- -->
              <div class="divTableHeader col-md-12">
                <div class="col-md-2 pull-right">  {{Lang::get('labels.type')}} </div>
                <div class="col-md-2 pull-right">{{ Lang::get('labels.Product_type') }} - {{ Lang::get('labels.Product_brand') }}</div>
                <div class="col-md-2 pull-right"> {{Lang::get('labels.Product_title')}} </label> </div>
                <div class="col-md-2 pull-right">  {{Lang::get('labels.Product_PartNumber_comersial')}}</div>
                <div class="col-md-1 pull-right"> {{Lang::get('labels.QTY')}} </div>
                {{--<div class="col-md-1 pull-right"> {{Lang::get('labels.inStockRoom')}} </div>--}}
                <div class="col-md-1 pull-right">   </div>
              </div>


              <div ng-repeat="row in addedRows" class="divTableRowB col-md-12" id="DivRow@{{row.product_id}}" >
                  <span class="closeSelectedRow" ng-click="close_SelectedRow(row.product_id)">

                      {{lang::get('labels.close')}}
                  </span>
                <div  ng-click="show_serial_fields(row.stkr_stk_putng_prdct_product_id,row.stkr_stk_putng_prdct_qty,row.putting_productsID)">
                  <div class="col-md-2 pull-right">@{{row.type_cat | pTypeCat}} @{{ShowBTN_addToChasiss(row.type_cat,row.rowID)}}
                      <div class="btn btn-info btnAddToChasiss"  id="btnAddToChasiss@{{row.rowID}}" ng-click="addToChasiss(row.product_id,row.productId,row.Order_id,row.putting_productsID)" >
                        <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                       </div>
                    <!--   @{{row.productId }}-  @{{row.Order_id }} -->
                  </div>
                  <div class="col-md-2 pull-right">@{{row.Brand}} -  @{{row.Type}} </div>
                  <div class="col-md-2 pull-right">  @{{row.ProductTitle}} </div>
                  <div class="col-md-2 pull-right">  @{{row.partNumber}}  </div>
                  <div class="col-md-1 pull-right" ng-click="changeQTY(row.rowID)" class="Qtyfield  field">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                    @{{row.QTY}}
                  </div>

                  {{--<div class="col-md-1 pull-right"  id="serialID@{{row.putting_productsID}}"    >--}}
                    {{--<i  class="fa fa-spinner fa-spin Loading_waitForDB_Small"  ></i>--}}
                  {{--</div>--}}

                  <div class="col-md-1 pull-right" id="DeleteLabelserialID@{{row.putting_productsID}}" ng-click="removeProductRow(row.rowID,echoOrder_id,row.putting_productsID)" class="Qtyfield  field">
                      <i class="fa fa-trash gray" aria-hidden="true" style="font-size:  18px;padding:  4px;"></i>

                  </div>
                </div>
                <hr/>
<!--- subrow -->  <!--- subrow -->  <!--- subrow -->
                <div  class="subrow">
                  <div ng-mouseover="alert();"  class="col-md-12" style="position: relative;height:  100%;padding-bottom:  50px;">
                    <div class="divTableHeader col-md-12">
                      <div class="col-md-2 pull-right">  {{Lang::get('labels.type')}} </div>
                      <div class="col-md-3 pull-right">{{ Lang::get('labels.Product_type') }} - {{ Lang::get('labels.Product_brand') }}</div>
                      <div class="col-md-3 pull-right"> {{Lang::get('labels.Product_title')}} </label> </div>
                      <div class="col-md-2 pull-right">  {{Lang::get('labels.Product_PartNumber_comersial')}}</div>
                      <div class="col-md-1 pull-right"> {{Lang::get('labels.QTY')}} </div>
                      <div class="col-md-1 pull-right"> X </div>
                    </div>

                    <div ng-show="waitForSubRows" class="Loading_waitForDB" ></div>

                    <div ng-repeat="rows in SubRows" class="divTableRowB col-md-12" id="DivRowx@{{rows.product_id}}" >

                        <div class="col-md-2 pull-right">@{{rows.type_cat | pTypeCat}} @{{ShowBTN_addToChasiss(rows.type_cat,rows.rowID)}}
                            <div class="btn btn-info btnAddToChasiss"  id="btnAddToChasissx@{{rows.rowID}}" ng-click="addToChasiss(rows.product_id,rows.productId,rows.Order_id  )" > +</div>
                            @{{rows.productId }}-  @{{rows.Order_id }}
                        </div>
                        <div class="col-md-3 pull-right">@{{rows.Brand}} -  @{{rows.Type}} </div>
                        <div class="col-md-3 pull-right">  @{{rows.ProductTitle}} </div>
                        <div class="col-md-2 pull-right">  @{{rows.partNumber}}  </div>
                        <div class="col-md-1 pull-right" ng-click="changeSubQTY(rows.putting_productsID,rows.QTY,rows.Order_id,row.productId,row.putting_productsID)" class="Qtyfield  field">
                          <i class="fa fa-edit" aria-hidden="true"></i>
                          @{{rows.QTY}}
                        </div>

                        <div class="col-md-1 pull-right" id="DeleteLabelserialID@{{rows.putting_productsID}}" ng-click="removeProductRow(rows.rowID,echoOrder_id,rows.putting_productsID,rows.productId)" class="Qtyfield  field">
                            <i class="fa fa-trash gray" aria-hidden="true" style="font-size:  14px;padding:  4px;"></i>
                        </div>


                  </div>
                  <button class="btn btn-success" style="float:left;" ng-click="AddaPartToChassis(row.Order_id,row.productId,row.Brand,rows.Type,row.ProductTitle,row.partNumber,row.putting_productsID)" >{{Lang::get('labels.AddaPartToChassis')}}</button>

                </div>
                  </div>
              </div>
          <div ng-show="Loading_waitForDB" class="Loading_waitForDB Loading_waitForDB_Small  " style="margin-right: -15px;height: 50%!important;"></div>

              <!--- -->
<p></p>
<hr/>
      <div class="new_form_control field" ng-show="new_form_control">
        <button ng-click="addNewTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
        <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
      </div>

      <div class="edit_form_control field" ng-show="edit_form_control">
        <button ng-click="EditOrder_DB(0)" class="btn btn-success"><i class="fa fa-floppy-o"></i>  {{ Lang::get('labels.edit') }} </button>
        <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
      </div>
      </form>

    </div>
</div>
  @endsection
