@include('stockroom.view_puttingProducts_ToStock.page_parts.section_add_new_putting')
@include('stockroom.view_puttingProducts_ToStock.page_parts.section_serialNumber')
@include('stockroom.view_puttingProducts_ToStock.page_parts.section_viewRow')
@include('stockroom.view_puttingProducts_ToStock.page_parts.section_partInchassis')
@include('stockroom.view_puttingProducts_ToStock.page_parts.section_editRow')





@section('section_dimmerPage')


<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
            @section('section_add_new_putting') @show
            @section('section_serialNumber') @show
            @section('section_viewRow') @show
            @section('section_partInchassis') @show
            @section('section_editRow') @show
    
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
