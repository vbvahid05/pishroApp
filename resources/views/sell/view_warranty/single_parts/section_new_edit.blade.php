<?php
    use App\Mylibrary\Sell\Warranty\Warranty;
    $SerialNumbers =Warranty::GetSerialNumbers();

use App\Mylibrary\Sell\Invoice\Invoice;
$All_PartNumbers =Invoice::All_PartNumbers();
$all_Custommers= Invoice::Get_all_Custommers();
?>

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
          <div class="row" >
            <div ng-show="RequestMode" class="col-md-3">سریال نامبر معیوب را انتخاب نمایید</div>
            <div ng-show="RequestMode" class="col-md-4">
                <div  class="select_CustommerList warranty">
                    <select class="selectpicker" data-live-search="true"  id="SerialNumberList"  style="margin-bottom: 10px">
                        <?php echo $SerialNumbers; ?>
                    </select>

                    <span class="btn btn-default" ng-click="AddnewSerial()">
                    درج سریال قدیمی در سامانه
                    </span>
                </div>
            </div>
           <div class="col-md-5" style="text-align: right;border-right: 1px dashed #e0e0e0;margin-bottom: 10px;">
               <i class="fa fa-cubes" aria-hidden="true"></i>
                  <strong> {{lang::get('labels.stockRequest_ID')}}:</strong>
                   @{{ stockrequestsID }}
               <br/>
               <i class="fa fa-user-circle-o"></i>
                   <strong>{{lang::get('labels.invoice_Custommer')}}:</strong>
                   @{{ custommerName }}
                   @{{ custommerFamily }}
                   @{{ orgName }}
               <br/>

               <span ng-show="RegistrDate">
                    <i class="fa fa-calendar"></i>
                    <strong>{{lang::get('labels.stockRequest_RequestDate')}}:</strong>
                    @{{ RegistrDate |Jdate}}
               </span>

               <span ng-show="DeliveryDate" >
               <strong>{{lang::get('labels.stockRequest_deliveryDate')}}: </strong>
                    @{{ DeliveryDate | Jdate}}
               </span>    &nbsp;&nbsp;

               <br/>

               <span ng-show="Warranty_total_Period">
                   {{lang::get('labels.warranty_duration')}}: <strong>  @{{ Warranty_total_Period }} </strong> ماه
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   {{lang::get('labels.WarrantyExpiredDate')}}:
                   <strong class="total_Expired label"> @{{ Warranty_total_Expired_Date }} </strong>
               </span>
               <span ng-show="!Warranty_total_Period && stockrequestsID">
                   <span class="label label-warning"> در حواله مدت گارانتی مشخص نشده است </span>
               </span>

           </div>
          </div>
          <hr style="margin-top: 0;">
             <div ng-show="RequestMode"  class="row">
              <div class="col-md-9">
                  <table class="table">
                      <tr>
                          <th>{{lang::get('labels.partNumber')}}</th>
                          <th>{{lang::get('labels.Product_brand')}}</th>
                          <th>{{lang::get('labels.Product_type')}}</th>
                          <th>{{lang::get('labels.Product_title')}}</th>
                          <th>{{lang::get('labels.serialNumber_first')}}</th>
                          <th>{{lang::get('labels.serialNumber_last')}}</th>
                      </tr>
                      <tr>
                          <td>@{{ partnumber }}</td>
                          <td>@{{ Brand }}</td>
                          <td>@{{ Type }}</td>
                          <td>@{{ prodctTitle }}</td>
                          <td>@{{ snA }}</td>
                          <td>@{{ snB }}</td>
                      </tr>
                  </table>
              </div>
              <div class="col-md-3">
                  <div class="btn btn-primary btn-block" ng-click="addSerialToList()">
                      {{lang::get('labels.Orders_add_product')}}
                  </div>
              </div>

          </div>
          <hr ng-show="RequestMode">
              <div class="row">
                  <div ng-show="RequestMode" ng-show="defultStockRId" style="text-align: right;padding-right: 20px;" > شماره حواله :  @{{ defultStockRId }}</div>

                <table style="margin-right: 20px;">
                    <tr>
                        <td></td>
                        <td>#</td>
                        <td></td>
                        <td colspan="2" ng-show="RequestMode">{{ lang::get('labels.WarrantyFailedSN') }}</td>
                        <td colspan="2" ng-show="RequestMode">{{ lang::get('labels.WarrantySNS') }}</td>
                        <td><label ng-show="!RequestMode">{{ lang::get('labels.serialNumber_first') }}</label></td>
                        <td><label ng-show="!RequestMode">{{ lang::get('labels.serialNumber_last') }}</label></td>

                        <td><label ng-show="!RequestMode">{{ lang::get('labels.WarrantySN1') }} </label></td>
                        <td><label ng-show="!RequestMode">{{ lang::get('labels.WarrantySN2') }} </label></td>
                        <td> </td>
                        <td></td>
                    </tr>

                    <tr ng-repeat="Sn in SeriallistArray track by $index" style="height: 25px;">
                        <td></td>
                        <td><span class="label label-info ng-binding">@{{ $index+1 }}</span></td>
                        <td><span class="label label-default ng-binding" >@{{ Sn.prodctTitle }} </span>
                            &nbsp;&nbsp;
                            <span class="label label-default ng-binding" > &nbsp;@{{ Sn.partNumber }} &nbsp; </span>
                        </td>
                        <td><span class="label label-danger ng-binding">@{{ Sn.snA }} </span></td>
                        <td style="padding-left: 10px;">
                            <span ng-show="Sn.snB" class="label label-warning ng-binding">@{{ Sn.snB }} </span>
                        </td>
                        <td style="border-right: 3px dashed gray;padding-right: 10px;">
                           <span  ng-show="Sn.alternativeSerialSn"  class="label label-success" >   @{{ Sn.alternativeSerialSn }} </span>
                            <span ng-click="ShowAlternativeSerial_Input(Sn.id)" ng-show="Sn.alternativeSerialSn ==null && !RequestMode && !ShowAlternativeSerialFlage" class="Cpointer btn btn-default">
                                درج سریال
                            </span>
                            <input  ng-show="!RequestMode && ShowAlternativeSerialFlage" id="alternative_serial@{{ Sn.id }}"
                                   ng-keypress="saveOrUpdate_alternative_serial($event,Sn.warrantyID,Sn.id)"
                                   class="form-control alternative_serial" type="text" style="width: 250px !important;"    value="@{{ Sn.alternativeSerialSn }}" >

                            <label id="alternative_serial_label@{{ Sn.id }}" class="hide "></label>


                            <span ng-show="!Sn.alternativeSerialSn && !ViewMode" ng-click="save_Update_Warranty('saveAndSendToStock')" class="edit_link">
                                        {{ lang::get('labels.Warranty_updateAndSendToStock') }}
                            </span>
                            <span ng-show="!Sn.alternativeSerialSn && ViewMode && addRequest" ng-click="save_Update_Warranty('updateAndSendToStock')" class="edit_link">
                                        {{ lang::get('labels.Warranty_updateAndSendToStock') }}
                            </span>



                        </td>
                        <td>
                          <span ng-show="Sn.alternativeSerialSn_b" class="label label-primary">  @{{  Sn.alternativeSerialSn_b }} </span>
                            {{--<label ng-show="!RequestMode "  >--}}
                                {{--<h4 id="SNb@{{ Sn.id }}">  </h4>--}}
                            {{--</label>--}}
                        </td>

                        <td>
                            <label class="errorMessage" id="errorMessage@{{ Sn.id }}" style="width: 150px;" ></label>
                            <i class="serialIcon fa fa-check greenx hide" id="Tikicon@{{ Sn.id }}"></i>
                            <i class="serialIcon fa fa-close redx hide" id="failedIcon@{{ Sn.id }}"></i>
                        </td>

                        <td>

                            @can('warranty_delete', 1)
                            <i ng-click="removeFromList($index,Sn.id)" ng-show="RequestMode && (Sn.alternativeSerialSn==0 ||  Sn.alternativeSerialSn==null)" class="fa fa-trash gray " ></i>
                            <i ng-click="delete_alternative_serial(Sn.warrantie_id,Sn.alternativeSerialId ,Sn.id)" ng-show="ViewMode && stockOut && Sn.alternativeSerialId!=null"  class="fa fa-trash gray" aria-hidden="true" style="font-size:  18px;padding:  4px;"></i>
                            @endcan
                        </td>

                    </tr>
                </table>
              </div>
          <hr>
          <div class="row">
              <form class="ui form">
              <div class="fields">
                  <div class="five wide field">
                      <label>{{lang::get('labels.warranty_delevery_date')}}  </label>
                      <input  ng-show="RequestMode" type="text" class="form-control" ng-model="warranty_delevery_date" id="warranty_delevery_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" required />
                      <strong ng-show="!RequestMode"  >@{{ warranty_delevery_date }} </strong>
                  </div>
                  <div class="five wide field">
                      <label>{{lang::get('labels.warranty_start_date')}}</label>
                      <input   ng-show="RequestMode" type="text" class="form-control" id="warranty_start_date" ng-model="warranty_start_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" />
                      <strong  ng-show="!RequestMode">@{{ warranty_delevery_date }} </strong>
                  </div>

                  <div class="two wide field">
                      <label>{{lang::get('labels.warranty_duration')}} </label>
                      <input type="number"  ng-show="RequestMode" id="WarrantyPeriod" ng-model="WarrantyPeriod" style="width: 145px !important;height: 45px; " readonly>
                      <strong ng-show="!RequestMode"> @{{ WarrantyPeriod }}</strong>
                  </div>

                  <div class="two wide field">
                      <label> &nbsp; </label>
                      <select ng-show="RequestMode" id="WarrantyDuration" ng-model="WarrantyDuration"  readonly>
                          <option value="30">ماه</option>
                      </select>
                      <strong ng-show="!RequestMode "> @{{ WarrantyDuration | DurationType}}</strong>
                  </div>

              </div>
              </form>
          </div>
          <hr>
          <div class="row">
              <div  ng-show="!ViewMode" class="btn btn-success" ng-click="save_Update_Warranty('save')">{{lang::get('labels.save')}} </div>
              <div  ng-show="!ViewMode" class="btn btn-primary" ng-click="save_Update_Warranty('saveAndSendToStock')">{{lang::get('labels.warranty_save_and_send_to_stock')}} </div>

              <div ng-show="ViewMode && addRequest" class="btn btn-success" ng-click="save_Update_Warranty('update')"> {{lang::get('labels.update')}}</div>
              <div ng-show="ViewMode && addRequest" class="btn btn-primary" ng-click="save_Update_Warranty('updateAndSendToStock')"> {{lang::get('labels.warranty_update_and_send_to_stock')}}</div>

              {{--<div ng-show="ViewMode && stockOut" class="btn btn-success" ng-click="save_Update_alternative_serial('update')"> {{lang::get('labels.update')}}</div>--}}
              <div ng-show="ViewMode && stockOut " class="btn btn-info" ng-click="backToWarrantyRequest(SeriallistArray)"> {{lang::get('labels.warranty_commit_to_PDF')}}</div>
              <div class="btn btn-danger" ng-click="close_warranty_dimmer()">{{lang::get('labels.cancel')}} </div>

          </div>

      </div>





      <div ng-show="showAddnewSerial" class="addnewSerial" style="width: 100%;height: 640px;background: #fdfdfd;position: absolute;top:0px;right: 0;border-top: 5px  solid #efeff3;z-index: 100;">
          <div class="col-md-8 col-md-offset-2 pull-right">
          <div class="ui form">
              <div class="field header_lable">
                  <label>
                        مشخصات حواله
                  </label>
              </div>
                  <div class="field" >
                      <label>تاریخ ثبت</label>
                      <select class="selectpicker" data-live-search="true"  id="sr_custommer"  >
                          <?php echo $all_Custommers; ?>
                      </select>
                  </div>
                  <div class="field">
                      <label>تاریخ ثبت</label>
                      <input  ng-show="RequestMode" type="text" class="form-control" ng-model="warranty_register_date" id="warranty_register_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" required />
                  </div>
                  <div class="field">
                      <label>تاریخ گارانتی</label>
                      <input  ng-show="RequestMode" type="text" class="form-control" ng-model="warranty_date" id="warranty_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" required />
                  </div>
                  <div class="field">
                      <label>تاریخ تحویل</label>
                      <input  ng-show="RequestMode" type="text" class="form-control" ng-model="warranty_delivery_date" id="warranty_delivery_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" required />
                  </div>

                  <div class="field">
                      <label>مدت گارانتی</label>
                      <input class="form-control" type="number" ng-model="warranty_duration" id="warranty_period">
                  </div>

              <div class="field header_lable">
                  <label>
                      جستجوی کالا
                  </label>
              </div>
          </div>


              <div ng-showX="resultProduct" class="OrderStatus " style="height:  60px;">
                  <div class="">
                      <div class="col-md-4 InvoicePartNumbers">
                          <select class="selectpicker" data-live-search="true" focus-me="focusInput" id="product_partnumbers_Finder"   name="OrderStatus" >
                              <?php echo $All_PartNumbers ?>
                          </select>
                      </div>
                      <div class="col-md-8">
                          <span >
                              @{{echo_Brand}}  @{{echo_Type}}  @{{echo_typeCat | pTypeCat}}<br/>
                              @{{echo_ProductTitle}}
                          </span>
                      </div>
                  </div>
              </div>
              <hr/>
              <div class="ui form">
                  <div class="two fields">
                      <div class="field">
                          <label>سریال اول کالای معیوب</label>
                          <input class="form-control"   ng-model="warranty_faulty_serialNumber_a" id="warranty_faulty_serialNumber_a">
                      </div>
                      <div class="field">
                          <label>سریال  دوم کالای معیوب</label>
                          <input class="form-control"   ng-model="warranty_faulty_serialNumber_b" id="warranty_faulty_serialNumber_b">
                      </div>
                  </div>
              </div>

              <hr>
              <div class="row">
                  <div class="col-md-6 col-md-offset-2 pull-right">
                      <div class="btn btn-success" ng-click="addFaulty_serialNumber()"> درج سریال</div>
                      <span class="btn btn-danger" ng-click="AddnewSerial()">
                    {{lang::get('labels.close')}}
                    </span>
                  </div>
              </div>

          </div>


     </div>
  </div>
  @endsection
