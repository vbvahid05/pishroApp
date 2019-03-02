<?php
    use App\Mylibrary\Sell\Warranty\Warranty;
    $SerialNumbers =Warranty::GetSerialNumbers();
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
          <div class="row">
            <div ng-show="RequestMode" class="col-md-3">سریال نامبر معیوب را انتخاب نمایید</div>
            <div ng-show="RequestMode" class="col-md-4">
                <div  class="select_CustommerList">
                    <select class="selectpicker" data-live-search="true"  id="SerialNumberList"   >
                        <?php echo $SerialNumbers; ?>
                    </select>
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
               <i class="fa fa-calendar"></i>
                   <strong>{{lang::get('labels.stockRequest_deliveryDate')}}: </strong>
                   @{{ RegistrDate |Jdate}}
                   &nbsp;&nbsp;
                   <strong>{{lang::get('labels.stockRequest_RequestDate')}}:</strong>
                   @{{ DeliveryDate | Jdate}}
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

                <table class="">
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        <td><label ng-show="!RequestMode">{{ lang::get('labels.serialNumber_first') }}</label></td><td></td>
                        <td><label ng-show="!RequestMode">{{ lang::get('labels.serialNumber_last') }} </label></td>
                        <td> </td>
                    </tr>

                    <tr ng-repeat="Sn in SeriallistArray track by $index" style="height: 25px;">
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            <span class="label label-info ng-binding">@{{ $index+1 }}   </span>
                        </td>
                        <td>
                            <span class="label label-default ng-binding" >@{{ Sn.prodctTitle }} </span>
                            &nbsp;&nbsp;
                            <span class="label label-default ng-binding" > &nbsp;@{{ Sn.partNumber }} &nbsp; </span>
                        </td>
                        <td>
                            <span class="label label-primary ng-binding">@{{ Sn.snA }} </span>
                        </td>
                        <td>
                            <span ng-show="Sn.snB" class="label label-success ng-binding">@{{ Sn.snB }} </span>
                        </td>
                        <td>
                            <span  class="">
                            <i ng-show="RequestMode" class="fa fa-trash gray " ng-click="removeFromList($index,Sn.id)"></i>
                            </span>
                        </td>
                        <td> &nbsp;</td>
                        <td >
                            <input ng-show="!RequestMode" id="alternative_serial@{{ Sn.id }}"  ng-blur="Add_alternative_serial(Sn.warrantyID,Sn.id)" class="form-control" type="text" style="width: 250px !important;" >
                        </td>

                        <td> &nbsp;</td>
                        <td> <label ng-show="!RequestMode" > <h4 id="SNb@{{ Sn.id }}"></h4></label></td>
                        <td style="padding-right: 20px;">
                            <i class="serialIcon fa fa-check greenx hide" id="Tikicon@{{ Sn.id }}"></i>
                            <i class="serialIcon fa fa-close redx hide" id="failedIcon@{{ Sn.id }}"></i>
                        </td>
                        <td> <label id="errorMessage@{{ Sn.id }}" style="width: 150px;" ></label></td>
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
                  <select ng-show="RequestMode" id="WarrantyPeriod" ng-model="WarrantyPeriod" >
                      <option  ng-repeat="n in [] | range:12"  value="@{{ $index+1 }}">
                          @{{$index+1}}
                      </option>
                  </select>
                      <strong ng-show="!RequestMode"> @{{ WarrantyPeriod }}</strong>
                  </div>

                  <div class="two wide field">
                      <label> &nbsp; </label>
                      <select ng-show="RequestMode" id="WarrantyDuration" ng-model="WarrantyDuration" >
                          <option value="30">ماه</option>
                          <option value="365">سال</option>
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

              <div ng-show="ViewMode && RequestMode" class="btn btn-success" ng-click="save_Update_Warranty('update')"> {{lang::get('labels.update')}}</div>
              <div ng-show="ViewMode" class="btn btn-primary" ng-click="save_Update_Warranty('updateAndSendToStock')"> {{lang::get('labels.warranty_update_and_send_to_stock')}}</div>
              <div class="btn btn-danger" ng-click="close_warranty_dimmer()">{{lang::get('labels.cancel')}} </div>

          </div>

      </div>
    </div>
  </div>
  @endsection
