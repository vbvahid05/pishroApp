@section('section_list')
<div class="TableContainer">
    <table class="publicTable table table-hover " >
      <tr>
          <th style="width:  1px;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(0)" id="checkall0" /> </th>
          <th style="width:  150px;"  > # </th>
          <th style="width:  150px;">{{ Lang::get('labels.invoice_alias') }} </th>
          <th>{{ Lang::get('labels.invoice_Custommer') }} </th>
          <th>{{ Lang::get('labels.invoice_date') }} </th>
          <th>{{ Lang::get('labels.by') }} </th>
          <th>{{ Lang::get('labels.print') }} </th>
          <th>{{ Lang::get('labels.pdf') }} </th>
          <th>{{ Lang::get('labels.setting') }} </th>

      </tr>
        <tr ng-show="!waitForInvoiceList">
            <td  colspan="9"> <i class="fa fa-spinner fa-spin" style="font-size:40px"></i>  لطفا صبر کنید</td>
        </tr>
      <tr ng-repeat="row in all_Invoice_rows
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{row.id}}">
              <td><input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.id }}"></td>
                <td>
                    @{{ row.id }}
                  </td>
                <td class="col-md-2" >
                    <span ng-click="Show_Selected_invoice(row.id)" style="color: #0066b7;cursor: pointer;">
                    @{{ row.invoices_Alias }}
                    </span>

                    <div ng-show="SubToolBar_inAllDatalist" id="inAllDatalist" class="row-actions">
                    <span class="edit">
                     @can('invoice_update', 1)
                        <span  ng-showx="row.VerifiedBy == null"  class="editBtn"  ng-click="Show_Selected_invoice(row.id)" aria-label="{{Lang::get('labels.edit')}}" >
                         {{ Lang::get('labels.edit') }}   |
                       </span>
                     @endcan
                     @can('invoice_delete', 1)
                        <a class="submitdelete"  ng-click="move_invoicetoTrash(row.id,0)">  {{ Lang::get('labels.delete') }}</a>
                     @endcan
                     @can('invoice_create', 1)
                        <a class="copyItem"  ng-click="copyInvoice(row.id)"> |  {{ Lang::get('labels.copy') }}</a>
                     @endcan
                    </span>
                    </div>
                    <div ng-show="SubToolBar_inTrashlist" id="inTrashlist" class="row-actions">
                        @can('invoice_delete', 1)
                        <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="move_invoicetoTrash(row.id,2)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                        <span class="trash">        <span  class="submitdelete"  ng-click="move_invoicetoTrash(row.id,1)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                        @endcan
                    </div>
                </td>
                <td class="col-md-4" ng-click="Show_Selected_invoice(row.id)"  style="color: #0066b7;cursor: pointer;">@{{ row.custommer_name}} @{{ row.custommer_family}}  <br/> @{{ row.orgName}} </td>
                <td class="col-md-2">@{{ row.invoices_Date}}</td>
                <td class="col-md-2">@{{ row.createdBy}}</td>
                <td class="col-md-1">

                    <a ng-show="row.VerifiedBy!=null" href="/sell/invoice/print/@{{ row.id }}" style="font-size:24px" target="_blank">
                        <i class="fa fa-print"></i>
                    </a>
                </td>
                <td class="col-md-1">
                    <a ng-show="row.VerifiedBy!=null" href="/sell/invoice/pdf/@{{ row.id }}"  >
                        <i class="fa fa-file-pdf-o  pdf_btn" ></i>
                    </a>
                </td>

                <td class="col-md-1">
                    <a ng-show="row.VerifiedBy!=null" ng-click="pdf_config(row.id )"  >
                        <i class="fa fa-cog pdfconf" ></i>
                    </a>
                </td>


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
