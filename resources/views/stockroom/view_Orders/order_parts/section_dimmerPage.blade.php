@include('stockroom.view_puttingProducts_ToStock.page_parts.section_add_new_putting')

@include('stockroom.view_Orders.order_parts.section_Test')
@include('stockroom.view_Orders.order_parts.section_new_edit_order')
@include('stockroom.view_Orders.order_parts.section_add_ProductToOrder')
@include('stockroom.view_Orders.order_parts.section_add_A_PartToChassis')


@section('section_dimmerPage')


<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
            @section('section_add_ProductToOrder') @show
            @section('section_new_edit_order') @show
            @section('section_Test') @show
            @section('section_add_A_PartToChassis') @show
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
