@section('section_ProductsTable')

    <?php
//    var_dump($AllProducts);
    ?>
<div class="TableContainer">

    <table   class="allcustomertable table table-hover " >
      <tr>
          <th><input type="checkbox" ng-model="confirmed" ng-change="checkall(0)" id="checkall0" /></th>
          <th style="width:  300px;">{{ Lang::get('labels.Product_PartNumber_comersial') }} </th>
          <th style="width: 60% !important;">{{ Lang::get('labels.Product_title') }} </th>
          <th>{{ Lang::get('labels.Product_brand') }}  </th>
          <th>{{ Lang::get('labels.Product_type') }} </th>
          <th>{{ Lang::get('labels.Product_type_cat') }} </th>
      </tr>

        @foreach ($AllProducts as $product  )
            <tr id="row{{ $product->productID }}">
                <td ><input type="checkbox" class="checkbox" name="itemIdList" value="{{ $product->productID }}"></td>
                <td style="direction:  ltr;text-align:  right;">
                    {{$product->stkr_prodct_partnumber_commercial}}
                    <br/>
                        <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                            @can('product_update', 1)
                            <span class="edit">
                            <span class="editBtn"  ng-click="editProduct({{ $product->productID }})" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span> |
                            </span>
                            @endcan

                            @can('product_delete', 1)
                            <span class="trash"> <span  class="submitdelete"  ng-click="moveToTrash({{ $product->productID }})" >{{ Lang::get('labels.moveToTrash') }}</span>
                            </span>
                            @endcan
                            <span class="view"><a href="#" rel="bookmark" ></a>  </span>
                        </div>
                        <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                            <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash({{ $product->productID }})" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                            <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase({{ $product->productID }})" >{{ Lang::get('labels.fulldelete') }}</span></span>
                            <span class="view"><a href="#" rel="bookmark"> </a>  </span>
                        </div>
                </td>
                <td class="ltrdir">  {{$product->stkr_prodct_title }} </td>
                <td> {{$product->stkr_prodct_brand_title }} </td>
                <td> {{$product->stkr_prodct_type_title }} </td>
                <td><?php switch ($product->stkr_prodct_type_cat)
                    {
                        case 1: echo lang::get('labels.Product_type_part');  break;
                        case 2: echo lang::get('labels.Product_type_partOfChassiss');  break;
                        case 3: echo lang::get('labels.Product_type_chassis');  break;
                    }
                    ?>   </td>
            </tr>
        @endforeach


    </table>
  </div>

  <!-- pagination -->
    <div  class="pagination" style="float:  right;">
        <?php echo $AllProducts->appends(['searchBox' =>  Request::get('searchBox') ] )->render(); ?>
    </div>



  <!-- pagination -->
  <div style="height:  80;"></div>
  <hr/>

@endsection
