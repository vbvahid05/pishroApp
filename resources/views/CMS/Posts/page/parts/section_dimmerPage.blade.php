@include('CMS.Posts.page.parts.section_media_center_dimmer')

@section('section_dimmerPage')
<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
              @section('section_media_center_dimmer')  @show
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
