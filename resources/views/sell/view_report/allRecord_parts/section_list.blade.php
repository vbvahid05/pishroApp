@section('section_list')
<div class="TableContainer">

<div class="container">
    <div class="publicTable  Moveable_header " style="background: #d4d4d4;width: 90%;text-align: center;">
        <div style="width: 3%;float: right;">#</div>
        <div style="width: 5%;float: right;">{{ Lang::get('labels.Product_brand') }}  </div>
        <div style="width: 6%;float: right;">{{ Lang::get('labels.Product_type') }}</div>
        <div style="width: 4%;float: right;">{{ Lang::get('labels.Product_type_cat') }}</div>
        <div class="titleWith" style="float: right;">{{ Lang::get('labels.Product_title') }}</div>
        <div class="PartNumberWith" style="float: right;">{{ Lang::get('labels.Product_PartNumber_comersial') }}</div>

        <div class="blueBack" style="width: 4%;float: right;">{{ Lang::get('labels.status1') }}</div>
        <div class="blueBack"style="width: 4%;float: right;">{{ Lang::get('labels.status2') }} </div>
        <div class="blueBack"style="width: 4%;float: right;">{{ Lang::get('labels.status3') }}</div>
        <div class="blueBack"style="width: 4%;float: right;">{{ Lang::get('labels.status5') }}</div>
        <div  class="blueBack tarkhisWith" style="width: 3%;float: right;">{{ Lang::get('labels.status4') }} </div>

        <div class="INsumWith" style="float: right;">{{ Lang::get('labels.INsum') }}</div>

        <div class="greenBack" style="width: 4%;float: right;">{{ Lang::get('labels.status2_2') }} </div>
        <div class="greenBack" style="width: 3%;float: right;">{{ Lang::get('labels.status2_3') }}</div>
        <div class="greenBack" style="width: 4%;float: right;">{{ Lang::get('labels.status2_4') }} </div>
        <div class="greenBack mojudiAnbarWith" style="width: 4%;float: right;">{{ Lang::get('labels.status2_5') }} </div>
        <div class="greenBack" style="width: 4%;float: right;">{{ Lang::get('labels.status2_1') }}</div>

        <div style="width: 5%;float: right;">{{ Lang::get('labels.AvailableStock') }}</div>
    </div>



    {{--<table class="publicTable  Moveable_header " style="background:  cadetblue;">--}}
        {{--<tbody>--}}
        {{--<tr>--}}
            {{--<th style="width: 0.01% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" style="width: 200px !important;" /></th>--}}

            {{--<th style="width:0.2%;text-align:  center;" >{{ Lang::get('labels.Product_brand') }} </th>--}}
            {{--<th style="width:0.2%;text-align:  center;" >{{ Lang::get('labels.Product_type') }} </th>--}}
            {{--<th style="width:0.2%;" >{{ Lang::get('labels.Product_type_cat') }} </th>--}}

            {{--<th style="width:1%;text-align: center;" >{{ Lang::get('labels.Product_title') }} </th>--}}
            {{--<th style="width:0.15%;" >{{ Lang::get('labels.Product_PartNumber_comersial') }} </th>--}}

            {{--<!-- -->--}}
            {{--<th class="groupA" style="width:0.01%;border-right: 1px dashed #9fc5e2;" >{{ Lang::get('labels.status1') }} </th>--}}
            {{--<th class="groupA" style="width:0.1%;text-align:  center;" >{{ Lang::get('labels.status2') }} </th>--}}
            {{--<th class="groupA" style="width:0.1%;padding-left:  5px;" >{{ Lang::get('labels.status3') }} </th>--}}
            {{--<th class="groupA" style="width:0.1%;" >{{ Lang::get('labels.status5') }} </th>--}}
            {{--<th class="groupA" style="width:0.1%;border-left: 1px dashed #9fc5e2;" >{{ Lang::get('labels.status4') }} </th>--}}
            {{--<th style="width:0.1%;" >{{ Lang::get('labels.INsum') }} </th>--}}
            {{--<!-- -->--}}
            {{--<th class="groupB" style="width:0.02%;border-right: 1px dashed #78ca84;" >{{ Lang::get('labels.status2_2') }} </th>--}}
            {{--<th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_3') }} </th>--}}
            {{--<th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_4') }} </th>--}}
            {{--<th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_5') }} </th>--}}
            {{--<th class="groupB" style="width:0.1%;border-left: 1px dashed #78ca84;" >{{ Lang::get('labels.status2_1') }} </th>--}}
            {{--<th style="width:0.001%;" >  </th>--}}
            {{--<!-- -->--}}
            {{--<th class="groupC" style="width:0.38%;" >{{ Lang::get('labels.AvailableStock') }} </th>--}}
        {{--</tr>--}}

        {{--</tbody>--}}
    {{--</table>--}}
</div>

    <table class="publicTable reportTable table table-hover " >
      <tr>
          <th style="width: 0.1% !important;"><input type="checkbox" ng-model="confirmed" ng-change="checkall(2)" id="checkall2" /></th>

          <th style="width:0.2%;" >{{ Lang::get('labels.Product_brand') }} </th>
          <th style="width:0.2%;" >{{ Lang::get('labels.Product_type') }} </th>
          <th style="width:0.2%;" >{{ Lang::get('labels.Product_type_cat') }} </th>

          <th style="width:1.5%;" >{{ Lang::get('labels.Product_title') }} </th>
          <th style="width:0.3%;" >{{ Lang::get('labels.Product_PartNumber_comersial') }} </th>

<!-- -->
          <th class="groupA" style="width:0.1%;border-right: 1px dashed #9fc5e2;" >{{ Lang::get('labels.status1') }} </th>
          <th class="groupA" style="width:0.1%;" >{{ Lang::get('labels.status2') }} </th>
          <th class="groupA" style="width:0.1%;" >{{ Lang::get('labels.status3') }} </th>
          <th class="groupA" style="width:0.1%;" >{{ Lang::get('labels.status5') }} </th>
          <th class="groupA" style="width:0.1%;border-left: 1px dashed #9fc5e2;" >{{ Lang::get('labels.status4') }} </th>
          <th style="width:0.1%;" >{{ Lang::get('labels.INsum') }} </th>
<!-- -->
          <th class="groupB" style="width:0.1%;border-right: 1px dashed #78ca84;" >{{ Lang::get('labels.status2_2') }} </th>
          <th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_3') }} </th>
          <th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_4') }} </th>
          <th class="groupB" style="width:0.1%;" >{{ Lang::get('labels.status2_5') }} </th>
          <th class="groupB" style="width:0.1%;border-left: 1px dashed #78ca84;" >{{ Lang::get('labels.status2_1') }} </th>
          <th style="width:0.1%;" >  </th>
<!-- -->
          <th class="groupC" style="width:0.1%;" >{{ Lang::get('labels.AvailableStock') }} </th>

      </tr>
      <tr ng-repeat="row in allRows
                    | startFrom: pagination.page * pagination.perPage
                    | limitTo: pagination.perPage
                    | filter:search |filter:value_1|filter:value_2|filter:value_3
                    | orderBy: orderList
                    "
                    id="row@{{row.productID}}">

              <td><input type="checkbox" class="checkbox" name="itemIdList" value="@{{ row.productID }}"></td>
              <td>@{{row.prodct_Brand }}</td>
              <td>@{{row.prodct_Type }}</td>
              <td>@{{row.prodct_Type_Cat  | pTypeCat }}</td>

              <td>@{{ row.prodct_title}}</td>
              <td>@{{ row.partnumber}}</td>
              <!-- *************************** -->
              <td style="border-right: 1px dashed #b4d6f1;"><span class="@{{row.productID}}rec1  numberBorder" >@{{ row.status1  | isZiro:row.productID:1 }} </span></td>
              <td><span class="@{{row.productID}}rec2  numberBorder" > @{{ row.status2 | isZiro:row.productID :2 }}</span> </td>
              <td><span class="@{{row.productID}}rec3  numberBorder" > @{{ row.status3 | isZiro:row.productID :3 }} </span></td>
              <td><span class="@{{row.productID}}rec5  numberBorder" > @{{ row.status5 | isZiro:row.productID  :5}} </span></td>
              <td style="border-left: 1px dashed #b4d6f1;"><span class="@{{row.productID}}rec4  numberBorder" > @{{ row.status4 | isZiro:row.productID :4}} </span></td>
              <td> <span class="numberBorder blue" >@{{ row.sum}}    </span></td>
              <!-- *************************** -->
              <td style="border-right: 1px dashed #addcb4;"><span class="@{{row.productID}}rec1  numberBorder" >@{{ row.status2_6_sps_Taahodi  | isZiro:row.productID:1 }} </span></td>
              <td><span class="@{{row.productID}}rec2  numberBorder" > @{{ row.status2_3_reserved | isZiro:row.productID :2 }}</span> </td>
              <td><span class="@{{row.productID}}rec3  numberBorder" > @{{ row.status2_4_borrowed | isZiro:row.productID :3 }} </span></td>
              <td><span class="@{{row.productID}}rec5  numberBorder" > @{{ row.status2_5_warranty | isZiro:row.productID  :5}} </span></td>
              <td style="border-left: 1px dashed #addcb4;"><span class="@{{row.productID}}rec4  numberBorder" > @{{ row.status2_1_avail | isZiro:row.productID :4}} </span></td>
              <td> <span class="numberBorder bluex" >    </span></td>
              <!-- *************************** -->
              <td> <span class="numberBorder    AvlStock@{{row.productID}}" > @{{ row.AvailableStock | signeChecker:row.productID }}  <span>  </td>



               <br/>
<!--
               <div ng-show="inAllDatalist" id="inAllDatalist" class="row-actions">
                 <span class="edit">
                   <span class="editBtn"  ng-click="EditSelected(row.orderID)" aria-label="{{Lang::get('labels.edit')}}" > {{ Lang::get('labels.edit') }} </span> |
                 </span>
                 <span class="trash"> <span  class="submitdelete"  ng-click="MoveToTrash(row.orderID)" >{{ Lang::get('labels.moveToTrash') }}</span>
                 </span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>

               <div ng-show="inTrashlist" id="inTrashlist" class="row-actions">
                 <span class="RestoreTrash"> <span  class="RestoreTrash"  ng-click="RestoreFromTrash(row.orderID)" >{{ Lang::get('labels.RestoreFromTrash') }} | </span></span>
                 <span class="trash">        <span  class="submitdelete"  ng-click="DeleteFromDataBase(row.orderID)" >{{ Lang::get('labels.fulldelete') }}</span></span>
                 <span class="view"><a href="#" rel="bookmark" </a>  </span>
               </div>
-->



      </tr>
    </table>
  </div>

  <!-- pagination -->
    <ul class="pagination" style="float:  right;">
      <li><a href="" ng-click="pagination.prevPage()">&laquo;</a></li>
      <li ng-repeat="n in [] | range: pagination.numPages" ng-class="{active: n == pagination.page}"><a href="" ng-click="pagination.toPageId(n)">@{{n + 1}}</a></li>
      <li><a href="" ng-click="pagination.nextPage()">&raquo;</a></li>
    </ul>
  <!-- pagination -->
  <div style="height:  80px;"></div>
  <hr/>








@endsection
