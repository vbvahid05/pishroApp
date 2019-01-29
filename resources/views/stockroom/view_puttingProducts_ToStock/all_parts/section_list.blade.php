@section('section_list')
<div class="TableContainer">
    <table class="publicTable table table-hover " >
      <tr>
          <th style="width: 1% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /><th>
          <th >{{ Lang::get('labels.Orders_ID') }} <th>
          <th style="width:  300px;">{{ Lang::get('labels.Order') }} <th>
          <th style="width:  100px;">{{ Lang::get('labels.Orders_puttingDate') }}  <th>
          <th>{{ Lang::get('labels.Orders_products') }} <th>
          <th>{{ Lang::get('labels.serialNumber') }} <th>
          <th><th>
      </tr>

      <tr ng-repeat="row in allRows
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{row.puttingProductsID}}">

              <td>
               <input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.OrderID }}">
              <td>

              <td  style="width:  100px;">
                 @{{ row.stk_ordrs_id_code}}
                 <BR/>
                <span style="border-top: 1px dashed #c1c1c1;line-height:  2.5;">    @{{ row.stk_ordrs_id_number}} </span>

              <td>

              <td>   @{{ row.stkr_ordrs_slr_name}}
               <br/>

               <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                <!-- <span class="view"><span class="viewBtn"  ng-click="ViewSelected(row.OrderID)"><i class="fa fa-eye"></i> {{ Lang::get('labels.view') }} </span>  |</span> -->
                 <span class="edit">
                   <span class="editBtn"  ng-click="EditSelected(row.OrderID)" aria-label="{{Lang::get('labels.edit')}}" ><i class="fa fa-eye"></i> {{ Lang::get('labels.view') }} </span>
                 </span>
              <!--    <span class="trash"> <span  class="submitdelete"  ng-click="MoveToTrash(row.puttingProductsID)" >{{ Lang::get('labels.moveToTrash') }}</span> -->
                 </span>

               </div>

               <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                 <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash(row.puttingProductsID)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                 <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase(row.puttingProductsID)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                 <span class="view"><a href="#" rel="bookmark" ></a>  </span>
               </div>

             <td>
             <td nd-model="convertDate">@{{ row.stk_ordrs_putting_date | Jdate}} <td>
             <td >

              <div id="products@{{ row.OrderID }}">
                  <a   href="/puttingProducts/reports/@{{ row.OrderID }}">
                      {{--@{{row.link | handelPrintBtn}}--}}
                      @{{row.link | handelPrintBtn}}
                  </a>
              </div>
              {{--@{{row.link  | handelReminedQTY}}--}}
          <td>
             <td><!-- <i ng-click="show_serialNumber_form(row.puttingProductsID)"  class="fa fa-barcode" style="font-size:24px;cursor: pointer;"></i> --><td>
             <td><td>
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
