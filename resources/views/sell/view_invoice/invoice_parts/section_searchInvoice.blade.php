
@section('section_searchInvoice')
    <div ng-show="section_searchInvoice_dimmer">
        <div   class="ui segment" style="position: absolute !important;
                                        top: 50%;
                                        left: 50%;
                                        min-height: 500px;
                                        width: 1200px!important;
                                        border-top: 4px solid #4CAF50;
                                        margin-left: -600px;
                                        margin-top: -400px;
                                        z-index: 20000;
">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>

            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <hr/>
                <!------ ------>
                    <form ng-submit="searchInvoice()">
                        <div class="row" style="
                            background: #d2d2d2;
                            padding-top: 20px;
                            padding-bottom: 20px;
                            border-bottom: 2px solid #b9b9b9;
                            margin-top: -18px;">
                            <div class="col-md-1 pull-right"></div>
                            <div class="col-md-7  pull-right">
                                <input ng-model="SearchFor" class="form-control" type="text" style="width: 100% !important; " required>
                            </div>
                            <div class="col-md-3 col-md-offset-1 pull-right">
                                <button type="submit" class="btn btn-success" style="width: 100% ;">Find</button>
                            </div>
                        </div>
                    </form>
                    <div class="row SreachResalt" >
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr >
                                <th>{{lang::get('labels.partNumber')}}</th>
                                <th>{{lang::get('labels.Product_title')}}</th>
                                <th>{{lang::get('labels.invoice_alias')}}</th>
                                <th>{{lang::get('labels.invoice_date')}}</th>
                                <th>{{lang::get('labels.qty')}}</th>
                                <th>{{lang::get('labels.invoice_Unit_price')}}</th>
                                <th>{{lang::get('labels.Totalsummery')}}</th>
                            </tr>
                            <tr ng-repeat="SRslt in SreachResalt">
                                <td> @{{SRslt.stkr_prodct_partnumber_commercial}}</td>
                                <td> @{{ SRslt.stkr_prodct_title }} </td>
                                <td> @{{ SRslt.si_Alias_id }} </td>
                                <td> @{{ SRslt.si_date |Jdate }} </td>
                                <td> @{{ SRslt.sid_qty }} </td>
                                <td> @{{ SRslt.sid_Unit_price }} </td>
                                <td> @{{  SRslt.sid_qty*SRslt.sid_Unit_price }} </td>
                            </tr>
                            </tbody>
                        </table>
                        <div ng-show="Noresult" >
                            <h3>
                                {{lang::get('labels.keyValueNotFound')}}
                            </h3>
                        </div>
                    </div>
                <!------ ------>
            </div>
        </div>
    </div>
@endsection
