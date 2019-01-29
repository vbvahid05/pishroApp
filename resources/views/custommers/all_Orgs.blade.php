
@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection

@include('custommers.all_org_Parts.section_filter')
@include('custommers.all_org_Parts.section_list')
@include('custommers.all_org_Parts.section_toolbars')
@include('custommers.all_org_Parts.section_dimmerPage')

@section('content')

    <div ng-app="AllOrgApp" ng-controller="AllOrgCtrl" >
        <br/>
        <h2 >
            <i class="fa fa-building" aria-hidden="true"></i>
            {{ Lang::get('labels.AllOrgs') }}
        </h2>
        <br/>
    @can('customer_read', 1)

    <!-- TOOLBAR -->
         @can('customer_create', 1)
            @section('section_toolbars') @show
         @endcan
    <!-- TOOLBAR -->
    <!-- Notifications-->
        <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    <!-- Filters -->
        @section('section_filter') @show
    <!-- Filters -->
    <!-- custommer Table list -->.
        @section('section_list') @show
    <!-- custommer Table list -->
    <div style="height:  80;"></div>
        <!--  Containrt-->

    @section('section_dimmerPage') @show
    @endcan
    @cannot('customer_read', 1)
        <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
    @endcannot
    </div>
@endsection
