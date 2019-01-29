@include('sell.view_stockRequest.stockRequest_parts.section_new_edit')
@include('sell.view_stockRequest.stockRequest_parts.section_sub_chassis_list')
@include('sell.view_stockRequest.stockRequest_parts.section_convert_stockRequest')


@section('section_dimmerPage')
<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
              @section('section_sub_chassis_list') @show
              @section('section_new_edit') @show
              @section('section_convert_stockrequerst') @show
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
