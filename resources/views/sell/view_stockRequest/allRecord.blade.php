@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection
<!-- Parts -->
@include('sell.view_stockRequest.allRecord_parts.section_toolbars')
@include('sell.view_stockRequest.allRecord_parts.section_filter')
@include('sell.view_stockRequest.allRecord_parts.section_list')
@include('sell.view_stockRequest.stockRequest_parts.section_dimmerPage')

<!-- main Section -->
@section('content')
  <div ng-app="Sell_ProductStatusReport_App" ng-controller="Sell_ProductStatusReport_Ctrl" >
      <br/>
        <h2 ><i class="fa fa-cubes" aria-hidden="true"></i> {{ Lang::get('labels.stockRequest') }}</h2>
      <br/>
  @can('stockRequest_read', 1)

      <!-- TOOLBAR -->
      @section('section_toolbars') @show
    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    <!-- Filters-->
      @section('section_filter') @show<p></p>
    <!-- List Table-->
      @section('section_list') @show
@endcan
@cannot('stockRequest_read', 1)
     <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
@endcannot
<?php
/*
  @foreach ($ordersx as $ord)
   {{$ord->stk_ordrs_id_code}} /{{ $ord->seller->stkr_ordrs_slr_name}}// {{ $ord->status->stkr_ordrs_stus_title}} <br/>
  @endforeach
  */
  ?>

  <div  id="dimmerx"   class="ui page dimmer">
    <div class="content">
      <div class="center">
        <div class="ui text container">
            <div class="ui segments">
              <div class="ui segment" style="height:  300px;">Content  </div>
            </div>
        </div>
      </div>
    </div>
  </div>
      @section('section_dimmerPage') @show






  </div> <!-- Controller-->
@endsection
