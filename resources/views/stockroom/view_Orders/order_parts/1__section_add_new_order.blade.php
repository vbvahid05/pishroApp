  @section('section_add_new_order')


<div  id="new_order"   class="ui page dimmer">

  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div class="ui segments">
            <div class="dimmer_form edit ui segment " >

              <h3 class="ui dividing header">@{{ FormTitle }}</h3>
              <!-- Notifications-->
                <div id="publicNotificationMessage" class="publicNotificationMessage"></div>

                <form class="ui form">                  
                  <div class="field">
                      <div class="three fields">
                        <label>{{ Lang::get('labels.Order_code') }}</label>
                        <div class="field">
                          <input type="text" ng-model="Order_code"  placeholder="{{ Lang::get('labels.Order_code') }}" readonly>
                        </div>
                        <label>{{ Lang::get('labels.Orders_ID') }}</label>
                        <div class="field">
                          <input type="text" ng-model="formData.Order_Number"  name="shipping[last-name]" placeholder="{{ Lang::get('labels.Orders_ID') }}">
                        </div>
                      </div>
                  </div>

                  <div class="field">
                      <div class="three fields">
                        <label>{{ Lang::get('labels.Orders_Seller_name') }}</label>
                        <div class="field">
                          <select  ng-model="seller_id" class="ui search selection dropdown search-selectx" name="sellerName" required >
                              <option ng-repeat="seller in allsellers"  value="@{{seller.id}}" >
                                @{{seller.stkr_ordrs_slr_name}}
                              </option>
                           </select>
                        </div>
                        <label>{{ Lang::get('labels.Orders_Status') }}</label>
                        <div class="field">
                          <select   ng-model="formData.ord_status" class="ui search selection dropdown search-selectx" name="ordStatus" required >
                             <option ng-repeat="status in allstatus"  value="@{{status.id}}" >
                                @{{status.stkr_ordrs_stus_title}}
                             </option>
                          </select>
                        </div>
                      </div>
                  </div>

                  <div class="field">
                    <div class="three fields">
                      <label for="orderMessage">{{ Lang::get('labels.Orders_comment') }} </label>
                      <textarea ng-model="orderMessage" style="text-align:  right;" ></textarea>
                    </div>
                  </div>

                  <!-- -->
              <div class="field">
                  <div class="three fields">
                    <div class="field" ng-show="new_form_control"> </div>
                    <div class="field" ng-show="new_form_control">
                      <button ng-click="addNewOrderTo_DB()" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
                      <button ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</button>
                    </div>
                    <div class="field" ng-show="new_form_control"> </div>
                  </div>
              </div>

              <div class="field">
                  <div class="three fields">
                    <div class="field" ng-show="edit_form_control"> </div>
                    <div class="field" ng-show="edit_form_control">
                      <div ng-click="UpdateFormData()" class="btn btn-success">{{ Lang::get('labels.edit') }}</div>
                      <div ng-click="closeDimmer()" class="btn btn-danger ">{{ Lang::get('labels.cancel') }}</div>
                    </div>
                    <div class="field" ng-show="edit_form_control"> </div>
                  </div>
              </div>



              </form>















              </div>
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
