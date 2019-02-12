@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection

  @include('stockroom.view_products.allproducts_Parts.section_ProductsTable')
  @include('stockroom.view_products.allproducts_Parts.section_Toolbar')
  @include('stockroom.view_products.allproducts_Parts.section_Filters')
  @include('stockroom.view_products.allproducts_Parts.section_edit_product')

  @include('stockroom.view_products.brans_Parts.section_All_brands')
  @include('stockroom.view_products.brans_Parts.section_brands_toolbars')

  @include('stockroom.view_products.typeOfProducts_parts.section_type_list')
  @include('stockroom.view_products.typeOfProducts_parts.section_type_filter')
  @include('stockroom.view_products.typeOfProducts_parts.section_type_toolbars')



@section('content')
<div ng-app="productsApp" ng-controller="productsCtrl" >
  <meta name="csrf-token" content="{{ csrf_token() }}" />
      <h2 >
        <i class="fa fa-tags" aria-hidden="true"></i>
         {{ Lang::get('labels.newProduct') }}
      </h2>
      <br/>
    <!-- Tab Handler Titles -->
       <div class="ui tabular menu">
         <div class="item active" data-tab="tab-home" ng-click="ShowAllProducts()"> {{ Lang::get('labels.ProductList') }}</div>
         <div class="item" data-tab="tab-name" ng-click="LoadBrandData()">  {{ Lang::get('labels.Product_brands') }}</div>
         <div class="item" data-tab="tab-types" ng-click="All_productTypes_OnLoadPage()"> {{ Lang::get('labels.Product_types') }}</div>
      </div>
  <!--- ################################## Tab1 ########################################------>
    <div class="ui tab active" data-tab="tab-home">
          <!-- TOOLBAR -->
            @can('product_create', 1)
                @section('section_toolbar') @show
            @endcan
          <!-- TOOLBAR -->
          <!-- Notifications-->
          <div id="publicNotificationMessage" class="">
              @{{ publicNotificationMessage }}
          </div>
         @can('product_read', 1)
          <!-- Filters-->
            @section('section_Filters') @show
          <!-- Filters-->
          <p></p>
         <!-- Product Table +Pagination -->
           @section('section_ProductsTable') @show
         @endcan
        @cannot('product_read', 1)
            <div class="alert alert-danger"><i class="fa fa-ban" aria-hidden="true"></i>{{Lang::get('labels.Access_denied')}}</div>
        @endcannot
         <!-- Product Table -->
          @section('section_Edit_product') @show
    </div>

  <!--- ################################## Tab 2 ########################################------>
    <div class="ui tab" data-tab="tab-name">
<!-- TOOLBAR -->
        @can('product_create', 1)
            @section('section_brands_toolbars') @show
        @endcan
<!--Notification  -->
          <div class="publicNotificationMessage" class="">
              @{{ publicNotificationMessage }}
          </div>
<!-- Filters-->
            @section('section_Filters') @show
            <br/>
<!-- Table -->
            @section('section_All_brands') @show
    </div>
<!--- ################################## Tab 2 ########################################------>
    <div class="ui tab " data-tab="tab-types">
        <!-- TOOLBAR -->
    @can('product_create', 1)
          @section('section_type_toolbars') @show
    @endcan
        <!-- TOOLBAR -->
        <!--Notification  -->
        <div class="publicNotificationMessage" >
            @{{ publicNotificationMessage }}
        </div>
        <!-- Filters-->
          @section('section_type_filter') @show
        <!-- Filters-->
        <p></p>
        <!-- Product Type Table +Pagination -->
          @section('section_type_list') @show
        <!-- New/Edit Product Table -->
          @section('section_type_add_edit') @show
    </div>



 


</div> <!-- Controller  -->

@endsection
