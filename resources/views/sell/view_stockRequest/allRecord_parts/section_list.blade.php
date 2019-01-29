@section('section_list')
<div class="TableContainer">

    <div my-Test-Directive></div>
    <div class="my-Test-Directive"></div>
    <table class="publicTable table table-hover " >
      <tr>
          <th ><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /><th>
          <th style="width:  150px;"  >{{ Lang::get('labels.stockRequest_ID') }} <th>
          <th>{{ Lang::get('labels.custommer') }} <th>
          <th>{{ Lang::get('labels.stockRequest_type') }} <th>
          <th>{{ Lang::get('labels.stockRequest_RequestDate') }} <th>
          <th>{{ Lang::get('labels.stockRequest_deliveryDate') }}<th>
          <th>{{ Lang::get('labels.stockRequest_preFaktorNum') }} <th>
          <th>{{ Lang::get('labels.status') }} <th>
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

              <td><input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.id }}"><td>
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
                  <td>

                    <td>@{{ row.cstmr_name}} @{{ row.cstmr_family}}  <br/> @{{ row.org_name}} <td>
                    <td> <span  ng-class="row.sel_sr_type == 0 ? 'StockType_span_A' : 'StockType_span_B'"> @{{ row.sel_sr_type  | stockRequestTYPE}}  </span><td>
                    <td>@{{ row.sel_sr_registration_date | Jdate}}<td>
                    <td>@{{ row.sel_sr_delivery_date | Jdate}}<td>
                    <td>@{{ row.sel_sr_pre_contract_number}}<td>
                    <td>
                        <button id="Finalconfirm@{{row.id}}" class="toggleButton btn btn-success" ng-click="ActionBTN(1,row.id,row.AvailableQTY,row.totalQTY,row.lockStatus)" >
                         {{Lang::get('labels.Final_approval')}}
                       </button>
                      <a href="/sell/stockRequest/print/@{{row.id}}" id="action_print@{{row.id}}" target="_blank"  class="toggleButton btn btn-info " style="float: right;">
                        <i class="fa fa-print"></i>
                          {{Lang::get('labels.Delivery_of_minutes')}}

                      </a>

                  <a id="action_pdf@{{row.id}}" class="toggleButton" href="/sell/stockRequest/pdf/@{{row.id}}" style="float: left;"  >

                      <i class="fa fa-file-pdf-o  pdf_btn" ></i>
                  </a>


                    <td>
               <br/>


<!--
               <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                 <span class="edit">
                   <span class="editBtn"  ng-click="EditSelected(row.orderID)" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span> |
                 </span>
                 <span class="trash"> <span  class="submitdelete"  ng-click="MoveToTrash(row.orderID)" >{{ Lang::get('labels.moveToTrash') }}</span>
                 </span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>

               <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                 <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash(row.orderID)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                 <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase(row.orderID)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>
-->
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
