

@section('section_convert_stockrequerst')
    <div ng-show="section_convert_stockrequerst_in_Dimmer">
        <div   class="ui segment" style="z-index: 100000 !important;position: absolute !important;top: -380px;height:700px;width: 500px;right: 100;border-top: 4px solid #F44336;
                                          box-shadow: 0px 0px 16px -3px;overflow: scroll;
                                          overflow-x: hidden;
                                          overflow-y: scroll;">
            <h3 class="dimmer-title"><i class="fa fa-retweet"></i>  @{{ FormTitle_convert }} </h3>
            <hr/>
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>
            <div class="toolBar">
                <div class="col-md-10 pull-right">
                    <div class="btn btn-success" ng-click="ConvertStockRequest()"> اجرای عملیات </div>
                </div>
                <div class="col-md-2 pull-right">
                    <div class="btn btn-danger" ng-click="closeConvertDimmer()">{{lang::get('labels.close')}}</div>
                </div>
            </div>
            {{---------------------------------------------}}
            <i ng-show="showLoadSpiner" class="fa fa-spinner fa-spin" style="position: absolute;z-index: 1000;font-size: 80px;color: #5cb85b;background: #fff;border-radius: 100px;top: 200px;right: 40%;"></i>
            <div class="ui list" style="text-align: right">
                <div class="item" ng-repeat="PsL in PartsList">
                    <i ng-show="PsL.stkr_prodct_type_cat ==1 " class="fa-gear icon"></i>
                    <i ng-show="PsL.stkr_prodct_type_cat ==2 " class="fa-puzzle-piece icon"></i>
                    <i ng-show="PsL.stkr_prodct_type_cat ==3 " class="fa-server icon"></i>

                    <div class="content">
                        <div class="header" data-tooltip="@{{ PsL.ssr_d_qty }} | @{{ PsL.sps_available }}  " data-position="top left" ng-class="PsL.ssr_d_qty <= PsL.sps_available ? 'Text_Avail' : 'Text_unAvailable'">
                            @{{ PsL.stkr_prodct_title }}
                        </div>
                        <div class="description" ng-class="PsL.ssr_d_qty <= PsL.sps_available ? 'Text_Avail' : 'Text_unAvailable'"> @{{ PsL.stkr_prodct_partnumber_commercial }}</div>

                        <div class="list"  ng-show="PsL.stkr_prodct_type_cat ==3 ">

                            <div class="item" ng-repeat="SUBCHASSIS in PsL.subChassis" >
                                <i class="fa-puzzle-piece icon"></i>
                                <div class="content">
                                    <div class="header" data-tooltip="@{{ SUBCHASSIS.ssr_d_qty }} | @{{ SUBCHASSIS.sps_available }}  " data-position="top left" ng-class="SUBCHASSIS.ssr_d_qty <= SUBCHASSIS.sps_available ? 'Text_Avail' : 'Text_unAvailable'">@{{ SUBCHASSIS.stkr_prodct_title }} </div>
                                    <div class="description" ng-class="SUBCHASSIS.ssr_d_qty <= SUBCHASSIS.sps_available ? 'Text_Avail' : 'Text_unAvailable'">@{{SUBCHASSIS.stkr_prodct_partnumber_commercial }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top: 0px !important;margin-bottom: 0px !important;">
                </div>
            </div>
        </div>
    </div>
@endsection
