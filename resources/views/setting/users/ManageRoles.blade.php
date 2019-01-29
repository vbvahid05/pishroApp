@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection

@include('setting.dimmer')

<!-- main Section -->
@section('content')
    <div ng-app="Setting_App" ng-controller="setting_Ctrl" >
        <br/>
        <h2 ><i class="fa fa-user" aria-hidden="true"></i>  {{ Lang::get('labels.userSetting') }}</h2>
        <br/>
        <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage"></div>

@can('adminCheck', 1)

<div class="row">
    <div class="col-md-6   pull-right"  >
        <div class="settingPanel ui middle aligned divided list" style="padding: 20px;">
                <h3>{{lang::get('labels.roles')}}</h3>
                <div class="item" ng-repeat="RD in RolesData">
                    <div class="right floated content" style="width: 140px !important;">
                        <div class="ui button fontIransans" ng-click="show(RD.id ,RD.role_title )">
                            {{Lang::get('labels.edit')}}
                        </div>
                        <div class="btn btn-danger" ng-click="delete_role(RD.id)" >
                            <i class="fa fa-trash-o" style="font-size: 19px;"></i>
                        </div>
                    </div>
                    <img class="ui avatar image" src="/img/avatar/matthew.png">
                    <div class="content" style="width: 150px !important;">
                        @{{ RD.role_title  }}
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-6   pull-right" style="text-align: center;" >
        <div class="settingPanelX" style="min-height: 290px;">
            <div ng-show="NewRole_box" style="padding-top: 50px">
                {{lang::get('labels.AddNewRole')}}
                <br/>
                <div ng-click="NewRole()" class="btn btn-primary btn-lg"> {{ lang::get('labels.AddNewRole') }} </div>
            </div>

            <div class="NewRole" ng-show="ShowNewRole">
                <h4 class="ui dividing header">{{ lang::get('labels.Role_Info') }}</h4>
                <form class="ui form">
                    <div class="two fields">
                        <div class="field">
                            <label>{{ lang::get('labels.Role') }}</label>
                            <div class="ui icon input">
                                <input ng-model="Role_name" type="text" placeholder="Role">
                                <i class="user icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>{{ lang::get('labels.Role_Info') }}</label>
                            <div class="ui icon input">
                                <input ng-model="Role_Slug" type="text">
                                <i class="lock icon" ></i>
                            </div>
                        </div>
                    </div>
                    <div class="btn btn-success" ng-click="Save_newRole()" >{{ lang::get('labels.save') }} </div>
                    <div class="btn btn-danger" ng-click="cancel_newRole()">{{ lang::get('labels.cancel') }}</div>
                </form>
            </div>
        </div>
    </div>

