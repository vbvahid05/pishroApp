
@extends('layouts.theme')
@section('title', 'Page Title')
@section('sidebar') @endsection


//----------------------------

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>asdsad</li>
            <li>@{{ $part_numberError }}</li>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div ng-app="productsApp" ng-controller="productsCtrl" >
      <h2 class="PageTitle">
        <?php if ($getId=='new') { ?> <i class="fa fa-tags" aria-hidden="true"></i> {{ Lang::get('labels.AddNewProduct') }} <?php }
              else{ ?> {{ Lang::get('labels.EditProduct') }}  <?php } ?></h2>
      <br/>


<!-- New || edit product form  -->
    <form   <?php if ($getId=='new') echo  'ng-submit="addProductToDB()"'; else echo 'ng-submit="updateProductDB()" ' ?>  class="ui form" >
      {{ csrf_field() }}
        <!-- TOOLBAR -->

        <div class="toolbars well well-sm"  data-ng-init="onloadProductPage()">
                <?php if ($getId=='new')
                { ?>
                    <button   class="btn btn-default  " type="submit"> <i class="fa fa-pencil" aria-hidden="true"></i>  {{ Lang::get('labels.save') }} </button>
          <?php } else
                { ?>
                  <button   class="btn btn-default  " type="submit"> <i class="fa fa-pencil" aria-hidden="true"></i>  {{ Lang::get('labels.apply') }} </button>
                  <a href="{{ url('/stock/product/new') }}" >
                    <div class="btn btn-default" >
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        {{ Lang::get('labels.AddNewProduct') }}
                    </div>
                  </a>
                  <?php
                  foreach ($product as $prdc){  }

                }
                 ?>
                  <!-- Back-->
                 <a class="backButton" href="{{ url('/stock/allproducts') }}" ><div class="btn btn-info btn-xs" >{{ Lang::get('labels.back') }}<i class="fa fa-arrow-left" aria-hidden="true"></i></div></a>
        </div>
        <!-- TOOLBAR -->
          <!-- Notifications-->
          <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
        <!-- Data Table -->

          <div class="ui blue segment">

                <table class="form-table">
                  <tbody>
                    <tr>
                      <th><label for="inpt_Product_brand">{{ Lang::get('labels.Product_brand') }} </label></th>
                      <td>
                        <div class="ui container"    data-live-search="true" data-selected-text-format="values" >
                              <select  ng-model="selectedItem" ng-change="updateTypeList()" id="inpr_Product_brand"  name="inpr_Product_brand" class=" ui search selection dropdown ng-pristine ng-valid ng-not-empty ng-touched search-select "  >
                                <option  ng-repeat="brand in AllBrands"  value="@{{brand.id}}" > @{{brand.stkr_prodct_brand_title}} </option>
                              </select>
                        </div>
                        <br/>
                    </tr>


                    <tr>
                      <th><label for="inpt_Product_type">{{ Lang::get('labels.Product_type') }} </label></th>
                      <td>


                        <div class="ui container Product_Type"    data-live-search="true" data-selected-text-format="values" >
                              <select id="inpr_Product_Type"  name="inpr_Product_Type" class="ui search selection dropdown ng-pristine ng-valid ng-not-empty ng-touched search-select "  >
                                <option  ng-repeat="Type in AllTypes" value="@{{Type.id}}" > @{{Type.stkr_prodct_type_title}} </option>
                              </select>
                        </div>
                        <br/>

                      </td>
                    </tr>
                    <tr>
                        <th><label for="inpt_Product_type">{{ Lang::get('labels.Product_type_cat') }} </label></th>
                      <td>


                          <div class="grouped fields">
                            <div class="two field">

                              <div class="field">
                                <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_part') }} </label>
                                <input class="Product_type_radio ui slider checkbox" type="radio" name="status" value="1" ng-model="formData.Product_type_cat">
                              </div>
                              <div class="field">
                                <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_partOfChassiss') }} </label>
                                <input class="Product_type_radio  ui slider checkbox" type="radio" name="status" value="2" ng-model="formData.Product_type_cat">
                              </div>
                              <div class="field">
                                <label class="Product_type_radio_label">{{ Lang::get('labels.Product_type_chassis') }} </label>
                                <input class="Product_type_radio  ui slider checkbox" type="radio" name="status" value="3" ng-model="formData.Product_type_cat">
                              </div>
                            </div>
                          </div>

                      </td>

                    </tr>
                    <tr>
                      <td> </td>
                      <td>
                        <hr>
                          <div class="ui checkbox">
                             <input ng-model="inpt_rodu" id="inpt_rodu" type="checkbox"  value="1" > {{ Lang::get('labels.Product_with_two_serial') }}<br>
                          </div>
                        <hr>
                      </td>
                    </tr>
                    <tr>
                      <th><label for="inpt_roduct_PartNumber_comersial" class="RequirementField">{{ Lang::get('labels.Product_PartNumber_comersial') }} </label></th>
                      <td><input type="text" ng-model="inpt_roduct_PartNumber_comersial" name="inpt_roduct_PartNumber_comersial" id="inpt_roduct_PartNumber_comersial" value="@if($getId !='new') @{{prdc.stkr_prodct_partnumber_commercial}} @endif "  class="form-control" style="direction:  ltr;"></td>
                    </tr>
                    <tr>
                      <th><label for="inpt_Product_title">{{ Lang::get('labels.Product_title') }} </label></th>
                      <td>
                        <br/>
                        <input type="text" ng-model="inpt_Product_title" name="inpt_Product_title" id="inpt_Product_title" value="@if($getId !='new') {{$prdc->stkr_prodct_title}} @endif "  class="form-control"></td>
                    </tr>

                    <tr>
                        <th><label>{{Lang::get('labels.tadbir_stock_id')}} </label></th>
                        <td>
                            <br/>
                            <input   ng-model="inpt_tadbir_stock_id" id="inpt_tadbir_stock_id">
                        </td>
                    </tr>

                    <tr>
                        <th><label>{{Lang::get('labels.invoice_Unit_price')}} EPL</label></th>
                        <td>
                            <br/>
                            <input type="number" ng-model="inpt_Price" id="inpt_Price">
                            {{Lang::get('labels.$')}}
                        </td>
                    </tr>


                  </tbody>
                </table>
          </div>

          <!-- Data Table -->
  </form>




  <div ng-show="loading" class="Loading">
    <img src="/img/loading.gif" />
    <div class="LoadingBack" ></div>
  </div>


<!-- Controller -->
</div>

















@endsection
