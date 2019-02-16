@section('section_toolbars')
<div class="toolbars  well well-sm" style="height: 55px;">

    <a class="exportExcel btn btn-default " href="/ProductsStatus" style="position: absolute;left: 25px;">
        <i class="fa fa-file-excel-o" style="font-size: 18px;color: green;"></i>
        {{ Lang::get('labels.ExportExcel_Report') }}

    </a>

</div>
<!-- TOOLBAR -->

@endsection
