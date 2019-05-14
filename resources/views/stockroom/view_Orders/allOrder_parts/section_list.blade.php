@section('section_list')
<div class="TableContainer">
    <table class="publicTable table table-hover " >
        <tr class="filterBoxRow">
            <th  style="width: 1% !important;">
                <a href="/stock/AllOrders" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i> حذف فیلترها
                </a>
            </th>
            <th colspan="2"  >

                <div class="ui icon input pull-right">
                    <?php //$placeholder="{{ Lang::get('labels.search') }}" ?>
                    <input  style="width: 100% !important;" ng-model="search.$" class="prompt " type="text"  ng-keypress="changePagin()" ng-blur="changePagin()" placeholder="<?php echo \Lang::get('labels.search') ?>">
                    <i class="search icon"></i>
                </div>
            </th>

            <th style="width:200px;">
                <select ng-model="search.stkr_ordrs_slr_name" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">   {{ lang::get('labels.all') }} </option>
                    <option ng-repeat="seller in OrderSeller  " value="@{{ seller.stkr_ordrs_slr_name }}" > @{{ seller.stkr_ordrs_slr_name }}</option>
                </select>
            </th >
            <th style="width:150px;">  </th>
            <th style="width:150px;">
                <select ng-model="search.stk_ordrs_status_id" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">   {{ lang::get('labels.all') }} </option>
                    <option ng-repeat="Status in OrderStatus  " value="@{{ Status.id }}" > @{{ Status.stkr_ordrs_stus_title }}</option>
                </select>
            </th>
            <th>  </th>
            <th>
                <select ng-model="search.stk_ordrs_user_id" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">   {{ lang::get('labels.all') }} </option>
                    <option ng-repeat="Users in OrderUsers  " value="@{{ Users.userID }}" > @{{ Users.userName }}</option>
                </select>

            </th>
        </tr>

      <tr>
            <th style="width: 1% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /></th>
            <th style="width:100px;" >{{ Lang::get('labels.Order_code') }} </th>
            <th style="width:150px;" >{{ Lang::get('labels.Orders_ID') }} </th>
            <th style="width:200px;">
            {{ Lang::get('labels.Orders_Seller_name') }}
            </th>
            <th style="width:150px;">{{ Lang::get('labels.Orders_puttingDate') }} </th>
            <th style="width:150px;">{{ Lang::get('labels.Orders_Status') }} </th>
            <th>{{ Lang::get('labels.Orders_comment') }} </th>
            <th>{{ Lang::get('labels.by') }} </th>
        </tr>




      <tr ng-repeat="row in allRows
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{row.orderID}}">

              <td>
               <input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.orderID }}">
              </td>

              <td>
                 @{{ row.stk_ordrs_id_code}}
              </td>
              <td>
                   @{{ row.stk_ordrs_id_number}}
              </td>

              <td>
               @{{ row.stkr_ordrs_slr_name}}
               <br/>

               <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
             @can('order_update', 1)
                 <span class="edit">
                   <span class="editBtn"  ng-click="EditSelected(row.orderID)" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span> |
                 </span>
             @endcan
             @can('order_delete', 1)
                 <span ng-show="row.stk_ordrs_id_number != 'Warranty_SYS'" class="trash"> <span  class="submitdelete"  ng-click="MoveToTrash(row.orderID)" >{{ Lang::get('labels.moveToTrash') }}</span>
                 </span>
             @endcan
                 <span class="view"><a href="#" rel="bookmark"> </a>  </span>
               </div>

               <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
            @can('order_delete', 1)
                 <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash(row.orderID)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                 <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase(row.orderID)" >{{ Lang::get('labels.fulldelete') }}</span></span>
            @endcan
                 <span class="view"><a href="#" rel="bookmark"> </a>  </span>
               </div>

             </td>

             <td nd-model="convertDate">
               @{{ row.stk_ordrs_putting_date | Jdate}}</td>
             <td>  @{{ row.stkr_ordrs_stus_title}}</td>
             <td>  @{{ row.stk_ordrs_comment}}</td>
             <td>
                  <span class="label label-danger" ng-show="row.stk_ordrs_id_number == 'Warranty_SYS'">
                   #   @{{ row.name}}</span>
                  <span  ng-show="row.stk_ordrs_id_number != 'Warranty_SYS'">@{{ row.name}}</span>
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
