@section('section_All_brands')




<div class="TableContainer">
    <table class="allcustomertable table table-hover " >
      <tr>
          <th style="width: 1% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(1)" id="checkall1" /><th>
          <th style="width:  300px;">{{ Lang::get('labels.Brand_name') }} <th>
          <th>{{ Lang::get('labels.Brand_logo') }} <th>
      </tr>

      <tr ng-repeat="brand in AllBrandTabel
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{product.productID}}">

              <td>
               <input type="checkbox" class="checkbox" name="itemIdList" value="@{{ brand.id }}">
              <td>
              <td>
               @{{ brand.stkr_prodct_brand_title}}
               <br/>
<!--
               <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                 <span class="edit">
                   <span class="editBtn"  ng-click="editProduct(product.productID)" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span> |
                 </span>
                 <span class="trash"> <span  class="submitdelete"  ng-click="moveToTrash(product.productID)" >{{ Lang::get('labels.moveToTrash') }}</span>
                 </span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>

               <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                 <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash(product.productID)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                 <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase(product.productID)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>
-->
             <td>
             <td> @{{product.stkr_prodct_titlea }} <td>

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
