@include('sell.view_warranty.single_parts.section_new_edit')


@section('section_dimmerPage')
<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
            @section('section_new_edit') @show
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
