@section('section_warrantyStock')
    <div class="ui icon input pull-right">
        <input  style="width: 100% !important;margin-top: 10px;margin-bottom: 10px;margin-right: 10px;" ng-model="search.$" class="prompt " type="text"  ng-keypress="changePagin()" ng-blur="changePagin()" placeholder="<?php echo \Lang::get('labels.search') ?>">
        <i class="search icon"></i>
    </div>
    <div class="TableContainer">
    <table  class="publicTable table table-hover ">
        <tr>
            <th>{{lang::get('labels.partNumber')}}</th>
            <th>{{lang::get('labels.stockRequest_ID')}}</th>
            <th>{{lang::get('labels.warranty_id')}}</th>
            <th>{{lang::get('labels.Product_title')}}</th>
            <th>{{lang::get('labels.invoice_Custommer')}}</th>
            <th>{{lang::get('labels.warranty_start_date')}}</th>
            <th>{{lang::get('labels.WarrantyFailedSN')}}</th>
            <th>{{lang::get('labels.WarrantySNS')}}</th>
        </tr>

        <tr ng-repeat="row in WarrantyStockRoomList
                        | startFrom: pagination.page * pagination.perPage
                        | limitTo: pagination.perPage
                        | filter:search
                        | orderBy: orderList
                        " >

            <td>@{{ row.partnumber }}</td>
            <td>@{{ row.warrantieID }}</td>
            <td>@{{ row.stockrequestID }}</td>
            <td>@{{ row.prodct_type_cat }} @{{ row.prodct_brand }}  @{{ row.prodct_type }} <br/> @{{ row.prodct_title }}   </td>
            <td>@{{ row.custommer_Name }}  @{{ row.cstmr_family }} <br/> @{{ row.org_name }}  </td>
            <td> @{{ row.warranty_start_date }}</td>
            <td>@{{ row.faultySN_a }} <br/> @{{ row.faultySN_b }}</td>
            <td>
                <span class="  ">@{{ row.AlterSN1 }}</span>  <br/>
                <span class="  ">@{{ row.AlterSN2 }}</span>  <br/>
            </td>


        </tr>
    </table>
    </div>
@endsection
