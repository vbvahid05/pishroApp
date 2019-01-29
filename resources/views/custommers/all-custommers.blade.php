@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection

@include('custommers.all_customers_Parts.section_allcustomers_filter')
@include('custommers.all_customers_Parts.section_allcustomers_list')
@include('custommers.all_customers_Parts.section_allcustomers_toolbars')
//----------------------------
<?php

//var_dump($val);
 ?>
<?php if ($val!='') {?>
@section('alerts')
  <div class="alert alert-success fade in alert-dismissable" style="display:  none;">@yield('showalerts','تمام مشتریان بارگذاری شد')</div>
  <div id="delete_msg" class="alert alert-warning fade in alert-dismissable" style="display:  none;">حذف شد</div>
@endsection
<?php }?>

@section('content')
        <div ng-app="AllcustommerApp" ng-controller="AllcustommerCtrl" >
            <h2 >
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            {{ Lang::get('labels.custommers') }}</h2>
            <br/>
     @can('customer_read', 1)
            <!-- TOOLBAR -->
            @can('customer_create', 1)
                @section('section_allcustomers_toolbars') @show
            @endcan
            <!-- TOOLBAR -->
            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
            <!-- Filters -->
            @section('section_allcustomers_filter') @show
              <!-- Filters -->
            <!-- custommer Table list -->
            @section('section_allcustomers_list') @show
            <!-- custommer Table list -->
            <div style="height:  80;"></div>
            <hr/>
        <!--  Containrt-->
        </div>
     @endcan
     @cannot('customer_read', 1)
            <div class="alert alert-danger">
                <i class="fa fa-ban" aria-hidden="true"></i>
                {{Lang::get('labels.Access_denied')}}
            </div>
     @endcannot

@endsection
