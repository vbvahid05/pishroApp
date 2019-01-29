@section('section_new_edit')
    <div ng-show="section_new_edit_Organization_in_Dimmer">

        <div   class="ui segment" style="position: absolute !important;top: 40%; left: 50%;min-height:600px ;width: 1200px!important;margin-left:-600px;margin-top: -300px; border-top: 4px solid #0bdb08;">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>
            <hr/>
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <form class="ui form">

                    <div class="ui large form segment">

                        <div class="fields">
                            <div class="nine   wide field">
                                <label class="RequirementField"> {{lang::get('labels.organization_name')}} </label>
                                <input ng-model="organization_name" placeholder="{{lang::get('labels.organization_name')}}" type="text" style="width:  100% !important;">
                            </div>
                            <div class="seven wide field">
                                <label> {{lang::get('labels.codeghtesadi')}}</label>
                                <input ng-model="codeghtesadi" placeholder="{{lang::get('labels.codeghtesadi')}}" type="number" style="width:  100% !important;">
                            </div>
                        </div>
                        <h4 class="ui dividing header" style="text-align:  right;">
                            <i class="fa fa-address-book-o" aria-hidden="true" ></i>
                            {{lang::get('labels.ContactInformation')}}
                        </h4>
                        <div class="fields">
                            <div class="six wide field">
                                <label class="RequirementField">{{lang::get('labels.tel')}} </label>
                                <input ng-model="tel" type="number" >
                            </div>
                            <div class="three wide field">
                                <label>{{lang::get('labels.postalcode')}}  </label>
                                <input  ng-model="postalcode" type="number"   style="width: 100% !important;">
                            </div>
                            <div class="seven wide field">
                                <label>{{lang::get('labels.address')}}  </label>
                                <textarea  ng-model="address" name="Text1" cols="40" rows="5"></textarea>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div>
                <button ng-click="editORGinfo(org_id)" ng-show="editORGinfoBTN" class="btn btn-success">{{ Lang::get('labels.update')  }}</button>
                <button ng-click="editORGinfo(0)" ng-show="newORGinfoBTN" class="btn btn-success">{{ Lang::get('labels.save')  }}</button>
                <button ng-click="close_dimmer()" class="btn btn-danger">{{ Lang::get('labels.cancel')  }}</button>
            </div>
        </div>
    </div>
@endsection
