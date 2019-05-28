@section('section_list')
<div class="TableContainer">

    <div my-Test-Directive></div>
    <div class="my-Test-Directive"></div>
    <table class="publicTable table table-hover " >
      <tr>
          <th><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /></th>
          <th style="width:  150px;">{{ Lang::get('labels.stockRequest_ID') }} </th>
          <th>{{ Lang::get('labels.custommer') }} </th>
          <th>{{ Lang::get('labels.stockRequest_type') }} </th>
          <th>{{ Lang::get('labels.stockRequest_RequestDate') }} </th>
          <th>{{ Lang::get('labels.stockRequest_deliveryDate') }}</th>
          <th>{{ Lang::get('labels.stockRequest_preFaktorNum') }} </th>
          <th> کاربر </th>
          <th>{{ Lang::get('labels.status') }} </th>
      </tr>
      <tr   id="row@{{row.id}}" ng-repeat="row in allRowsZ
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                  on-finish-render="showActionBTNs()"
                  ng-class="row.sel_sr_type == 0 ? 'StockTypeA' : 'StockTypeB'"
                   >

              <td><input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.id }}"></td>
                <td>
                  @{{ row.id}}
              <div ng-showx="inAllDatalist" id="inAllDatalist" class="row-actions">
                    <span class="edit">
                     @can('stockRequest_update', 1)
                            <span class="editBtn"  ng-click="EditSelected(row.id)" aria-label="{{Lang::get('labels.edit')}}" >
                            <!-- addClass('hideEditBTN') -->
							 {{ Lang::get('labels.stockRequest_Edit') }}
                           </span>
                      @endcan
                      @can('stockRequest_delete', 1)
                           <span class="submitdelete"  ng-click="DeleteRequestFromBaseList(row.id)" aria-label="{{Lang::get('labels.stockRequest_Delete')}}" >
                             {{ Lang::get('labels.delete') }}
                           </span>
                      @endcan
                    </span>
                  </div>
                  </td>

                    <td>@{{ row.cstmr_name}} @{{ row.cstmr_family}}  <br/> @{{ row.org_name}} </td>
                    <td>
                        <span ng-show="row.sel_sr_type !=2" ng-class="row.sel_sr_type == 0 ? 'StockType_span_A' : 'StockType_span_B'"> @{{ row.sel_sr_type  | stockRequestTYPE}}  </span>
                        <span ng-show="row.sel_sr_type ==2" ng-class="'StockType_span_C'"> @{{ row.sel_sr_type  | stockRequestTYPE}}  </span>

                    </td>
                    <td>@{{ row.sel_sr_registration_date | Jdate}}</td>
                    <td>@{{ row.sel_sr_delivery_date | Jdate}}</td>
                    <td>@{{ row.sel_sr_pre_contract_number}}</td>
                    <td>
                        <span class="label label-danger" ng-show="row.userName == 'سامانه' "># @{{ row.userName }} </span>
                        <span ng-show="row.userName != 'سامانه' ">  @{{ row.userName }} </span>
                    </td>
                    <td>
                        <button id="Finalconfirm@{{row.id}}" class="toggleButton btn btn-success" ng-click="ActionBTN(1,row.id,row.AvailableQTY,row.totalQTY,row.lockStatus)" >
                         {{Lang::get('labels.Final_approval')}}
                       </button>
                      <a href="/sell/stockRequest/print/@{{row.id}}" id="action_print@{{row.id}}" target="_blank"  class="toggleButton btn btn-info " style="float: right;">
                        <i class="fa fa-print"></i>
                          {{Lang::get('labels.Delivery_of_minutes')}}

                      </a>
                      <span id="action_pdf@{{row.id}}" class="toggleButton" style="float: left;"  >
                          <a href="/sell/stockRequest/pdf/@{{row.id}}" > <i class="fa fa-file-pdf-o  pdf_btn" ></i></a>
                          <span ng-click="StkReqPDFSetting(row.id)" > <i class="fa fa-cog pdfconf" style="margin-right: 25px;"> </i> </span>
                      </span>
                    </td>

      </tr>
    </table>
  </div>

  <!-- pagination -->
    <ul class="pagination" style="float:  right;">
      <li><a href="" ng-click="pagination.prevPage()">&laquo;</a></li>
      <li ng-repeat="n in [] | range: pagination.numPages" ng-class="{active: n == pagination.page}"><a href="" ng-click="pagination.toPageId(n)">@{{n + 1}}</a></li>
      <li><a href="" ng-click="pagination.nextPage()">&raquo;</a></li>
    </ul>
  <!-- pagination -->
  <div style="height:  80;"></div>
  <hr/>








@endsection
