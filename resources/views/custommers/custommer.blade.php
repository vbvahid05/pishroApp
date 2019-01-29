@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection

@include('custommers.custommer_parts.section_custommer_edit')
@include('custommers.custommer_parts.section_Step1_customerPerson')
@include('custommers.custommer_parts.section_Step2_CustommerOrganization')
@include('custommers.custommer_parts.section_Step3_PersonInOrganization')
//----------------------------

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <h3 >{{ Lang::get('labels.custommer') }}</h3>
  <br/>
@can('customer_create', 1)

 <?php

    if (isset( $customer_info))
      {
?>
    @section('section_custommer_edit') @show


<?php
      }
      //##################################################################
      else
      {

    ?>
<form class="ui form" name="customer" >

     <?php //----------TOOLBAR------------------------------------------------?>
       <div class="toolbars well well-sm">
             <a class="btn btn-default btn-all-custommers"  href="{{ url('/all-custommers') }}" > <i class="fa fa-user-circle-o" aria-hidden="true"></i> {{ Lang::get('labels.AllCustommer') }} </a>
             <a class="backButton" href="{{ url('/all-custommers') }}" ><div class="btn btn-info btn-xs" >{{ Lang::get('labels.back') }}<i class="fa fa-arrow-left" aria-hidden="true"></i></div></a>
       </div>
     <?php //-------------------------------------------------------------------------?>

<div ng-app="custommerApp" ng-controller="custommerCtrl"  ng-init="PnewOrgName='John'">
<!-- Notifications-->
    <div  class="publicNotificationMessage">
        @{{ publicNotificationMessage }}
    </div>
<!-- Notifications-->
    <br/>
    <div class="ui two column grid">
      <div class="column" id="columnTitles">
        <div class="ui fluid vertical steps">
          <!-- Steps -->
            <div class="step active" id="customerPerson">
              <i class="fa fa-user-plus" aria-hidden="true"></i>
              <div class="content">
                <div class="title">{{ Lang::get('labels.customerPerson') }}</div>
                <div class="description">{{ Lang::get('labels.customerPersonDesc') }} </div>
              </div>
            </div>
            <div class="step " id="CustommerOrganization">
              <i class="fa fa-building" aria-hidden="true"></i>
              <div class="content">
                <div class="title">{{ Lang::get('labels.CustommerOrganization') }}</div>
                <div class="description">{{ Lang::get('labels.CustommerOrganizationDesc') }}</div>
              </div>
            </div>
            <div class="step" ng-click="LoaderPersonInOrganization()" id="PersonInOrganization" >
             <i class="fa fa-sitemap" aria-hidden="true"></i>
              <div class="content">
                <div class="title">{{ Lang::get('labels.PersonInOrganization') }}</div>
                <div class="description">{{ Lang::get('labels.PersonInOrganizationDesc') }}</div>
              </div>
            </div>
          <!-- Steps -->
        </div>
      </div>
      <div class="column" id="columnDetails">
        <div class="stepAction">
            @section('section_Step1_customerPerson') @show
            @section('section_Step2_CustommerOrganization') @show
            @section('section_Step3_PersonInOrganization') @show
          </div>
      </div>
</form>


</div> <!--Controller -->
      <?php

      }
  ?>
    @endcan
    @cannot('customer_create', 1)
        <div class="alert alert-danger">
            <i class="fa fa-ban" aria-hidden="true"></i>
            {{Lang::get('labels.Access_denied')}}
        </div>
    @endcannot
@endsection
