@section('section_filter')
<div class="filters ui search">
    <div class="col-md-3 pull-right">
        <div class="ui icon input">
            <?php //placeholder="{{ Lang::get('labels.search') }}" ?>

                <input ng-model="search.$"  class="prompt" type="text"  ng-keypress="changePagin(10000)" ng-blur="changePagin(10)">
            <i class="search icon"></i>
        </div>
    </div>

    <div class="col-md-3 pull-right">
    <select ng-model="search.sel_sr_type" class="form-control DropFilter ">
        <option value="">   {{ lang::get('labels.all') }} </option>
        <option value="0" > {{ lang::get('labels.stockRequest_type_certain') }} </option>
        <option value="1">  {{ lang::get('labels.stockRequest_type_Accrual') }}</option>
    </select>
    </div>

    <div class="col-md-3 pull-right">
        <input type="text" ng-model="search.sel_sr_pre_contract_number" class="form-control" placeholder="{{ lang::get('labels.Search_pre_contract_number')}} ">
    </div>

    <div class="results"></div>
</div>
@endsection
