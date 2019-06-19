@section('section_list')

    <div class="ui tabular menu" style="margin: 0!important;">
        @if($pageType != 'addRequest')
          <div class="item active" data-tab="WarrantyStockCommit">{{lang::get('labels.WarrantyStockCommit')}} </div>
        @endif
        @if($pageType != 'addRequest')
            <div class="item" data-tab="warrantyStockRoom" ng-click="getWarrantyStockRoomList()">
                {{lang::get('labels.warrantyStockRoom')}}
            </div>
        @endif
    </div>


    <div class="ui tab active" data-tab="WarrantyStockCommit">
        @section('section_waitForCommit') @show
    </div>

    @if($pageType != 'addRequest')
        <div class="ui tab" data-tab="warrantyStockRoom">
            @section('section_warrantyStock') @show
        </div>
    @endif

@endsection
