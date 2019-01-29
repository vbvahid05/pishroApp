
 @section('section_sub_chassis_list')
<div ng-show="section_sub_chassis_list">

    <div class="ui segment" style="
                border-top: 5px solid #FF5722;
                position: fixed;
                width: 1100px !important;
                top: 25% !important;
                left: 50% !important;
                margin-left: -550px;
                margin-top: -200px;
                height: 800px;
                overflow: scroll;
                overflow-x: hidden;
                overflow-y: scroll;
">
        <div ng-click="closeSubchassisParts()" class="btn btn-info btn-s" style="float:  left;">
            {{ Lang::get('labels.back') }}
            <i class="fa fa-arrow-left" aria-hidden="true" ></i>
        </div>
        <h3 class="dimmer-title">@{{ FormTitle }}</h3>
        <hr/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage" >
            <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
        </div>


        <div class="main">
            <div class="col-md-12 ">

                <div class="ui link items">
                    <div class="item" style="text-align: right;margin-bottom: 15px;background: #f4f4f4;padding: 10px;">
                        <div class="content">
                            <div class="header">{{Lang::get('labels.partNumber')}} :  @{{ partnumbers }}  </div>
                            <div class="description">
                                <p>{{Lang ::get('labels.stockRequest_rowNumber')}}  : @{{index+1}}</p>
                                <p>{{Lang::get('labels.Product_title')}} : @{{ ProductTitle }}     </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="Title_PartofChassis">
                   {{lang::get('labels.Title_PartofChassis')}}
                </div>

            </div>
            <div class="col-md-12 savedList">
                <i ng-show="showspinner" class="fa fa-spinner fa-spin" style="position: absolute;z-index: 1000;font-size: 40px;color: #5cb85b;background: #fff;border-radius: 100px;"></i>
                <div ng-repeat="saved in saved_SubchassisParts" class="saved_parts">
                    <div id="saved_list@{{SCP.id}}" class="Row col-md-12 Sub_Chassis_part" >
                        <div class="col-md-1 pull-right" >@{{saved.id }} </div>
                        <div class="col-md-3 pull-right">@{{saved.stkr_prodct_partnumber_commercial }}</div>
                        <div class="col-md-6 pull-right" style="height: auto;">@{{saved.stkr_prodct_title}}</div>
                        <div class="col-md-1 pull-right" >@{{ saved.ssr_d_qty }} </div>
                        <div class="col-md-1 pull-right" >
                            <i class="fa fa-trash gray " aria-hidden="true"  ng-click="deleteSubChassisItem(StockRequestID ,StockRequestRowID ,saved.stckreqstDtlRowID,chassisID ,saved.id,formType )"></i>
                        </div>
                    </div>
                </div>
                <div class="showEmptyListMessage" ng-show="showEmptyListMessage ==1">
                    {{Lang::get('labels.showEmptyListMessage')}}
                </div>
            </div>
            <div class="col-md-12 Sub_Chassis_part_List">

                <div ng-repeat="Sub_Chassis_part in SubChassispart"  class="">
                    {{--ng-if="Sub_Chassis_part.orderID == Sub_Chassis_order"--}}
                    <div ng-repeat="SCP in Sub_Chassis_part"  ng-if="SCP.id != saved_Subchassis_Parts.id "class="">
                        <div id="sub_row_list@{{SCP.id}}" class="Row col-md-12 Sub_Chassis_part" >
                            <div class="col-md-1 pull-right" >@{{SCP.products_id}} </div>
                            <div class="col-md-2 pull-right">@{{SCP.stkr_prodct_partnumber_commercial}}</div>
                            <div class="col-md-4 pull-right" >@{{SCP.stkr_prodct_title}}</div>
                            <div class="col-md-3 pull-right" ng-show="formType ==0 " >
                                <input ng-model="product_QTY"  ng-keypress="add_subchassis_to_list_by_Enter($event,StockRequestID,chassisID,StockRequestRowID,SCP.products_id,SCP.sps_available,formType)" id="product_QTY@{{SCP.products_id}}" max="@{{SCP.sps_available}}" min="1" type="number" style="width: 70px !important;" class="ng-pristine ng-valid-min ng-not-empty ng-invalid ng-invalid-max ng-touched">
                                /
                                @{{SCP.sps_available}}
                            </div>
                            <div class="col-md-3 pull-right" ng-show="formType ==1 ">
                                <input ng-model="product_QTY"  ng-keypress="add_subchassis_to_list_by_Enter($event,StockRequestID,chassisID,StockRequestRowID,SCP.products_id,SCP.sps_available,formType)" id="product_QTY@{{SCP.products_id}}"   min="1" type="number" style="width: 70px !important;" class="ng-pristine ng-valid-min ng-not-empty ng-invalid ng-invalid-max ng-touched">
                                /
                               ~
                            </div>

                            <div class="col-md-2 pull-right" >
                                <span class="btn btn-success btn-xs" ng-click="add_subchassis_to_list(StockRequestID,chassisID,StockRequestRowID,SCP.products_id,SCP.sps_available,formType) " >
                                    {{lang::get('Labels.add')}}
                                </span>
                                {{--<span class="btn btn-danger btn-xs" ng-click="hide_subchassis(Sub_Chassis_part[0].id)" >close</span>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <hr>

                <hr>
            </div>
        </div>
    </div>
</div>
@endsection