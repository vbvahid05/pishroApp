@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection
<!-- Parts -->
@include('sell.view_warranty.allRecord_parts.section_toolbars')
@include('sell.view_warranty.allRecord_parts.section_filter')
@include('sell.view_warranty.allRecord_parts.section_list')

@include('sell.view_warranty.single_parts.section_dimmerPage')

<!-- main Section -->
@section('content')
  <div ng-app="Sell_warranty_App" ng-controller="Sell_warranty_Ctrl" >
      <br/>
        <h2 ><i class="fa fa-paper-plane-o" aria-hidden="true"></i>  {{ Lang::get('labels.outStock') }}</h2>
      <br/>
    <!-- TOOLBAR -->



  @can('TakeOutProducts_read', 1)
    @section('section_toolbars') @show
    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    <!-- Filters-->
      @section('section_filter') @show<p></p>
    <!-- List Table-->

      <input id="pageType" type="hidden" value="{{ $pageType }}">
      @section('section_list') @show
  @endcan
  @cannot('TakeOutProducts_read', 1)
      <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
  @endcannot

<?php
/*
  @foreach ($ordersx as $ord)
   {{$ord->stk_ordrs_id_code}} /{{ $ord->seller->stkr_ordrs_slr_name}}// {{ $ord->status->stkr_ordrs_stus_title}} <br/>
  @endforeach
  */
  ?>

 
      @section('section_dimmerPage') @show






  </div> <!-- Controller-->
@endsection
