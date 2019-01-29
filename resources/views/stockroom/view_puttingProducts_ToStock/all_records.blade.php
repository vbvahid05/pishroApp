@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection
<!-- Parts -->
@include('stockroom.view_puttingProducts_ToStock.all_parts.section_toolbars')
@include('stockroom.view_puttingProducts_ToStock.all_parts.section_filter')
@include('stockroom.view_puttingProducts_ToStock.all_parts.section_list')

@include('stockroom.view_puttingProducts_ToStock.page_parts.section_dimmerPage')


<!-- main Section -->
@section('content')
  <div ng-app="StackRoom_Putting_App" ng-controller="StackRoom_Putting_Ctrl" >
      <br/>
        <h2 ><i class="fa fa-level-down" aria-hidden="true"></i>{{ Lang::get('labels.addtoStock') }}</h2>
      <br/>
     @can('PuttingProduct_read', 1)
    <!-- TOOLBAR -->
      @section('section_toolbars') @show      
    <!-- Notifications-->
      <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    <!-- Filters-->
      @section('section_filter') @show<p></p>
    <!-- List Table-->

            @section('section_list') @show
      @endcan
      @cannot('PuttingProduct_read', 1)
          <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
      @endcannot
      @section('section_dimmerPage') @show

  </div> <!-- Controller-->
@endsection
