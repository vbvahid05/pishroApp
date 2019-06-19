@section('section_waitForCommit')

        <div class="toolbars well well-sm">
            <!--  trash view -->
            @if($pageType =='addRequest')
                @can('warranty_create', 1)
                    <div class="btn btn-default" ng-click="newUpdateWarranty('new')"> صدور حواله گارانتی </div>
                @endcan
            @endif
            <div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="RestoreGroupFromTrash()"  >
                <i class="fa fa-undo" aria-hidden="true"></i>
                {{ Lang::get('labels.RestoreFromTrash') }}
            </div>
            <div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="FullDeleteSelectedItems()"  >
                <i class="fa fa-trash" aria-hidden="true"></i>
                {{ Lang::get('labels.fulldelete') }}
            </div>

        </div>
        <!-- TOOLBAR -->
        <div class="toolbars well well-sm">
            <span id="ShowAll" class="DatalistSelector active"  ng-click="showAll(0)" >      {{ Lang::get('labels.all') }}   </span>
            <span id="ShowTrashed"  class="DatalistSelector" ng-click="showAll(1)" >   {{ Lang::get('labels.Trash') }}  </span>
        </div>


        <div class="filters ui search">
            <div class="ui icon input">
                <input ng-model="search.$" class="prompt" type="text"  ng-keypress="changePagin(10000)" ng-blur="changePagin(10)">
                <i class="search icon"></i>
            </div>
            <div class="results"></div>
        </div>

        <br/>

        <div class="TableContainer">
            <table class="publicTable table table-hover " >

                <tr ng-show="false" class="filterBoxRow">
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
                    <th style="width:  150px;"  >{{ Lang::get('labels.warranty_id') }} </th>
                    <th style="width:  150px;"  >{{ Lang::get('labels.stockRequest_ID') }} </th>
                    <th> {{ Lang::get('labels.custommer') }} </th>
                    <th> {{ Lang::get('labels.warranty_delevery_date') }} </th>
                    <th> {{ Lang::get('labels.warranty_start_date') }} </th></th>
                    <th></th>
                    <th></th>
                    <th><i class="fa fa-file-pdf-o" style="font-size: 20px;"></i></th>
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
                        @{{ row.warranty_id}}
                        <div ng-showx="inAllDatalist" id="inAllDatalist" class="row-actions">
                            @can('warranty_update', 1)
                                <span class="edit">
                          <span class="editBtn"  ng-click="newUpdateWarranty('edit',row.warranty_id)" aria-label="{{Lang::get('labels.edit')}}" >
                             {{ Lang::get('labels.stockRequest_Edit') }}
                           </span>
                        </span>
                            @endcan
                            @if($pageType =='addRequest')
                                @can('warranty_delete', 1)
                                    <span ng-show="!showListStatus" class="submitdelete"  ng-click="newUpdateWarranty('deleteFlag',row.warranty_id)">      {{ Lang::get('labels.delete') }}        </span>
                                    <span ng-show="showListStatus"  class="RestoreTrash"  ng-click="newUpdateWarranty('restoreFromTrash',row.warranty_id)">{{lang::get('labels.RestoreFromTrash')}}</span>
                                    <span ng-show="showListStatus"  class="submitdelete"  ng-click="newUpdateWarranty('fullDelete',row.warranty_id)">      {{lang::get('labels.fulldelete')}}</span>
                                @endcan


                            @endif
                        </div>
                    </td>
                    <td> @{{ row.stkRq_ID }}</td>
                    <td>@{{ row.cstmr_name}} @{{ row.cstmr_family}}  <br/> @{{ row.org_name}} </td>
                    <td>@{{ row.ssw_delivery_date | Jdate}}</td>
                    <td>@{{ row.ssw_warranty_start_date | Jdate}}</td>
                    <td></td>
                    <td> <div ng-if="row.ssw_request_flag == 1 " class="label label-warning">در انتظار تایید انبار</div> </td>
                    <td>
                        <a   ng-if="row.ssw_request_flag == 2"  href="/sell/warranty/pdf/@{{row.warranty_id}}">
                            <i class="fa fa-file-pdf-o  pdf_btn"></i>
                        </a>
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
        <div style="height:80px;"></div>
        <hr/>

@endsection