</div>
{{--=============================================================--}}
<div class="row">
      <div class="col-md-6  AllUsers pull-right"  >
          <div class="settingPanel AllUsers ">
              <i ng-show="showspinner_Loading" class="Wait_4_userList fa fa-spinner fa-spin "></i>
              <div class="row item Header" >
                  <div class="col-md-2 pull-right">{{ lang::get('labels.username') }}</div>
                  <div class="col-md-3 pull-right"> {{ lang::get('labels.title') }}  </div>
                  <div class="col-md-3 pull-right">{{ lang::get('labels.usernameID') }}  </div>
                  <div class="col-md-3  pull-right"> {{ lang::get('labels.accessrole') }} </div>
                  <div class="col-md-1  pull-right">   </div>
              </div>
              <div class="row item" ng-repeat="usr_rls in user_Roles">
                  <div class="col-md-2 pull-right">@{{usr_rls.userID}} @{{usr_rls.name}}</div>
                  <div class="col-md-3 pull-right">@{{usr_rls.ura_details}}</div>
                  <div class="col-md-3 pull-right">@{{usr_rls.email}}</div>
                  <div class="col-md-3 pull-right editRole " ng-click="show_user_role(usr_rls.ura_roleAction_id , usr_rls.ura_user_id, usr_rls.name,usr_rls.ura_details )">@{{usr_rls.role_title}}</div>
                  <div class="col-md-1 pull-right" style="padding: 0;" >
                      <i ng-click="set_user_delete(usr_rls.userRoleActionID,usr_rls.ura_details)" class="fa fa-trash gray" aria-hidden="true" style="font-size:  18px;padding:  4px;"></i>
                      <i ng-click="showPassFiealds(usr_rls.userID)" class="fa fa-key changepass"  n></i>
                  </div>
                  <div   id="editRow@{{usr_rls.userID}}" class="subrowz row col-md-12 hidden">
                      <form name="ChangePasswordFrom" ng-submit="changeUserPassword(ChangePasswordFrom.$valid)" >
                       <input type="password" id="PASsword@{{usr_rls.userID}}"    ng-model="PASsword"  class="form-control formSetting_input" placeholder="{{lang::get('labels.password')}}" required>
                       <input type="password" id="RePASsword@{{usr_rls.userID}}"  ng-model="RePASsword" ng-pattern="PASsword" class="form-control formSetting_input"  placeholder="{{lang::get('labels.Repassword')}}" required>
                          <button type="submit" class="btn btn-warning">{{lang::get('labels.save')}}</button>
                          <div ng-click="CancelChangePass()" class="btn btn-danger" >{{lang::get('labels.cancel')}} </div>
                      </form>
                      <hr>
                  </div>
              </div>
          </div>
      </div>

            <div class="col-md-6  pull-right"  style="text-align: center;">
                <div class="settingPanel" style="min-height: 300px">
                        <div ng-show="!NewUser_box" style="padding-top: 50px">
                            {{lang::get('labels.addNewUserToApp')}}
                            <br/>
                            <div ng-click="NewUser()" class="btn btn-success btn-lg"> {{ lang::get('labels.addNewUser') }} </div>
                        </div>

                        <div class="NewRole" ng-show="NewUser_box">

                            <form id="userForm" name="userForm"  class="ui form" ng-submit="Save_newUser(userForm.$valid)">
                                <div class="three fields">
                                    <div class="field">
                                        <label>{{ lang::get('labels.username') }}</label>
                                        <div class="ui icon input">
                                            <input name="username" ng-model="username" type="text" placeholder=" " required>
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>{{ lang::get('labels.usernameID') }}  ({{ lang::get('labels.email') }} )</label>
                                        <div class="ui icon input">
                                            <input name="usernameID"   ng-model="usernameID" type="email" required>
                                            <i class="icon-key"></i>
                                            <label ng-show="userForm.usernameID.$invalid && !userForm.usernameID.$pristine"  style="position: absolute;font-size: 10px;color: red;top: 35;left: 0;" >
                                                ایمیل را به صورت صحیح وارد نمایید
                                            </label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>{{ lang::get('labels.role') }}</label>
                                        <div class="ui icon input">
                                            <select ng-model="roleTitle" required>
                                                <option value="@{{ RD.id }}" ng-repeat="RD in RolesData" >@{{RD.role_title}} </option>
                                            </select>
                                            <i class="icon-key"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="two fields">
                                    <div class="field">
                                        <label>{{ lang::get('labels.password') }}</label>
                                        <div class="ui icon input">
                                            <input ng-model="password" type="password" placeholder=" " required>
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>{{ lang::get('labels.Repassword') }}</label>
                                        <div class="ui icon input">
                                            <input ng-model="Repassword" name="Repassword" type="password" ng-pattern="password" placeholder=" " required>
                                            <div ng-show="userForm.Repassword.$invalid && !userForm.Repassword.$pristine"  style="position: absolute;top: 35px;font-size: 10px;left: 0;color: red;">
                                                 {{  lang::get('labels.rePassNotValid')  }}
                                            </div>
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                </div>
                                @{{ $error }}
                                <button  class="btn btn-success"  type="submit">{{ lang::get('labels.save') }} </button>
                                <div class="btn btn-danger" ng-click="cancel_newUser()">{{ lang::get('labels.cancel') }}</div>
                            </form>
                    </div>

                </div>
            </div>
</div>

        @section('section_dimmerPage') @show;
    </div>

@endcan
    @cannot('adminCheck', 1)
        <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
    @endcannot
@endsection



