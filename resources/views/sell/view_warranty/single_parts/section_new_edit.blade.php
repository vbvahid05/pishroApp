<?php
    use App\Mylibrary\Sell\Warranty\Warranty;
    $SerialNumbers =Warranty::GetSerialNumbers();
?>

@section('section_new_edit')
  <div ng-show="section_new_edit_in_Dimmer">
    <div   class="ui segment" style="
        position: fixed;
    top: 10%;
    bottom: 10%;
    left: 10%;
    right: 10%;
    background-color: #fff;
    z-index: 1001;
    border-top: 4px solid #3fadff;">

      <h3 class="dimmer-title">@{{ FormTitle }}</h3>
      <hr/>
      <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage" >
      <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
      </div>

      <div class="main">
          <div class="row">
            <div class="col-md-3">سریال نامبر معیوب را انتخاب نمایید</div>
            <div class="col-md-4">
                <div class="select_CustommerList">
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
                   @{{ RegistrDate }}
                   &nbsp;&nbsp;
                   <strong>{{lang::get('labels.stockRequest_RequestDate')}}:</strong>
                   @{{ DeliveryDate }}
           </div>
          </div>
          <hr style="margin-top: 0;">
             <div class="row">
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
          <hr>
              <div class="row">
                  <table class="">
                   <tr ng-repeat="Sn in SeriallistArray track by $index">
                       <td>
                           &nbsp;&nbsp;&nbsp;&nbsp;
                       </td>
                       <td>
                           <span class="label label-info ng-binding">@{{ $index+1 }} </span>
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
                           <span class="label label-success ng-binding">@{{ Sn.snB }} </span>
                       </td>
                       <td>
                           <span class=""> <i class="fa fa-trash gray " ng-click="removeFromList($index)"></i> </span>
                       </td>

                   </tr>
                  </table>
              </div>
          <hr>
          <div class="row">
              <form class="ui form">
              <div class="fields">
                  <div class="five wide field">`
                      <label>{{lang::get('labels.warranty_delevery_date')}}  </label>
                      <input type="text" class="form-control" id="warranty_delevery_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" />
                  </div>
                  <div class="five wide field">
                      <label>{{lang::get('labels.warranty_start_date')}}</label>
                      <input type="text" class="form-control" id="warranty_start_date" placeholder="تاریخ" data-mddatetimepicker="true" data-placement="right" data-englishnumber="true" />
                  </div>
                  <div class="two wide field">
                      <label>{{lang::get('labels.warranty_duration')}} </label>
                      <select>
                          <option>1</option>
                          <option>1</option>
                      </select>
                  </div>

                  <div class="two wide field">
                      <label> &nbsp; </label>
                      <select>
                          <option>ماه</option>
                          <option>سال</option>
                      </select>
                  </div>

              </div>
              </form>
          </div>
          <hr>
          <div class="row">
              <div class="btn btn-success"> save</div>
              <div class="btn btn-danger"> cancel</div>

          </div>

      </div>
    </div>
  </div>
  @endsection
