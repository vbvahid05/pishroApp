@section('section_list')
<div class="TableContainer">
    <table class="publicTable table table-hover " >

        <tr class="filterBoxRow">
            <th  style="width: 1% !important;">
                <a href="/sell/TakeOutProducts" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i> حذف فیلترها
                </a>
            </th>
            <th colspan="1"  >
                <div class="ui icon input pull-right">
                    <input  style="width: 100% !important;" ng-model="search.$" class="prompt " type="text"  ng-keypress="changePagin()" ng-blur="changePagin()" placeholder="<?php echo \Lang::get('labels.search') ?>">
                    <i class="search icon"></i>
                </div>
            </th>
            <th colspan="3">
                <select ng-model="search.cstmr_family" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">{{ lang::get('labels.all') }}  مشتری ها </option>
                    <option ng-repeat="seller in custommersNameOrgList" value="@{{ seller.cstmr_family }}" >  @{{ seller.cstmr_name }} @{{ seller.cstmr_family }}</option>
                </select>
                <select ng-model="search.org_name" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">{{ lang::get('labels.all') }}  سازمان ها </option>
                    <option ng-repeat="seller in custommersNameOrgList" value="@{{ seller.org_name }}" >   @{{ seller.org_name }} /@{{ seller.cstmr_name }} @{{ seller.cstmr_family }}</option>
                </select>
            </th >
            <th>
                <select ng-model="search.sel_sr_type" ng-change="changePagin()" class="form-control DropFilter ">
                    <option value="">   {{ lang::get('labels.all') }} حواله ها </option>
                    <option value="0">   {{ lang::get('labels.stockRequest_type_certain') }}   </option>
                    <option value="1">   {{ lang::get('labels.stockRequest_type_Accrual') }}   </option>
                </select>
            </th>
            <th style="width:150px;"></th>
            <th>  </th>
            <th>
                <div class="ui icon input pull-right">
                    <input  style="width: 100% !important;" ng-model="search.sel_sr_pre_contract_number" class="prompt " type="text"  ng-keypress="changePagin()" ng-blur="changePagin()" placeholder="<?php echo \Lang::get('labels.Search_pre_contract_number') ?>">
                    <i class="search icon"></i>
                </div>
            </th>



        </tr>



        <tr>
            <th><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /></th>
            <th style="width:  150px;"  >{{ Lang::get('labels.stockRequest_ID') }} </th>
            <th>{{ Lang::get('labels.custommer') }} </th>
            <th>{{ Lang::get('labels.stockRequest_type') }} </th>
            <th>{{ Lang::get('labels.stockRequest_RequestDate') }} </th>
            <th>{{ Lang::get('labels.stockRequest_deliveryDate') }}</th>
            <th>{{ Lang::get('labels.stockRequest_preFaktorNum') }} </th>
            <th> <i class="fa fa-print" style="font-size: 20px;"></i></th>
            <th>{{ Lang::get('labels.status') }} </th>
        </tr>
        <tr ng-repeat="row in allRowsZ
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search
                    | orderBy: orderList
                    "
                    id="row@{{row.id}}">

              <td><input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.id }}"></td>
                <td>
                  @{{ row.id}}
                  <div ng-showx="inAllDatalist" id="inAllDatalist" class="row-actions">
                  @can('TakeOutProducts_update', 1)
                   <span class="edit">
                      <span class="editBtn"  ng-click="EditSelected(row.id)" aria-label="{{Lang::get('labels.edit')}}" >
                         {{ Lang::get('labels.stockRequest_Edit') }}
                       </span>
                    </span>
                  @endcan

                  </div>
                  </td>

                <td>@{{ row.cstmr_name}} @{{ row.cstmr_family}}  <br/> @{{ row.org_name}} </td>
                <td>@{{ row.sel_sr_type  | stockRequestTYPE}}</td>
                <td>@{{ row.sel_sr_registration_date | Jdate}}</td>
                <td>@{{ row.sel_sr_delivery_date | Jdate}}</td>
                <td>@{{ row.sel_sr_pre_contract_number}}</td>
                <td> <a class="btn btn-success" href="/sell/stockRequest/reports/@{{row.id}}" >
                  <i class="fa fa-print" ></i>
                  {{Lang::get('labels.print')}}
                </a></td>
                {{--@{{ row.qtyStatus}}--}}
                <td> <div >  @{{ row.totalQTY  }} /  @{{row.AvailableQTY}}</div></td>
               <br/>

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
