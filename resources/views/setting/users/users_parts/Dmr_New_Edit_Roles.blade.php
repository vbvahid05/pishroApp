@section('Dmr_New_Edit_Roles')
    <div ng-show="Dmr_New_Edit_Roles">

        <div class="ui segment" style="
                        border-top: 5px solid #3fadff;
                        position: fixed; top: 0em !important;
                        width:900px !important;
                        min-height: 400px !important;
                        top: 40% !important;
                        left: 50% !important;
                        margin-left: -450px; /* Negative half of width. */
                        margin-top: -200px; /* Negative half of height. */
">
            <div ng-click="closeEditDimmer()" class="btn btn-info btn-s" style="float:  left;">
                {{ Lang::get('labels.back') }}
                <i class="fa fa-arrow-left" aria-hidden="true" ></i>
            </div>
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>
            <hr/>
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" style="height: 50px;" >
                <i ng-show="showWaiting" class="waiting  fa fa-refresh fa-spin"></i>
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <div class="col-md-12">
                    <div  ng-repeat="AD in ActionsData" class="col-md-3 actionCheckBox pull-right" >
                        <label class="containerx">
                            <input type="checkbox"   ng-click="setAction(AD.id)"  lass="checkboxz" value="@{{AD.id}}"    ng-checked="AD.Selected == 1" >
                            <span class="checkmark"></span>
                            @{{AD.actionTitle}}
                        </label>
                </div>
                <div class="col-md-12">
                    <hr>
                     {{--<div class="btn btn-success" ng-click="saveRoleActionCheckList()">sad</div>--}}
                    <hr>
                </div>
          </div>
        </div>
    </div>
@endsection