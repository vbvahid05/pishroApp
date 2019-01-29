@section('section_filter')
<div class="filters ui search">
   <div class="FilterBox col-md-12" >
       <div class="col-md-3 pull-right">
           <div class="ui icon input">
               <input ng-model="search.$" class="prompt" type="text" placeholder="{{ Lang::get('labels.search') }}"  ng-keypress="changePagin(10000)" ng-blur="changePagin(10)">
               <i class="search icon"></i>
           </div>
       </div>

       <div class="col-md-2 pull-right" style="border-right: 1px dotted lightgray;">
            <i class="fa fa-filter Filter_icon" aria-hidden="true" ></i>
            <select class="form-control DropFilter" ng-model="search.prodct_Brand" ng-change="getRelatedType()" style="width: 79% !important;">
                <option ng-repeat="value in product_Brands" value="@{{value.id}}">@{{value.name}}</option>
            </select>
        </div>
       <div class="col-md-2 pull-right">
           <select class="form-control DropFilter" ng-model="search.prodct_Type">
               <option ng-repeat="value in product_Type" value="@{{value.id}}">@{{value.name}}</option>
           </select>
       </div>
        <div class="col-md-2 pull-right">
            <select class="form-control DropFilter" ng-model="search.prodct_Type_Cat" style="width: 95% !important;">
                <option ng-repeat="value in product_Type_Cat" value="@{{value.id}}">@{{value.name}}</option>
            </select>
        </div>



       <div class="col-md-2 pull-left">
           <a  href="/sell/ProductStatusReport" class="btn btn-default">
                <i class="fa fa-refresh" aria-hidden="true"></i> {{ Lang::get('labels.filter_Clear') }}
           </a>
       </div>


       <div class="col-md-1 pull-left" style="padding:  0;">
           <select class="form-control " ng-model="list_mode" ng-change="change_list_mode()">
               <option  value="0" selected="selected">{{Lang::get('labels.all')}}</option>
               <option  value="1">{{Lang::get('labels.AvailableProducts')}}</option>
           </select>
       </div>

    </div>

    <div class="results"></div>
</div>
@endsection

