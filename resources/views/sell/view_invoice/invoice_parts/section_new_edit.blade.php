<?php use App\Mylibrary\Sell\Invoice\Invoice;
 $all_Custommers= Invoice::Get_all_Custommers();
 $All_PartNumbers =Invoice::All_PartNumbers();
 ?>

@section('section_new_edit')
    <div ng-show="section_new_edit_invoice_in_Dimmer">
        {{--      DatePicker      --}}
        <script type="text/javascript">
            $(document).ready(function() {

                $(".dates").pDatepicker({
                    format: 'YYYY/MM/DD',

                });
            });
        </script>
        {{--      DatePicker      --}}
        <div   class="ui segment mainInvoice" style="  position: fixed;
                                                     top: 50%;
                                                     left: 5%;
                                                     right: 5%;
                                                     min-height: 600px;
                                                     width: 1200!important;
                                                     border-top: 4px solid #db2828;
                                                     margin-top: -400px;">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>
            <hr/>
            <div style="width: 100%;height: 20px;margin-top: -15px;">
                <div class="btn btn-primary" ng-click="invoiceConfirm(echo_invoicesID)" style="float: left;">
                    <i class="fa fa-check-circle" style="font-size:24px;color:greenyellow "></i>&nbsp;
                    {{Lang::get('labels.invoiceConfirm')}}
                </div>
            </div>
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <form class="ui form">
                    {{--@@@@@@@@@@@@@@@@@@@@--}}
                    <div ng-show="NewinvoiceRow" class="fields Newinvoice">
                        <div class="two wide field">
                            <label>{{ Lang::get('labels.invoice_alias') }}</label>
                            <div class="ui disabled input">
                                <input ng-model="invoiceAlias" type="text" style="height: 45px;">
                            </div>
                        </div>
                        <div class="three wide field">
                            <label>{{ Lang::get('labels.invoice_date') }}</label>
                                {{--<div class="input-group-addon" data-mddatetimepicker="true" data-trigger="click" data-targetselector="#exampleInput3"></div>--}}
                                <input type="text" class="form-control" id="InvoiceDate" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" />
                            {{--<label>{{ Lang::get('labels.invoice_date') }}</label>--}}
                            {{--<input id="datesX" class="dates" type="text" style="height: 45px;">--}}
                        </div>
                        <div class="two wide field">
                            <label>{{ Lang::get('labels.invoice_currency') }}</label>

                            <select id="Currency" >
                                <option ng-repeat="curnc in allcurrency" value="@{{ curnc.id }}">
                                    @{{ curnc.sic_Currency }}
                                </option>
                            </select>
                        </div>
                        <div class="six wide field">
                            <label>{{ Lang::get('labels.invoice_Custommer') }}</label>

                            <?php
                            $str_return="";
                            $str_return=$str_return.'<option value="1"> vahid</option>';
                            $str_return=$str_return.'<option value="2"> reza </option>';
                            ?>
                            <div class="select_CustommerList">
                              <select class="selectpicker" data-live-search="true"  id="custommerID"  >
                                  <?php echo $all_Custommers; ?>
                              </select>
                            </div>
                            {{--<p ng-bind-html="myHTML" compile-template></p>--}}
                       {{--<select id="custommerID" >--}}
                                {{--<option ng-repeat="custmrs in allCustommers" value="@{{ custmrs.id }}">--}}
                                    {{--@{{ custmrs.orgName }}   (@{{ custmrs.custommer_name }}  @{{ custmrs.custommer_family }})--}}
                                {{--</option>--}}
                            {{--</select>--}}
                            {{----}}

                        </div>
                        <div class="three wide field">
                            <div  ng-click="save_Invoice_Base()" class="btn btn-success mrgTop25" style="width: 100%;height:  40px; ">{{ Lang::get('labels.save') }}</div>
                        </div>
                    </div>
                    {{--@@@@@@@@@@@@@@@@@@@@--}}
                    <div ng-show="show_invoiceRow" class="four fields show_invoiceRow">
                        <div  ng-click="Edit_invoice_Row_BTN()" class="field Cpointer">
                            <label>{{ Lang::get('labels.invoice_date') }}    : </label><span class="underLine">   @{{ echo_date }}  </span>
                        </div>
                        <div class="field">
                            <label>{{ Lang::get('labels.invoice_alias') }}    :</label><span class="underLine">@{{ echo_invoiceAlias }}</span>
                        </div>
                        <div ng-click="Edit_invoice_Row_BTN()" class="seven wide field Cpointer ">
                            <label>{{ Lang::get('labels.invoice_Custommer') }} :</label><span class="underLine">@{{ echo_orgName }}</span>
                        </div>

                        <div ng-click="Edit_invoice_Row_BTN()" class="wide three field Cpointer">
                            <label> {{ Lang::get('labels.invoice_currency') }} :</label><span class="underLine">@{{ echo_Currency }}</span>
                        </div>

                        {{--<div ng-click="Edit_invoice_Row_BTN()"> {{Lang::get('labels.edit')}}</div>--}}
                    </div>
                    {{--@@@@@@@@@@@@@@@@@@@@--}}
                    <div ng-show="EditinvoiceRow" class="fields Newinvoice shadow" style="
                     padding-bottom:  10px;
    padding-top:  10;
    background:  #fff;
    position: inherit;
    box-shadow: 8px -13px 103px 8px #01050d !important;
    border-radius:  10px;">

                        <div class="two wide field">
                            <label>{{ Lang::get('labels.invoice_alias') }}</label>
                            <div class="ui disabled input">
                                <input ng-model="invoiceAlias" type="text" style="height: 45px;">
                            </div>
                        </div>
                        <div class="three wide field">
                            <label>{{ Lang::get('labels.invoice_date') }}</label>
                            <input id="datesXD" ng-model="datesXD" type="text" class="form-control"  placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" />
                            {{--<input id="datesXD" ng-model="datesXD" class="dates" type="text" style="height: 45px;">--}}
                        </div>
                        <div class="two wide field">
                            <label>{{ Lang::get('labels.invoice_currency') }}</label>

                            <select id="Currency" ng-model="Currency" >
                                <option ng-repeat="curnc in allcurrency"  value="@{{ curnc.id }}">
                                    @{{ curnc.sic_Currency }}
                                </option>
                            </select>
                        </div>
                        <div class="six wide field">
                            <label>{{ Lang::get('labels.invoice_Custommer') }}</label>

                            <div class="select_CustommerList">
                                {{--ng-model="custommerID"--}}
                              <select class="selectpicker"  data-live-search="true"  id="EditcustommerID"  dir="rtl">
                                <?php echo $all_Custommers; ?>
                              </select>
                            </div>
                        </div>
                        <div class="three wide field">
                            <div  ng-click="edit_invoice_Base_data()" class="btn btn-success mrgTop25">{{ Lang::get('labels.edit') }}</div>
                            <div  ng-click="Cancel_invoice_Base_data()" class="btn btn-warning mrgTop25">{{ Lang::get('labels.cancel') }}</div>
                        </div>

                    </div>

                    {{--@@@@@@@@@@@@@@@@@@@@@@@@--}}

                    <div ng-show="selectProductx" class="selectProduct two fields">
                        <!-- -->
                        <div class="col-md-4">
                            <div id="ui-button-puttingtoStock" class="ui buttons">
                                <button id="mode0" class="ui positive button" ng-click="fiald_mode(0)">{{ Lang::get('labels.add_by_partNumber') }}</button>
                                <div class="or"></div>
                                <button id="mode1"class="ui  button" ng-click="fiald_mode(1)" >{{ Lang::get('labels.add_by_brand_typeInfo') }}</button>
                            </div>
                        </div>
                        <!-- -->
                        <div class="col-md-9">
                            <!-- Option Mode 0  -->
                            <div class="field" ng-show="mode0_fiald"> <!--Show mode 0-->
                                <label style="position: fixed;margin-right: 130px;margin-top: 5px;">{{ Lang::get('labels.partNumber') }} :</label>

                                {{--ng-model="partnumbers_id" ng-change="selectProductByPartNum( )"--}}
                                <select class="selectpicker" data-live-search="true"   focus-me="focusInput"  id="partnumber_list"   >
                                    <?php echo $All_PartNumbers ?>
                                </select>

                            </div>
                            <!-- Option Mode 1  -->
                            <div class="field">
                                <div ng-show="mode1_fiald" class="col-md-12">
                                    <div class="col-md-3 pull-right">
                                        <select id="brandsID" ng-model="brandsID" ng-change="getRelatedType_INV()"  class="brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                                            <option ng-repeat="brand in brands" value="@{{brand.id}}"  >
                                                @{{brand.stkr_prodct_brand_title}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <select  id="TypeID" ng-model="TypeID" ng-change="getRelated_CAT_Type()"  class="TypeID brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                                            <option ng-repeat="type in types" value="@{{type.id}}"  >
                                                @{{type.type_title}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <select id="TypCatID"  ng-model="TypCatID" ng-change="getRelatedProducts()"  class="TypCatID brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                                            <option ng-repeat="typcat in TypCatIDs" value="@{{typcat.id}}"  >
                                                @{{typcat.type_cat_title}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 pull-right">



                                        <select id="ProductID" ng-model="ProductID" ng-change="getProductData()"  class="ProductID brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                                            <option ng-repeat="Product in Products" value="@{{Product.id}}"  >
                                                @{{Product.prodct_title}}
                                            </option>
                                        </select>



                                    </div>
                                </div>
                            </div>
                            <!-- -->
                        </div>
                    </div>
                    {{--@@@@@@@@@@@@@@@@@@@@--}}
                    <div ng-show="resultProduct" class="OrderStatus  two fields" style="height:  60px;">
                        <div class="col-md-1">@{{echo_prodct_type_cat}}  @{{echo_Brand}} @{{echo_Type}}</div>
                        <div class="col-md-3">@{{echo_ProductTitle}}</div>
                        <div class="col-md-2">
                             {{ Lang::get('labels.QTY') }} :
                            <input ng-model="product_QTY"  type="number" style="width: 110px !important;">
                        </div>
                        <div class="col-md-4">
                            {{ Lang::get('labels.invoice_Unit_price') }} :
                            <input ng-model="Unit_price" ng-keyup="expressionx()" type="text"  ng-keypress="checkEnterpressd($event)"  required style="width: 160px !important;">
                            @{{ echo_Currency }}
                        </div>
                        <div class="col-md-2">
                            <button id="add_product_to_invoice"  class="btn btn-info" ng-click="add_product_to_invoice_array()" style="width:  100%;">
                                <i class="fa fa-plus-square" style="font-size:14px"></i>
                                {{ Lang::get('labels.Orders_add_product') }}
                            </button>
                        </div>

                    </div>
                    {{--@@@@@@@@@@@@@@@@@@@@--}}
                </form>
                <div ng-show="productTabel">
                    <div class="divTableHeader col-md-12">
                        <div class="col-md-1 pull-right">@ </div>
                        <div class="col-md-2 pull-right">{{Lang::get('labels.Product_brand')}} / {{Lang::get('labels.Product_type')}}   </div>
                        <div class="col-md-1 pull-right">{{Lang::get('Labels.partNumber')}}</div>
                        <div class="col-md-2 pull-right">{{Lang::get('Labels.Product_title')}}</div>
                        <div class="col-md-1 pull-right" style="padding:  0;width:  50px;">{{Lang::get('Labels.qty')}}</div>
                        <div class="col-md-2 pull-right">{{Lang::get('Labels.invoice_Unit_price')}} </div>
                        <div class="col-md-1 pull-right">{{Lang::get('Labels.summery')}} </div>
                        <div class="col-md-1 pull-right">{{Lang::get('Labels.invoice_EPL_cost')}} </div>
                        <div class="col-md-1 pull-right">{{Lang::get('Labels.summery')}} </div>
                    </div>

                    <div ng-repeat="row in addedRows" class="divTableRowB col-md-12" id="DivRow@{{$index+1}}" >
                        <div class="col-md-1 pull-right">
                            <i class="fa fa-plus-circle addSubproduct"  ng-click="addSubproduct(row.invoice_id,row.invoiceDetail_Id)" aria-hidden="true" >
                                <span>
                                    {{ lang::get('labels.AddaSunchassis') }}
                                </span>
                            </i>
                        </div>
                        <div class="col-md-2 pull-right">
                            <div  style="width:20px;float:right;" >@{{  $index+1  }} </div>
                            <div class="ng-binding" style="float:  right;font-size:  25px;color: #E91E63;font-weight:  bold;">
                                   @{{row.new }}
                            </div>
                            @{{row.product_brand}}  @{{row.product_Type}}
                        </div>
                        <div class="col-md-1 pull-right text_align_left">  @{{row.partNumber}}    </div>
                        <div class="col-md-2 pull-right text_align_left">  @{{row.product_Title}}   </div>
                        <div class="col-md-1 pull-right" ng-click="change_invoice_qty(row.invoice_id,row.product_id,row.qty,$index)" style="padding:  0;width:  50px;">
                            <div class="subRowToolBar" ><i class="fa fa-pencil"></i></div>
                            @{{row.qty}}
                        </div>

                        <div class="col-md-2 pull-right invoice_unit_price" >
                            <div class="subRowToolBar"><i class="fa fa-pencil" ng-click="editUnit_price($index)"></i></div>
                            <div id="UnitpriceLable@{{$index}}" ng-click="editUnit_price($index)">  @{{row.Unit_price | Vcurrency}}  @{{ echo_Currency }} </div>
                            <span id="editUnitprice@{{$index}}"  class="editUnitpriceInput hidden">

                                <input type="text" id="inputID@{{$index}}" class="form-control " value="@{{row.Unit_price }}"   ng-keyup="addDotToPrice($index)">
                                <i class="fa fa-check saveCheckSmall" aria-hidden="true" ng-click="change_invoice_unit_price(row.invoice_id,row.product_id,row.Unit_price,$index)" ></i>
                            </span>
                        </div>


                        <div class="col-md-1 pull-right" id="TotalPrice@{{row.product_id}}">  @{{row.TotalPrice | Vcurrency  }}  @{{ echo_Currency }}  </div>
                        <div class="col-md-1 pull-right">  @{{row.EPL_price | Vcurrency}}  {{ Lang::get('labels.$') }}  </div>
                        <div class="col-md-1 pull-right invoice_unit_price ">
                            @{{row.Total_EPL_price | Vcurrency}} {{ Lang::get('labels.$') }}
                           <div class="del_invc_item" ng-click="delete_itemFromInvoiceList(row.invoice_id,row.product_id,$index+1)">
                               <i class="fa fa-trash gray " aria-hidden="true" ></i>
                           </div>
                        </div>
                {{----------------------------------}}
                        <div ng-repeat="SPD in row.SubProductData " class="SubProductData col-md-12" style="text-align: right;">
                            <div class="col-md-1 pull-right"> </div>
                            <div class="col-md-1 pull-right">  </div>
                            <div class="col-md-2 pull-right text_align_left" style=" ">@{{ SPD.partNumber }}</div>
                            <div class="col-md-2 pull-right text_align_left" style="padding-left: 10px;">@{{ SPD.product_Title }}</div>
                            <div class="col-md-1 pull-right" style="padding-right: 20px;"> @{{ SPD.qty }} </div>
                            <div class="col-md-1 pull-right"> </div>
                            <div class="col-md-1 pull-right"> </div>
                            <div class="col-md-1 pull-right">@{{ SPD.EPL_price | Vcurrency}}  {{ Lang::get('labels.$') }}</div>
                            <div class="col-md-1 pull-right">@{{ SPD.EPL_price * SPD.qty | Vcurrency}}    {{ Lang::get('labels.$') }}</div>
                        </div>
                {{----------------------------------}}
                    </div>
                    <i ng-show="waitForList" class="fa fa-spinner fa-spin" style="font-size: 60px;color: #d9534f;background: #fff;border-radius: 100px;"></i>

                    {{--@@@@@@@@@@@@@@@@@@@@--}}{{--@@@@@@@@@@@@@@@@@@@@--}}
                    {{--@@@@@@@@@@@@@@@@@@@@--}}{{--@@@@@@@@@@@@@@@@@@@@--}}
                    <div ng-showx="TotalSummeryRow" class="col-md-12 TotalSummeryBox" style="">
                        <div  class="TotalSummeryRow col-md-12">
                            <div class="invoiveDetials col-md-2 pull-right" >
                                <i class="fa fa-life-ring" aria-hidden="true"></i>
                                {{lang::get('labels.invoice_warranty')}}
                            </div>
                            <div id="invoiveDetials_warranty_Place"  class="invoiveDetials col-md-4 pull-right" >
                                <div ng-show="warranty_show"  ng-click="invoiceDetials('editbtn','warranty','')">@{{echo_warranty}}</div>
                                <div ng-show="warranty_edit"><input id="warranty_val"  ng-blur="invoiceDetials('Savebtn','warranty','')"  class="form-control"  value="@{{echo_warranty}}"> </div>
                            </div>
                            <div class="col-md-1 pull-right"> @{{ echo_TotalQty }} </div>
                            <div class="col-md-1 pull-right" style="padding-left:0;"> {{lang::get('labels.Totalsummery')}}  </div>
                            <div class="col-md-2 pull-right" style="text-align:right;"> @{{ echo_TotalPrice | Vcurrency}}   @{{ echo_Currency }}</div>
                            <div class="col-md-1 pull-right">    </div>
                            <div class="col-md-2 pull-right invoice_unit_price"style="padding:0;text-align: left;">
                                 مجموع EPL  :
                                   <strong style="float: left; font-size: 14px;color: #004e8c;">   @{{ echo_Total_EPL_price | Vcurrency}}  {{ Lang::get('labels.$') }} </strong>
                            </div>

                        </div>
                        {{--.....--}}
                        <div  class="TotalSummeryRow col-md-12">
                            <div class="invoiveDetials col-md-2 pull-right">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                {{lang::get('labels.invoice_Payment')}}
                            </div>
                            <div id="invoiveDetials_Payment_Place"  class="invoiveDetials col-md-4 pull-right">
                                <div ng-show="Payment_show"  ng-click="invoiceDetials('editbtn','Payment','')">@{{echo_Payment}}</div>
                                <div ng-show="Payment_edit"><input id="Payment_val" ng-blur="invoiceDetials('Savebtn','Payment','')" class="form-control"  value="@{{echo_Payment}}"> </div>
                            </div>
                            <div class="col-md-1 pull-right" >

                            </div>
                            <div class=" col-md-1 pull-right" >
                                <i class="fa fa-tag" aria-hidden="true"></i>
                                {{ Lang::get('labels.invoice_Discount') }}

                            </div>
                            <div class="col-md-2 pull-right"  style="text-align:  right;">
                                <button ng-show="DiscountBTN" class="btn btn-default" ng-click="invoiceDetials('newbtn','Discount','')">   <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                <div    ng-show="DiscountValue" class="EditableText"  ng-click="invoiceDetials('editbtn','Discount',echo_Discount)" > @{{echo_Discount | Vcurrency}} @{{ echo_Currency }}</div>
                            </div>
                        </div>
                        {{--.....--}}
                        <div  class="TotalSummeryRow col-md-12">
                            <div class="invoiveDetials col-md-2 pull-right">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                {{lang::get('labels.invoice_deliveryDate')}}
                            </div>

                            <div id="invoiveDetials_deliveryDate_Place" class="invoiveDetials col-md-4 pull-right">
                                <div ng-show="deliveryDate_show" ng-click="invoiceDetials('editbtn','deliveryDate','')">@{{echo_deliveryDate}}</div>
                                <div ng-show="deliveryDate_edit"><input id="deliveryDate_val" ng-blur="invoiceDetials('Savebtn','deliveryDate','')" class="form-control"  value="@{{echo_deliveryDate}}"> </div>
                            </div>


                            <div class="col-md-2 pull-right" style="text-align:left;">
                                {{Lang::get('labels.invoice_tax')}}

                                <label class="containerx ng-binding" style="width: 115px !important;float: right;">
                                    <input type="checkbox" ng-model="taxStatus" ng-click="setTaxStatus()" lass="checkboxz" value="9" ng-checked="AD.Selected == 1" checked="checked">
                                    <span class="checkmark"></span>
                                </label>


                            </div>
                            <div class="col-md-3 pull-right" style="text-align:right;">  @{{ echo_tax_price | Vcurrency}} @{{ echo_Currency }}</div>
                        </div>



                        {{--...invoice_validation ..--}}
                        <div  class="TotalSummeryRow col-md-12">
                            <div class="invoiveDetials col-md-2 pull-right">
                                   <i class="fa fa-calendar" aria-hidden="true"></i>
                                    {{lang::get('labels.invoice_validation')}}
                            </div>

                            <div id="invoice_validityDuration" class="invoiveDetials col-md-4 pull-right">
                                <div ng-show="validityDuration_show" ng-click="invoiceDetials('editbtn','validityDuration','')">@{{echo_validityDuration}}</div>
                                <div ng-show="validityDuration_edit"><input id="validityDuration_Val" ng-blur="invoiceDetials('Savebtn','validityDuration','')"  class="form-control"  value="@{{echo_validityDuration}}"> </div>
                            </div>
                            <div class="col-md-2 pull-right" style="text-align:left;background:  gray;color:#fff;"> {{Lang::get('labels.invoice_Total')}}</div>
                            <div class="col-md-3 pull-right" style="text-align:right;"> @{{ echo_Total_factor_price | Vcurrency}} @{{ echo_Currency }}</div>
                        </div>
                        {{------------------------------------}}
                        <div  class="TotalSummeryRow col-md-12">
                            <div class="invoiveDetials col-md-2 pull-right">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                {{lang::get('labels.invoice_delivery_Type')}}

                            </div>
                            <div id="invoice_delivery_Type" class="invoiveDetials col-md-4 pull-right">
                                <div ng-show="invoice_delivery_Type_show" ng-click="invoiceDetials('editbtn','invoice_delivery_Type','')">@{{echo_invoice_delivery_Type}}</div>
                                <div ng-show="invoice_delivery_Type_edit"><input id="invoice_delivery_Type_Val" ng-blur="invoiceDetials('Savebtn','invoice_delivery_Type','')"  class="form-control"  value="@{{echo_invoice_delivery_Type}}"> </div>
                            </div>
                        </div>
                        {{------------------------------------}}
                        <hr>
                        <div class="invoiceDescription col-md-12">
                            <div class="invoiceDescription_edit"  ng-show="invoiceDescription_edit">
                                <div class="col-md-1 pull-right">
                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                    {{lang::get('labels.invoice_Description')}}
                                </div>
                                <div class="col-md-10 autocomplete pull-right">
                                    {{--<textarea rows="4"  > </textarea>--}}
                                    <textarea ng-blur="save_invoice_Desc()" rows="4" id="Description_input" ng-model="Description_input"    placeholder="..." class="form-control" style="width: 100% !important;"> </textarea>
                                </div>
                                <div class="col-md-1">
                                    <i  ng-click="save_invoice_Desc()" class="fa fa-check" aria-hidden="true"></i>
                                    <i  ng-click="cancle_invoice_Desc()" class="fa fa-remove" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="invoiceDescription_view"   ng-show="invoiceDescription_view">
                                <div class="col-md-1 pull-right">
                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                    {{lang::get('labels.invoice_Description')}}
                                </div>
                                <div ng-click="edit_invoice_Desc()" class="col-md-10 autocomplete pull-right">
                                    @{{invoiceDescription_view}}
                                </div>
                                <div class="col-md-1">
                                    <i ng-click="edit_invoice_Desc()" class="fa fa-pencil"></i>
                                </div>
                            </div>

                        </div>

                        {{--.....--}}
                        <div  class="TotalSummeryRow col-md-12">

                        </div>
                        {{--.....--}}

                    </div>
                    {{--@@@@@@@@@@@@@@@@@@@@--}}{{--@@@@@@@@@@@@@@@@@@@@--}}
                    {{--@@@@@@@@@@@@@@@@@@@@--}}{{--@@@@@@@@@@@@@@@@@@@@--}}
                </div>


                <!------ ------>
                <div class="new_form_control field" ng-show="new_form_control">
                    {{--<button ng-click="addInvoiceDetailsTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</button>--}}
                    <button ng-click="closeInvoice()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
                </div>

                <div class="edit_form_control field" ng-show="edit_form_control"  style="margin-top:  70px;">
                    {{--<button ng-click="EditInvoiceLIST(0)" class="btn btn-success"><i class="fa fa-floppy-o"></i>  {{ Lang::get('labels.update') }} </button>--}}
                    <button ng-click="closeInvoice()" class="btn btn-danger ">{{ Lang::get('labels.back') }}</button>
                </div>
                {{-------}}
            </div>
        </div>
@endsection
