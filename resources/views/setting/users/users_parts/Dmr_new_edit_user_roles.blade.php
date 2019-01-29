@section('Dmr_new_edit_user_roles')
    <div ng-show="Dmr_new_edit_user_roles">

        <div class="ui segment" style="
                        border-top: 5px solid #eaff00;
                        position: fixed; top: 0em !important;
                        width:500px !important;
                        min-height: 400px !important;
                        top: 40% !important;
                        left: 50% !important;
                        margin-left: -250px; /* Negative half of width. */
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
                    {{--@{{ showUserRole_id }}--}}
                    <div class="col-md-4 pull-right">@{{ userName }}</div>
                    <div class="col-md-8" >
                        <input ng-model="customeroleTitle" type="text" value="@{{ customeroleTitle }}" style="width: 100% !important;border-radius: 5px;height: 35px;padding-right: 10px;">
                   </div>

                    {{--<table border="1">--}}
                  {{--<tr ng-repeat="RoList in roleList">--}}
                     {{--<input type="radio" ng-model="selected2" ng-value="'@{{RoList.id}}'">@{{ RoList.role_title }}--}}
                      {{--<td>s--}}
                          {{--<input type="radio" name="selected2" ng-model="selected2" ng-value="@{{RoList.id}}" value="@{{RoList.id}} " style="width: 100% !important;">--}}
                      {{--</td>--}}
                      {{--<td >--}}
                          {{--@{{ RoList.role_title }}--}}
                      {{--</td>--}}
                  {{--</tr>--}}
                    {{--</table>--}}



                        <div ng-repeat="RoList in roleList" class="funkyradio">
                            <div class="funkyradio-success">
                                {{--<input type="radio" name="radio"  checked/>--}}
                                <input  type="radio" name="selected2" ng-model="selected2" ng-value="@{{RoList.id}}" value="@{{RoList.id}} " id="radio@{{$index}}"  style="width: 100% !important;">
                                <label for="radio@{{$index}}">@{{ RoList.role_title }}</label>
                            </div>
                        </div>


                </div>

                {{--<div  class="ui form ">--}}
                    {{--<div class="grouped fields">--}}
                        {{--<label>Outbound Throughput</label>--}}
                        {{--<div class="field">--}}

                            {{--<div class="ui slider checkbox" ng-repeat="RoList in roleList">--}}
                                {{--<input type="radio" name="selected2" ng-model="selected2" ng-value="@{{$index}}" value="@{{$index}}"> @{{ $index }}--}}
                                {{--<label>20 mbps max</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<input type="radio" ng-model="selected2" ng-value="'1'"> 1--}}
                {{--<input type="radio" ng-model="selected2" ng-value="'2'"> 2--}}
                {{--<input type="radio" ng-model="selected2" ng-value="'3'"> 3--}}

                <div class="btn btn-success" ng-click="selectss()" >
                    {{lang::get('labels.save')}}
                </div>


                {{--<div class="funkyradio">--}}
                    {{--<div class="funkyradio-default">--}}
                        {{--<input type="radio" name="radio" id="radio1" />--}}
                        {{--<label for="radio1">First Option default</label>--}}
                    {{--</div>--}}
                    {{--<div class="funkyradio-primary">--}}
                        {{--<input type="radio" name="radio" id="radio2" checked/>--}}
                        {{--<label for="radio2">Second Option primary</label>--}}
                    {{--</div>--}}
                    {{--<div class="funkyradio-success">--}}
                        {{--<input type="radio" name="radio" id="radio3" />--}}
                        {{--<label for="radio3">Third Option success</label>--}}
                    {{--</div>--}}
                    {{--<div class="funkyradio-danger">--}}
                        {{--<input type="radio" name="radio" id="radio4" />--}}
                        {{--<label for="radio4">Fourth Option danger</label>--}}
                    {{--</div>--}}
                    {{--<div class="funkyradio-warning">--}}
                        {{--<input type="radio" name="radio" id="radio5" />--}}
                        {{--<label for="radio5">Fifth Option warning</label>--}}
                    {{--</div>--}}
                    {{--<div class="funkyradio-info">--}}
                        {{--<input type="radio" name="radio" id="radio6" />--}}
                        {{--<label for="radio6">Sixth Option info</label>--}}
                    {{--</div>--}}
                {{--</div>--}}



            </div>
        </div>
    </div>
@endsection