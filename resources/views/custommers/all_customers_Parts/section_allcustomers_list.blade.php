@section('section_allcustomers_list')
@{{ arrayid}}

<div class="TableContainer">
    <table class="allcustomertable table table-hover " >
        <tr>
          <th>
              <input type="checkbox" ng-model="confirmed" ng-change="checkall()" id="checkall" /><th>
          <th style="width:  300px;">{{ Lang::get('labels.firstname') }}   {{ Lang::get('labels.lastname') }} <th>
          <th>{{ Lang::get('labels.organization') }} <th>
          <th>{{ Lang::get('labels.post_in_organization') }}  <th>
          <th>{{ Lang::get('labels.tel') }} <th>
          <th>{{ Lang::get('labels.email') }} <th>
          <th>{{ Lang::get('labels.postalcode') }}  <th>
          <th>{{ Lang::get('labels.address') }} <th>
          <th>{{ Lang::get('labels.codeghtesadi') }} <th>
          <th>{{ Lang::get('labels.detials') }}  <th>
        </tr>
        <tr ng-repeat="customer in allcustommers
                      | startFrom: pagination.page * pagination.perPage
                      | limitTo: pagination.perPage
                      | filter:search
                      | orderBy: orderList
                      "
                      id="row@{{customer.custommersID }}">
              <td>
                 <input type="checkbox" class="checkbox" name="itemIdList" value="@{{ customer.custommersID }}">
              <td>
               <td>
                 @{{ customer.cstmr_name }} @{{ customer.cstmr_family }}
                 <br/>
                <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                   <div class="row-actions">
                     @can('customer_update', 1)
                        <span class="edit"><a  href="/custommer/@{{ customer.custommersID }}" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </a> | </span>
                     @endcan
                     @can('customer_delete', 1)
                        <span class="trash"><span   href="#"  class="submitdelete"  ng-click="Trash_Restore_delete(customer.custommersID,1)" >{{ Lang::get('labels.moveToTrash') }}</span> </span>
                     @endcan
                   </div>
                 </div>

                 <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                    @can('customer_update', 1)
                        <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="Trash_Restore_delete(customer.custommersID,0)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                    @endcan
                    @can('customer_delete', 1)
                    <span class="trash">        <span  class="submitdelete"  ng-click="Trash_Restore_delete(customer.custommersID,3)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                    @endcan
                    <span class="view"><a href="#" rel="bookmark" </a>  </span>
                 </div>
               <td>
               <td> @{{customer.org_name }} <td>
               <td> @{{customer.ctm_org_semat_title }} <td>
               <td> @{{customer.cstmr_tel }} <td>
               <td> @{{customer.cstmr_email }} <td>
               <td> @{{customer.cstmr_postalcode }} <td>
               <td> @{{customer.cstmr_address }} <td>
               <td> @{{customer.cstmr_codeghtesadi }} <td>
               <td> @{{customer.cstmr_detials }} <td>

        </tr>
  </table>
</div>
<ul class="pagination" style="float:  right;">
    <li><a href="" ng-click="pagination.prevPage()">&laquo;</a></li>
    <li ng-repeat="n in [] | range: pagination.numPages" ng-class="{active: n == pagination.page}">
    <a href="" ng-click="pagination.toPageId(n)">@{{n + 1}}</a>
    </li>
    <li><a href="" ng-click="pagination.nextPage()">&raquo;</a></li>
</ul>



@endsection
