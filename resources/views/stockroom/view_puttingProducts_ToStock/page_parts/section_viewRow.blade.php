@section('section_viewRow')
  <div ng-show="viewRow_in_Dimmer">
    <div   class="ui segment" style="min-height:600px ;width: 190%!important;right: -300px;border-top: 4px solid #f2711c;">
        <h3 class="dimmer-title">@{{ FormTitle }}</h3>
        <hr/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage" >
          <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
        </div>
        <!-- Form Body -->


            <div class="col-md-6 pull-right"  ng-repeat="row in allRows
                        | filter:{puttingProductsID: SelectedRowId  } ">
                        <table class="table" >
                        <tr>
                          <th>{{ Lang::get('labels.Product_brand') }} </th>
                          <td>@{{row.stkr_prodct_brand_title}} </td>
                        </tr>
                        <tr>
                          <th> {{ Lang::get('labels.Product_type') }}   </th>
                          <td> @{{ row.stkr_prodct_type_title}}</td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.Product_title') }} </th>
                          <td>@{{row.stkr_prodct_title}}</td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.Product_PartNumber_comersial') }} </th>
                          <td>@{{row.stkr_prodct_partnumber_commercial}} </td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.Orders_Seller_name') }} ( {{ Lang::get('labels.Order') }} )  </th>
                          <td> @{{ row.stkr_ordrs_slr_name}} </td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.Orders_Status') }} </th>
                          <td>@{{ row.stkr_ordrs_stus_title}}  </td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.putting_Date') }} </th>
                          <td>@{{ row.stkr_stk_putng_prdct_in_date | Jdate}}  (   @{{ row.stkr_stk_putng_prdct_in_date }} )</td>
                        </tr>
                        <tr>
                          <th>{{ Lang::get('labels.partNumber') }} </th>
                          <td>@{{ row.stkr_stk_putng_prdct_tech_part_numbers}}</td>
                        </tr>
                        <tr>
                          <th> {{ Lang::get('labels.Chassis_number') }} </th>
                          <td>@{{ row.stkr_stk_putng_prdct_chassis_number}}</td>
                        </tr>
                        <tr>
                          <th> {{ Lang::get('labels.SO_number') }} </th>
                          <td>@{{ row.stkr_stk_putng_prdct_SO_Number}}</td>
                        </tr>

                       </table>
            </div>


        <div class="col-md-6" >

            <table class="table" >
              <tr style="font-size:  12;background:  #f4f4f4;">
                <th></th>
                <td>{{ Lang::get('labels.serialNumber') }}1</td>
                <td>{{ Lang::get('labels.serialNumber') }}2 </td>
              </tr>
              <tr  ng-repeat="row in allSerials">
                <th>{{ Lang::get('labels.newProduct') }} </th>
                <td>@{{row.stkr_srial_serial_numbers_a}} </td>
                <td>@{{row.stkr_srial_serial_numbers_b}} </td>
              </tr>
            </table>
        </div>
    </div>
  </div>
@endsection
