@include('sell.view_invoice.invoice_parts.section_new_edit')
@include('sell.view_invoice.invoice_parts.section_addSubProduct_dimmer')
@include('sell.view_invoice.invoice_parts.section_pdfSetting_dimmer')


@section('section_dimmerPage')
<div  id="Dimmer_page"   class="ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="ui text container">
          <div  class="ui segments">
              @section('section_pdfSetting_dimmer') @show
              @section('section_new_edit') @show
              @section('section_addSubProduct_dimmer') @show

          </div>
      </div>
    </div>
  </div>
</div>


@endsection
