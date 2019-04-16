<?php use App\Mylibrary\Sell\Invoice\Invoice;
$All_PartNumbers =Invoice::All_PartNumbers();
?>
@section('section_addSubProduct_dimmer')
    <div ng-show="section_addSubProduct_dimmer">
        <div   class="ui segment" style="position: absolute !important;
                                        top: 50%;
                                        left: 50%;
                                        min-height: 500px;
                                        width: 1100px!important;
                                        border-top: 4px solid #dbd600;
                                        margin-left: -550px;
                                        margin-top: -400px;
                                        z-index: 20000;
">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>

            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">

                <!------ ------>

                <div ng-show="selectProductx" class="selectProduct two fields col-md-12">
                    <!-- -->
                    <div class="col-md-4 pull-right">
                        <div id="ui-button-puttingtoStock" class="ui buttons">
                            <button id="modeB0" class="ui positive button" ng-click="fiald_modeB(0)">{{ Lang::get('labels.add_by_partNumber') }}</button>
                            <div class="or"></div>
                            <button id="modeB1"class="ui  button" ng-click="fiald_modeB(1)" >{{ Lang::get('labels.add_by_brand_typeInfo') }}</button>
                        </div>
                    </div>
                    <!-- -->
                    <div class="col-md-8 ">
                        <!-- Option Mode 0  -->
                        <div class="field" ng-show="modeB0_fiald"> <!--Show mode 0-->

                            <div class="All_PartNumbersInSubProduct">
                                <label >{{ Lang::get('labels.partNumber') }} :</label>
                                <select class="selectpicker" data-live-search="true"  focus-me="focusInput"  id="selectProductByPartNum_SubProduct"   >
                                    <?php echo $All_PartNumbers ?>
                                </select>
                            </div>

                            {{--<select focus-me="focusInput"  id="partnumber_list" ng-model="partnumbers_id" ng-change="selectProductByPartNum_SubProduct()"  class="partnumbers_id ui search selection dropdown search-select" name="OrderStatus"  >--}}
                                {{--<option ng-repeat="partnum in partnumbers" value="@{{partnum.id}}" >--}}
                                    {{--@{{partnum.partnumber}}--}}
                                {{--</option>--}}
                            {{--</select>--}}

                        </div>
                        <!-- Option Mode 1  -->
                        <div class="field">
                            <div ng-show="modeB1_fiald" class="col-md-12">
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
                                    <select id="selectProductByPartNum_SubProductB"  ng-model="ProductID"  class="ProductID brandsID ui search selection dropdown search-select" name="OrderStatus"  >
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
                @{{ parentProduct_id }} / @{{ invoiceID }}
                <div ng-show="product_details" class="OrderStatus col-md-12" style="min-height:  60px;">
                    <div class="col-md-2 pull-right">@{{ echo_Brand_B }}</div>
                    <div class="col-md-2 pull-right">@{{ echo_Type_B }}</div>
                    <div class="col-md-4 pull-right">@{{ echo_ProductTitle_B }}</div>
                    <div class="col-md-2 pull-right">
                        {{Lang::get('labels.QTY')}}
                        <input  ng-keypressX="add_subProduct_in_Invoice()" ng-model="Subproduct_QTY"  min="1" type="number" style="width: 70px !important;" class="ng-pristine ng-valid ng-not-empty ng-touched">
                    </div>
                    <div class="col-md-2 pull-right">
                        <button id="add_product_to_invoice" class="btn btn-primary" ng-click="add_subProduct_in_Invoice()" style="width:  100%;">
                            <i class="fa fa-plus-square" style="font-size:14px"></i>
                             {{ lang::get('labels.Orders_add_product') }}
                        </button>
                    </div>
                </div>
                <!------ ------>
                    <div  class="row  col-md-12" style="background: #f4f4f4;height: 25px;padding-top: 5px;">
                        <div class="col-md-1 pull-right"> </div>
                        <div class="col-md-2 pull-right">PartNumber</div>
                        <div class="col-md-5 pull-right">product Title</div>
                        <div class="col-md-1 pull-right"> qty </div>
                        <div class="col-md-2 pull-right">EPL Price</div>
                        <div class="col-md-1 pull-right"> </div>

                    </div>

                <div  class="subProductContainer">
                    <i ng-show="waitForLoading" class="waitForLoading fa fa-spinner fa-spin" style="left: 50%;top: 40%;border-radius: 100px;"> </i>
                    <div ng-repeat="SP in subProduct" class="row serialsInDB col-md-12">
                        <div class="col-md-1 pull-right">
                            <i ng-click="changePosition('up',SP.id ,SP.sid_position)" class="fa fa-sort-asc"></i>
                            <i ng-click="changePosition('down',SP.id ,SP.sid_position)"  class="fa fa-sort-desc"></i>
                        </div>
                        <div class="col-md-2 pull-right">
                            @{{ SP.stkr_prodct_partnumber_commercial }}
                        </div>
                        <div class="col-md-5 pull-right">@{{ SP.stkr_prodct_title }}</div>
                        <div class="col-md-1 pull-right">
                            <span id="QtyValueLabel@{{ SP.id }}" class="QtyValueLabel" ng-click="showUpdateInput(SP.id)">
                                @{{ SP.sid_qty }}
                            </span>
                            <span id="QtyValueInput@{{ SP.id }}" class="EditQtyValue hide">
                                <input   id="QtyValue@{{ SP.id }}" type="number"   value="@{{ SP.sid_qty }}" class="form-control  ">
                                <i class="fa fa-check saveCheckSmall" aria-hidden="true" ng-click="updateNewSubProductQty(SP.id,invoiceID,parentProduct_id)"></i>
                            </span>
                        </div>
                        <div class="col-md-2 pull-right">@{{ SP.stkr_prodct_price }}</div>

                        <div class="col-md-1 pull-right">
                            <i class="fa fa-trash gray " aria-hidden="true" ng-click="delete_subProduct_inVoice(SP.invoice_detailsID)"></i>
                         </div>
                    </div>
                </div>

                </div>
            <div class="col-md-12">
                <!------ ------>
                <div class="new_form_control field" ng-show="new_form_control">
                    {{--<button ng-click="addInvoiceDetailsTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</button>--}}
                    <button ng-click="closeSubProductDimmer()" class="btn btn-danger ">{{ Lang::get('labels.back') }}</button>
                </div>

                <div class="edit_form_control field" ng-show="edit_form_control"  style="margin-top:  70px;">
                    {{--<button ng-click="EditInvoiceLIST(0)" class="btn btn-success"><i class="fa fa-floppy-o"></i>  {{ Lang::get('labels.update') }} </button>--}}
                    <button ng-click="closeSubProductDimmer()" class="btn btn-danger ">{{ Lang::get('labels.back') }}</button>
                </div>
                {{-------}}
            </div>
            </div>
        </div>
@endsection
