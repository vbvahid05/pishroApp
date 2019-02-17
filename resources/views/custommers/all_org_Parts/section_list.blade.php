@section('section_list')
@{{ arrayid}}
<br/>
<div class="row">
    <div class="row divTableHeader col-md-12">
        <div class="col-sm-4 pull-right"> {{Lang::get('labels.organization_name')}}</div>
        <div class="col-sm-1 pull-right"> {{Lang::get('labels.codeghtesadi')}}</div>
        <div class="col-sm-1 pull-right"> {{Lang::get('labels.tel')}} </div>
        <div class="col-sm-4 pull-right"> {{Lang::get('labels.address')}} </div>
        <div class="col-sm-2 pull-right"> {{Lang::get('labels.postalcode')}} </div>
    </div>
    <div ng-repeat="row in allRows" ng-if="row.org_name != '---'" class="row divTableRowB  BigDivTabel  col-md-12 ng-scope" id="DivRow@{{ row.id}}" style="    margin-right: 15px;">
        <div class="col-sm-4 actionField  pull-right ng-binding">
                @{{row.org_name }}
                <p style="margin-top: -31px;"></p>
                <span class="RowActionBtn">

                    @can('customer_update', 1)
                        <span ng-click="ShowEdit_dimmer(row.id)"    ng-show="btn_edit" class="editBtn"  aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span>
                    @endcan
                    @can('customer_delete', 1)
                        <span ng-click="trashAction('del',row.id)"  ng-show="btn_move_trash" class="submitdelete"   aria-label="{{Lang::get('labels.delete')}}" >| {{ Lang::get('labels.delete') }} </span>
                    @endcan
                    @can('customer_update', 1)
                        <span ng-click="trashAction('reStore',row.id)"  ng-show="BtnRestoreProducts" class="RestoreTrash"   aria-label="{{Lang::get('labels.RestoreFromTrash')}}" > {{ Lang::get('labels.RestoreFromTrash') }} </span>
                    @endcan
                    @can('customer_delete', 1)
                        <span ng-click="trashAction('hardDel',row.id)"  ng-show="BtnDeleteProducts"class="submitdelete"   aria-label="{{Lang::get('labels.fulldelete')}}" >| {{ Lang::get('labels.fulldelete') }} </span>
                    @endcan
                </span>
        </div>
        <div class="col-sm-1  pull-right ng-binding">@{{ row.org_codeeghtesadi }}</div>
        <div class="col-sm-1  pull-right ng-binding">@{{ row.org_tel }}</div>
        <div class="col-sm-4  pull-right ng-binding">@{{ row.org_address }}</div>
        <div class="col-sm-2  pull-right ng-binding">@{{ row.org_postalCode }}</div>
    </div>
</div>
{{--------------}}
<ul class="pagination" style="float:  right;">
    <li><a href="" ng-click="pagination.prevPage()">&laquo;</a></li>
    <li ng-repeat="n in [] | range: pagination.numPages" ng-class="{active: n == pagination.page}">
    <a href="" ng-click="pagination.toPageId(n)">@{{n + 1}}</a>
    </li>
    <li><a href="" ng-click="pagination.nextPage()">&raquo;</a></li>
</ul>
@endsection
