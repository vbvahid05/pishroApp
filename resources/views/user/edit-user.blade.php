@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection
<!-- Parts -->
@include('user.editUser_parts.section_filter')
@include('user.editUser_parts.section_toolbars')
{{-----------------------------------------------------}}

@section('content')
<div ng-app="userSetting_App" ng-controller="userSetting_Ctrl" >
    <br/> <h2 ><i class="fa fa-key" aria-hidden="true"></i>  {{ Lang::get('labels.ChangePassword') }}</h2><br/>
    <!-- TOOLBAR -->
    {{--@section('section_toolbars') @show--}}
    <!-- Filters-->
    {{--@section('section_filter') @show<p></p>--}}
<!-- Notifications-->
    <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
<hr>
    <div class="ui equal width form">
        <form id="chngPas"   name="chngPas" ng-submit="changeUserPassword(chngPas.$valid)">

        <div class="fields">
            <div class="field">
                <label>{{lang::get('labels.password')}}</label>
                <input  ng-model="paswrd"   type="password" required>
            </div>
            <div class="field">
                <label> {{ lang::get('labels.Repassword') }}</label>
                <input ng-model="rePaswrd" ng-pattern="paswrd" type="password" required>
                <div ng-show="chngPas.rePaswrd.$invalid && !chngPas.rePaswrd.$pristine"  style="font-size: 10px;color: red;">
                   {{  lang::get('labels.rePassNotValid')  }}
                </div>
            </div>
            <div class="field">
                <label> &nbsp;	</label>
                <button type="submit" class="btn btn-success"> {{ lang::get('labels.ChangePassword') }} </button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection