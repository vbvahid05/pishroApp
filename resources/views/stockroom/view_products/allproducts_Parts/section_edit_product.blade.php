@section('section_Edit_product')

<!--   editProduct -->
  <div  id="editProduct"   class="ui page dimmer">
    <div class="content">
      <div class="center">
        <div class="ui text container">
            <div class="ui segments" style="position: absolute;top: 10%;left: 30%;" >
              <div class="ui segment" style="height:auto  ;color:#000;">
                <h2 ng-model="message" > {{ Lang::get('labels.edit') }}</h2>
                <input type="hidden" ng-model="thisProductID"  >

                  <table class="form-table">
                    <tbody>
                      <tr>
                        <th><label for="inpt_Product_brand">{{ Lang::get('labels.Product_brand') }} </label></th>
                        <td>
                            <div class="ui container"    data-live-search="true" data-selected-text-format="values" style="margin-right: 50px !important;width:  350px;margin-bottom:  20;padding-right: 20px;">
                                <select ng-model="SelectBrand" ng-change="setRelatedPtype()" class="ui search selection dropdown ng-pristine ng-valid ng-not-empty ng-touched" >
                                  <option ng-repeat="brand in AllBrands"   value="@{{brand.id}}">
                                     @{{brand.stkr_prodct_brand_title}}
                                  </option>
                                </select>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th><label for="inpt_Product_type">{{ Lang::get('labels.Product_type') }} </label></th>
                        <td>
                          <div class="ui container"    data-live-search="true" data-selected-text-format="values" style="margin-right: 50px !important;width:  350px;margin-bottom:  20;padding-right: 20px;">
                          <select ng-model="SelectType" class="ui search selection dropdown ng-pristine ng-valid ng-not-empty ng-touched">
                            <option   ng-repeat="Type in AllTypes" value="@{{Type.id}}" > @{{Type.stkr_prodct_type_title}} </option>
                          </select>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <th><label for="inpt_Product_type">{{ Lang::get('labels.Product_type_cat') }} </label></th>
                        <td>
                            <div class="grouped fields">
                              <div class="two field">

                                <div class="field">
                                  <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_part') }} </label>
                                  <input class="Product_type_radio ui slider checkbox" type="radio" name="status" value="1" ng-model="Product_type_cat">
                                </div>

                                <div class="field">
                                  <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_partOfChassiss') }} </label>
                                  <input class="Product_type_radio  ui slider checkbox" type="radio" name="status" value="2" ng-model="Product_type_cat">
                                </div>

                                <div class="field">
                                  <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_chassis') }} </label>
                                  <input class="Product_type_radio  ui slider checkbox" type="radio" name="status" value="3" ng-model="Product_type_cat">
                                </div>


                              </div>
                            </div>
                        </td>
                      </tr>

                      <tr>
                        <td></td>
                        <td>
                          <hr>
                          <label class="containerx">
                            {{ Lang::get('labels.Product_with_two_serial') }}
                            <input ng-model="inpt_rodu" id="inpt_rodu" class="checkboxz" type="checkbox"  value="1" style="width: 20px !important;">
                            <span class="checkmark"></span>
                          </label>
                        </td>
                      <tr/>

                      <tr>
                        <th><label for="inpt_roduct_PartNumber_comersial">{{ Lang::get('labels.Product_PartNumber_comersial') }} </label></th>
                        <td><input   type="text" ng-model="inpt_roduct_PartNumber_comersial" name="inpt_roduct_PartNumber_comersial" id="inpt_roduct_PartNumber_comersial"    class="form-control" style="direction:  ltr;text-align:  right;"></td>
                      </tr>
                      <tr>
                        <th><label for="inpt_Product_title">{{ Lang::get('labels.Product_title') }} </label></th>
                        <td><input type="text" ng-model="inpt_Product_title" name="inpt_Product_title" id="inpt_Product_title" value=" "  class="ltrdir form-control"></td>
                      </tr>


                      <tr>
                        <th><label for="inpt_tadbir_stock_id">{{ Lang::get('labels.tadbir_stock_id') }} </label></th>
                        <td>
                          <input   ng-model="inpt_tadbir_stock_id" name="inpt_tadbir_stock_id" id="inpt_tadbir_stock_id" value="0"  class="form-control" >
                        </td>
                      </tr>


                      <tr>
                        <th><label for="inpt_unitPrice">{{ Lang::get('labels.invoice_Unit_price') }} EPL  ({{ Lang::get('labels.$') }})</label></th>
                        <td>
                          <input type="number" ng-model="inpt_unitPrice" name="inpt_unitPrice" id="inpt_unitPrice" value="0"  class="form-control" >
                        </td>
                      </tr>

                      <!-- ControllerBTN -->
                      <tr>
                        <th></th>
                        <td>
                        <div ng-Click="editProduct_save()" class="btn btn-success">  {{ Lang::get('labels.save') }} </div>
                        </td>
                        <td>
                        <div ng-Click="editProduct_cancel()" class="btn btn-danger">  {{ Lang::get('labels.cancel') }} </div>
                        </td>
                    </tr>
                    </tbody>
                  </table>

                </div>
            </div>
        </div>
      </div>
    </div>
  </div>


@endsection
