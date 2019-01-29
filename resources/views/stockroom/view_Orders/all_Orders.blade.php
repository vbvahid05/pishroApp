@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection
<!-- Parts -->
@include('stockroom.view_Orders.allOrder_parts.section_toolbars')
@include('stockroom.view_Orders.allOrder_parts.section_filter')
@include('stockroom.view_Orders.allOrder_parts.section_list')

@include('stockroom.view_Orders.order_parts.section_dimmerPage')
@include('stockroom.view_Orders.order_parts.1__section_add_new_order')



<!-- main Section -->
@section('content')
  <div ng-app="StackRoom_Orders_App" ng-controller="StackRoom_Orders_Ctrl" >
      <br/>
        <h2 ><i class="fa fa-cart-plus" aria-hidden="true"></i>{{ Lang::get('labels.allOrders') }}</h2>
      <br/>
    <!-- TOOLBAR -->
  @can('order_create', 1)
  @section('section_toolbars') @show
  @endcan

    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
      @can('order_read', 1)
          <!-- Filters-->
          @section('section_filter') @show<p></p>
        <!-- List Table-->
          @section('section_list') @show
      @endcan
      @cannot('order_read', 1)
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
