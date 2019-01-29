@section('section_type_list')
<div class="TableContainer">
    <table class="allcustomertable table table-hover " >
      <tr>
          <th style="width: 1% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /><th>
          <th style="width:  300px;">{{ Lang::get('labels.productType') }} <th>
          <th>{{ Lang::get('labels.Product_brand') }} <th>
      </tr>
      <tr ng-repeat="Types in AllTypesTabel
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{product.productID}}">

              <td>
               <input type="checkbox" class="checkbox" name="itemIdList" value="@{{ Types.id }}">
              <td>
              <td>
               @{{ Types.stkr_prodct_type_title}}
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
             <td>  @{{ Types.stkr_prodct_brand_title}}<td>
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


  <div  id="addNewType"   class="ui page dimmer">
    <div class="content">
      <div class="center">
        <div class="ui text container">
            <div class="ui segments">
              <div class="ui segment" style="height:  400px;  width: 450px;">
                <!-- -->
                <h3>{{ Lang::get('labels.add_new_productType') }}</h3>
                <p></p>
                <!-- Notifications-->
                  <div class="publicNotificationMessage" >
                      @{{ publicNotificationMessage }}
                  </div>
                <!-- Notifications-->
                <label> {{ Lang::get('labels.Product_brand') }}</label>
                  <div class="ui container" data-live-search="true" data-selected-text-format="values" >
                      <select  ng-model="brandName" class="ui search selection dropdown search-select" name="brandname"  >
                          <option ng-repeat="brand in AllBrandTabel" value="@{{brand.id}}" >
                           @{{brand.stkr_prodct_brand_title}}
                          </option>
                      </select>
                  </div>
                  <br/>
                  <label> {{ Lang::get('labels.Product_type') }}</label>
                  <input ng-model="newType" type="text" class="form-control ng-pristine ng-valid ng-empty ng-touched" style="display:  block;margin:  auto;">
                  <hr/>
                  <a ng-click="add_new_productType()" class="btn btn-success">{{ Lang::get('labels.save') }} </a>
                  <a id="new_productType_Cancel" class="btn btn-danger">{{ Lang::get('labels.cancel') }} </a>
                <!-- -->
               </div>
            </div>
        </div>
      </div>
    </div>
  </div>






@endsection
