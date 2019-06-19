<?php use App\Mylibrary\Sell\Invoice\Invoice;
$All_PartNumbers =Invoice::All_PartNumbers();
$all_Custommers= Invoice::Get_all_Custommers();
?>

@section('section_new_edit')
   <div ng-show="section_pdf_Setting_dimmer">
        <div class="ui segment" style="
                        border-top: 5px solid #3fadff;
                        position: fixed; top: 0em !important;
                        width:900px !important;
                        min-height: 400px !important;
                        top: 40% !important;
                        left: 50% !important;
                        margin-left: -450px; /* Negative half of width. */
                        margin-top: -200px; /* Negative half of height. */
">
            <div ng-click="closeEditDimmer()" class="btn btn-info btn-s" style="float:  left;">
                {{ Lang::get('labels.back') }}
                <i class="fa fa-arrow-left" aria-hidden="true" ></i>
            </div>
            <h3 class="dimmer-title">@{{ FormTitle_Setting }}</h3>
            <hr/>
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" style="height: 50px;" >
                <i ng-show="showWaiting" class="waiting  fa fa-refresh fa-spin"></i>
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <div class="col-md-12">
                    <div  ng-repeat="AD in ActionsData" class="col-md-3 actionCheckBox pull-right" >
                        <label class="containerx">
                            <input type="checkbox"   ng-click="setAction(AD.id)"  lass="checkboxz" value="@{{AD.id}}"    ng-checked="AD.Selected == 1" >
                            <span class="checkmark"></span>
                            @{{AD.actionTitle}}
                        </label>
                    </div>
                    <div class="col-md-8 col-md-offset-2">

                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                اندازه فونت جدول محصولات
                            </div>
                            <div class="col-md-3 pull-right">
                                <input placeholder="12" class="inputStyle ng-pristine ng-untouched ng-valid ng-empty" ng-model="stng_mainTableFontSize" type="number">
                            </div>
                            <div class="col-md-2"> پیکسل </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                اندازه فونت سریال نامبر
                            </div>
                            <div class="col-md-3 pull-right">
                                <input placeholder="12" class="inputStyle ng-pristine ng-untouched ng-valid ng-empty" ng-model="stng_SerialNumberFontSize" type="number">
                            </div>
                            <div class="col-md-2"> پیکسل </div>
                        </div>

                        <hr>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4 pull-right"> </div>
                            <div class="col-md-2 pull-right">
                                <div class="btn btn-success" ng-click="stackReqstPDFSettingSave()" style="width: 100%;">ذخیره</div>
                            </div>
                            <div class="col-md-2 pull-right">
                                <div class="btn btn-danger" ng-click="closepdfSetting()" style="width: 100%;">بستن</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div ng-show="section_new_edit_in_Dimmer">
    <div   class="ui segment section_new_edit" style="

                                                border-top: 4px solid #3fadff;
                                                position: fixed; top: 0em !important;
                                                width:1200px !important;
                                                min-height: 400px !important;
                                                top: 30% !important;
                                                left: 50% !important;
                                                margin-left: -600px; /* Negative half of width. */
                                                margin-top: -200px; /* Negative half of height. */
                                                ">
      <h3 class="dimmer-title">@{{ FormTitle_viewMode }} </h3>
      <hr/>
      <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage" >
          <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
      </div>

      <div ng-show="new_edit_in_Dimmer" class="stockrequestEdit">
          <div class="toolBar">
              <div class="btn btn-primary" ng-show="sr_type==1" ng-click="showConvertStockRequestPage()">
                  <i class="fa fa-retweet"></i>
                  تبدیل به حواله قطعی
              </div>
              <button ng-click="confirmStockRequest(echo_StockRequestID)" ng-show="confirmStockRequestBTN" class="btn btn-danger btn-lg" >
                  تایید نهایی
              </button>

              <button ng-show="sr_type == 2" class="btn btn-warning" ng-click="borrow_BacktoStock(echo_StockRequestID)">
                  بازگشت به انبار
              </button>
          </div>
          <div class="main newStockRequestForm" >
              <form class="ui form"  name="StockRequestForm">
                  <div ng-show="newStockRequestForm" class="five fields resultProduct " style="height:  100px;">
                      <div class="field">
                          <Label class="xLabel">{{ Lang::get('labels.stockRequest_type') }}  </Label>
                          <select ng-model="sr_type" name="sr_type" class="ui fluid dropdown" style="padding-right:  30px;" required>
                              <option value="0"><i class="fa fa-cubes"></i>{{ Lang::get('labels.stockRequest_type_certain') }}</option>
                              <option value="1">{{ Lang::get('labels.stockRequest_type_Accrual') }}</option>
                              <option value="2">{{ Lang::get('labels.Amani') }}</option>
                          </select>


                      </div>
                      <div class="field">
                          <div class="StockRequest_CustommerList">
                              <Label class="xLabel">{{ Lang::get('labels.custommer') }} </Label>
                              <select class="selectpicker" data-live-search="true"  id="sr_custommer"  >
                                  <?php echo $all_Custommers; ?>
                              </select>
                          </div>
                      </div>
                      <div class="field">
                          <label class="xLabel" style="width:  200px;"> {{ Lang::get('labels.stockRequest_preFaktorNum') }} </Label>
                          <input ng-model="sr_preFaktorNum" type="text"   maxlength="16" placeholder="Card #" style="width: 100% !important;">
                      </div>
                      <div class="field">
                          <Label>   {{ Lang::get('labels.stockRequest_deliveryDate') }}</Label>
                          <a ng-click="set_today_date()" class="btn btn-link" style="font-size:10px;">{{lang::get('labels.today')}}</a>
                          <div class="three fields">
                              <div class="field">
                                  <select  ng-model="zdays"  id="zdays" style="width: 70px;padding-right:  0;">
                                      <option ng-repeat="n in daysNum" value=@{{n.id}}>
                                          @{{n.id}}
                                      </option>
                                  </select>
                              </div>
                              <div class="field">
                                  <select ng-model="zMonths" id="zMonths" style="width: 70px;padding-right:  0;">
                                      <option ng-repeat="n in Months" value=@{{n.id}}>
                                          @{{n.id}}
                                      </option>
                                  </select>
                              </div>
                              <div class="field">
                                  <select  ng-model="zyears" id="zyears"  style="width: 70px;padding-right:  0;">
                                      <option ng-repeat="n in years" value=@{{n.id}}>
                                          @{{n.id}}
                                      </option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="field">
                          <div class="two fields">
                              <div class="field">
                                  <Label class="xLabel">{{ Lang::get('labels.WarrantyPriod') }}  </Label>
                                  <input ng-model="WarrantyPriod" type="number"   maxlength="3"   style="width: 100% !important;">
                              </div>
                              <div class="field">
                                  <br/>
                                  <button class="btn btn-success" ng-click="insertStockRequestToDB()" style="width:  100%;margin-top: 10px;">
                                      {{ Lang::get('labels.save') }}  </button>
                              </div>
                          </div>
                      </div>
                  </div> <!-- four fields -->
                  <!-- View Stock Request Form -->
                  <div ng-show ="ViewStockRequestForm" class="five fields resultProduct  greenblue " style="height: auto;padding-top: 0;" >

                      <table style="width: 100%;">
                          <tr>
                              <th><Label>{{ Lang::get('labels.stockRequest_ID') }}  </Label></th>
                              <th><Label>{{ Lang::get('labels.stockRequest_type') }}  </Label></th>
                              <th><Label>{{ Lang::get('labels.custommer') }} </Label></th>
                              <th><label>{{ Lang::get('labels.stockRequest_preFaktorNum') }} </Label></th>
                              <th><label>{{ Lang::get('labels.stockRequest_RequestDate') }}</label></th>
                              <th><label>{{ Lang::get('labels.stockRequest_deliveryDate') }}</label></th>
                              <th><label>{{ Lang::get('labels.WarrantyPriod') }}</label></th>
                              <th><label>{{ Lang::get('labels.WarrantyExpired') }} </label></th>
                          </tr>
                          <tr>
                              <td style="padding-right: 15px;font-weight: bold;">@{{echo_StockRequestID}}</td>
                              <td>@{{sr_type| stockRequestTYPE}}</td>
                              <td>
                                  <div ng-if="!showCustommerList" style="text-align:  right;font-size: 12px"  class="edit_link " ng-click="edit_StockRequest_field('custmrList')" title="{{lang::get('labels.edit')}}">
                                      @{{sr_custommer}}   ( @{{sr_Org_Name}} )
                                  </div>
                                  <div ng-show="showCustommerList" >
                                      <div class="CustommerList" >
                                          <select class="selectpicker" data-live-search="true"  id="CustommerID"  >
                                              <?php echo $all_Custommers; ?>
                                          </select>

                                          <i ng-click="update_StockRequest_field('custmrList')" class="fa fa-check saveCheckSmall" style=""> </i>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <span   ng-if="!showpreFaktorNum" class="edit_link " ng-click="edit_StockRequest_field('preFaktorNum')"  title="{{lang::get('labels.edit')}}" > @{{sr_preFaktorNum}}</span>
                                  <div ng-if="showpreFaktorNum">
                                      <input  id="preFaktorNum"    type="text" value="@{{sr_preFaktorNum}}" style="width: 105px !important;padding: 10px 2px 10px 0px;height: 10px;margin-top: 2px; ">
                                      <i ng-click="update_StockRequest_field('preFaktorNum')" class="fa fa-check saveCheckSmall" style=""></i>
                                  </div>
                              </td>

                              <td>
                                  <span   ng-if="!showRegistrdays" class="edit_link" ng-click="edit_StockRequest_field('Registrdays')" > @{{jalaiRegistr}}</span>
                                  <table ng-if="showRegistrdays" class="Dateinput">
                                      <tr>
                                          <td><select  ng-model="Registrdays"  id="Registrdays" style="width: 70px;padding-right:  0;">
                                                  <option value=@{{sr_Registr_day}}>@{{sr_Registr_day}}</option>
                                                  <option ng-repeat="n in daysNum" value=@{{n.id}}> @{{n.id}} </option>
                                              </select></td>
                                          <td> <select ng-model="RegistrMonths" id="RegistrMonths" style="width: 70px;padding-right:  0;">
                                                  <option value=@{{sr_Registr_month}}>@{{sr_Registr_month}}</option>
                                                  <option ng-repeat="n in Months" value=@{{n.id}}>@{{n.id}}</option>
                                              </select></td>
                                          <td>
                                              <select  ng-model="Registryears" id="Registryears"  style="width: 70px;padding-right:  0;">
                                                  <option value=@{{sr_Registr_year}}>@{{sr_Registr_year}}</option>
                                                  <option ng-repeat="n in years" value=@{{n.id}}>@{{n.id}}</option>
                                              </select>
                                          </td>
                                          <td><i class="fa fa-check saveCheckSmall" ng-click="update_StockRequest_field('RegistrDate')"></i></td>
                                      </tr>
                                  </table>
                              </td>

                              <td>
                                  <span  ng-if="!showDliverDate" class="edit_link"  ng-click="edit_StockRequest_field('DliverDate')" > @{{jalaiDliver}} </span>
                                  <table ng-if="showDliverDate" class="Dateinput" >
                                      <tr>
                                          <td>
                                              <select  ng-model="Dliverdays"  id="Dliverdays" style="width: 70px;padding-right:  0;">
                                                  <option ng-repeat="n in daysNum" value=@{{n.id}}> @{{n.id}} </option>
                                              </select></td>
                                          <td> <select ng-model="DliverMonths" id="DliverMonths" style="width: 70px;padding-right:  0;">
                                                  <option ng-repeat="n in Months" value=@{{n.id}}>@{{n.id}}</option>
                                              </select></td>
                                          <td>
                                              <select  ng-model="Dliveryears" id="Dliveryears"  style="width: 70px;padding-right:  0;">
                                                  <option ng-repeat="n in years" value=@{{n.id}}>@{{n.id}}</option>
                                              </select>
                                          </td>
                                          <td><i class="fa fa-check saveCheckSmall" ng-click="update_StockRequest_field('DliverDate')"></i></td>
                                      </tr>
                                  </table>
                              </td>
                              <td>
                            <span ng-show="!WarrantyPriod && !ShowWarrantyDiuration" ng-click="editWarrantyDiuration(WarrantyPriod)" class="edit_link ">
                                <i class="fa fa-plus-circle" style="font-size:25px;color:#0087ff"></i>
                                {{lang::get('labels.add-simple')}}
                            </span>
                                  <span ng-show="!ShowWarrantyDiuration" ng-click="editWarrantyDiuration(WarrantyPriod)" class="edit_link "> @{{ WarrantyPriod }} </span>
                                  <span ng-show="ShowWarrantyDiuration">
                                <input ng-model="WarrantyPriod_val" value="@{{ WarrantyPriod }}"  style="width: 105px !important;padding-right: 0;padding-left: 0;padding-top: 1px;padding-bottom: 1px;margin-top: 2px;">
                                 <i ng-click="UpdateWarrantyDiuration(echo_StockRequestID)" class="fa fa-check saveCheckSmall" ></i>
                            </span>
                              </td>
                              <td> <span ng-show="WarrantyPriod">  @{{ warranyDate }}</span></td>
                          </tr>
                      </table>
                  </div> <!-- foum fields -->
                  <!-- Select A  Product  -->
                  {{--@@--}}
                  <div ng-show="selectProductBar" class="selectProduct two fields" >
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

                              {{--<select focus-me="focusInput" id="product_partnumbers" ng-model="product_partnumbers" ng-change="selectProduct(0)"  class="partnumbers_id ui search selection dropdown search-select" name="OrderStatus"  >--}}
                              {{--<option ng-repeat="LOPN in ListOfPartNumbers" value="@{{LOPN.productID}}" >--}}
                              {{--@{{LOPN.Partnumber}}--}}
                              {{--</option>--}}
                              {{--</select>--}}
                              <div class="All_PartNumbersInSubProduct">
                                  <label>{{ Lang::get('labels.partNumber') }}</label>
                                  {{--ng-model="product_partnumbers" ng-change="selectProduct(0)"--}}
                                  <select class="selectpicker" data-live-search="true" focus-me="focusInput" id="product_partnumbers_SR"   name="OrderStatus" >
                                      <?php echo $All_PartNumbers ?>
                                  </select>
                              </div>
                          </div>
                          <!-- Option Mode 1  -->
                          <div class="field">
                              <div class="three fields mode_div" ng-show="mode1_fiald" > <!--Show mode 1-->
                                  <div class="field">
                                      <label>{{ Lang::get('labels.Product_brand') }}</label>
                                      <select  ng-model="brandsID" ng-change="getRelatedType()"  class="brandsID ui search selection dropdown search-select" name="OrderStatus"  >
                                          <option ng-repeat="brand in brands" value="@{{brand.stkr_prodct_brand_title}}"  >
                                              @{{brand.stkr_prodct_brand_title}}
                                          </option>
                                      </select>
                                  </div>
                                  <div class="field">
                                      <label>{{ Lang::get('labels.Product_type') }}</label>
                                      <select id="TypeID"  ng-model="TypeID" ng-change="getRelatedProducts_ByType(2)"  class="TypeID ui search selection  dropdown search-select" name="OrderStatus"  >
                                          <option ng-repeat="type in product_Type" value="@{{type.id}}"  >
                                              @{{type.name }}
                                          </option>
                                      </select>
                                  </div>
                                  <div class="field">
                                      <label>{{ Lang::get('labels.Product_title') }}</label >
                                      <select id="product_prtNum" ng-model="product_prtNum"  ng-change="selectProduct(1)"   class="product_prtNum ui search selection dropdown search-select" name="OrderStatus"  >
                                          <option ng-repeat="product in products" value="@{{product.productID}}"  >
                                              @{{product.stkr_prodct_title}}
                                          </option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- -->

                  </div>
              {{--@@  --}}
              <!-- -->
                  <div ng-show="resultProduct" class="OrderStatus  two fields" style="height:  60px;">
                      <div class="field" style="width:  45%;">
                          <span > @{{echo_ProductTitle}} </span>
                          <label>  @{{echo_Brand}}  @{{echo_Type}}  @{{echo_typeCat | pTypeCat}}</label>
                      </div>

                      <div class="four fields">
                          <div class="two wide field"><label > {{ Lang::get('labels.QTY') }} :</label></div>
                          <div class="field " >
                              <input ng-model="product_QTY" id="product_QTY"   max="@{{maxQTY | checkMax : echo_typeCat  }}" min="1" type="number" style="width: 70px !important;">
                              <div style="width: 40px;float:  left;padding-top:  6px;font-weight:  bold;margin-right:  -25px;">
                                  {{ Lang::get('labels.of') }}  @{{totalQTY}}
                              </div>
                          </div>

                          <div class="field">
                              <button class="btn btn-info" ng-click="add_product_to_StockRequest(echo_StockRequestID,sr_type)">
                                  <i class="fa fa-plus-square" style="font-size:14px"></i>
                                  {{ Lang::get('labels.Orders_add_product') }}
                              </button>
                          </div>
                      </div>
                  </div>
                  <!-- -->
              </form>
          </div>
          <!-- -->
          <div class="tabelContainer" ng-show="tabelContainer">
              <div class="btn refreshBtn" ng-click="ReloadData(echo_StockRequestID)">
                  <i class="fa fa-refresh"></i>
                  {{lang::get('labels.refresh')}}
              </div>
              <div class="divTableHeader col-md-12">
                  <div class="col-md-1 pull-right"  > #</div>
                  <div class="col-md-2 pull-right"  > #</div>
                  <div class="col-md-2 pull-right"> {{ Lang::get('labels.Product_PartNumber_comersial') }} </div>
                  <div class="col-md-2 pull-right"> {{ Lang::get('labels.Product_brand') }} - {{ Lang::get('labels.Product_type') }}</div>
                  <div class="col-md-3 pull-right"> {{ Lang::get('labels.Product_title') }}   </div>
                  <div class="col-md-1 pull-right"> {{ Lang::get('labels.QTY') }} </div>
                  <div class="col-md-1  pull-right">W </div>
              </div>
              <!-- -->
              <div ng-show="Loading_waitForDB" class="Loading_waitForDB Loading_waitForDB_Small" style="margin-right: -15px;height: 50%!important;"></div>
              <!--- -->


              {{--<div class="col-md-12">--}}
              {{--<ul psi-sortable="" ng-model="stockRequestProductsArray" >--}}
              {{--<li ng-repeat="SRPA in stockRequestProductsArray track by $index" class="row">--}}
              {{--<div class="col-md-1 pull-right"> @{{$index+1}}  </div>--}}
              {{--<div class="col-md-2 pull-right"> @{{ SRPA.SubRow }}   @{{SRPA.product_partnumbers}}   </div>--}}
              {{--</li>--}}
              {{--</ul>--}}
              {{--</div>--}}


              <ul  psi-sortable=""  ng-model="stockRequestProductsArray"  class="col-md-12 ng-scope" style="list-style: none">
                  <li ng-repeat="SRPA in stockRequestProductsArray track by $index"   class="divTableRowB row moveable " id="DivRow@{{$index}}" >
                      <div class="col-md-1 pull-right"  > @{{$index+1}}  </div>
                      <div class="col-md-2 pull-right"  >
               <span  ng-click="showSubchassisParts(SRPA.productID,SRPA.StockRequestRowID,echo_StockRequestID ,SRPA.product_partnumbers ,SRPA.ProductTitle ,$index,sr_type)">
                   <i ng-show="SRPA.typeCat == 3"   style=" cursor: pointer; font-size:30px;padding-top: 15px;" class="fa fa-puzzle-piece" aria-hidden="true"></i>
               </span>
                      </div>
                      <div class="col-md-2 pull-right"> @{{ SRPA.SubRow }}   @{{SRPA.product_partnumbers}}  </div>
                      <div class="col-md-2 pull-right"> @{{SRPA.typeCat | pTypeCat}} -      @{{SRPA.ProductBrand}}  @{{SRPA.ProductType}}  </div>
                      <div class="col-md-3 pull-right"> @{{SRPA.ProductTitle}}  </div>
                      <div class="col-md-1 pull-right pointerGreen " ng-click="changeQTY(SRPA.productID ,SRPA.product_QTY,echo_StockRequestID,sr_type ,$index)" style="font-size: 15px !important;"> @{{SRPA.product_QTY}}  </div>
                      <div class="col-md-1  pull-right"  ng-click="Delete_product_of_Request($index,sr_type,echo_StockRequestID,SRPA.productID, SRPA.StockRequestRowID,sr_type)"> <i class="fa fa-trash gray " aria-hidden="true"></i> </div>
                      {{--<!-- -->--}}
                      {{--<div class="row " style="height: 10px ;background: yellow"></div>--}}
                      <div class="col-md-12"  id="NgRow@{{SRPA.productID}}" style="margin-top: 10px;border-top: 2px solid #c0bdbd;">
                          <div ng-repeat="Sub_Chassis_part in SRPA.Sub_Chassis_part"  class="">
                              <div id="sub_row_list@{{Sub_Chassis_part[0].id}}" class="Row col-md-12 Sub_Chassis_part" >
                                  <div class="col-md-1 pull-right" >@{{Sub_Chassis_part[0].id}} </div>
                                  <div class="col-md-2 pull-right">@{{Sub_Chassis_part[0].stkr_prodct_partnumber_commercial}}</div>
                                  <div class="col-md-4 pull-right" >@{{Sub_Chassis_part[0].stkr_prodct_title}}</div>
                                  <div class="col-md-3 pull-right" >
                                      <input ng-model="product_QTY" id="product_QTY" max="5" min="1" type="number" style="width: 70px !important;" class="ng-pristine ng-valid-min ng-not-empty ng-invalid ng-invalid-max ng-touched">
                                      /
                                      3
                                  </div>
                                  <div class="col-md-2 pull-right" >
                                      <span class="btn btn-success btn-xs" ng-click="add_subchassis_to_list(Sub_Chassis_part[0].id,SRPA.Sub_Chassis_part, Sub_Chassis_part[0].id,Sub_Chassis_part[0].stkr_prodct_partnumber_commercial,Sub_Chassis_part[0].stkr_prodct_title ) " >+ add</span>
                                      <span class="btn btn-danger btn-xs" ng-click="hide_subchassis(Sub_Chassis_part[0].id)" >close</span>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </li>
              </ul>

          </div>
          <!-- -->
          <div class="col-md-12">
              <div class="col-md-4"> </div>
              <div class="col-md-4" ng-show="addNew_form_control">
                  <br/>
                  <button ng-click="addNewTo_DB(0)" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
                  <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
              </div>
              <div class="col-md-4" ng-showX="edit_form_control">
                  <br/>
                  {{--<button ng-click="edit_DB(0)" class="btn btn-success">{{ Lang::get('labels.update') }}</button>--}}
                  <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
              </div>
              <div class="col-md-4"></div>
          </div>
      </div>

      <div ng-show="stockrequestArchiveDate" class="stockrequestArchiveData">
          <table class="table table-hover">
              <thead>
              <tr>
                  <th>partnumber</th>
                  <th>prodct_title</th>
                  <th>srial_numbers_a</th>
                  <th ng-show="d.srial_numbers_b"> d.srial_numbers_b </th>
              </tr>
              </thead>
              <tbody>
              <tr ng-repeat="d in stockrequestArchiveDate">
                  <td> @{{ d.stkr_prodct_partnumber_commercial }}</td>
                  <td> @{{ d.stkr_prodct_title }}</td>
                  <td>@{{ d.srial_numbers_a }}</td>
                  <td ng-show="d.srial_numbers_b">@{{ d.srial_numbers_b }}</td>
              </tr>

              </tbody>
          </table>
      </div>

    </div>
  </div>
@endsection
