@section('section_toolbars')
<div class="toolbars well well-sm">

  <!--  All view -->

     
<!--  trash view -->
<div class="btn btn-default" ng-click="newWarranty()"> صدور حواله گارانتی </div>
<div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="RestoreGroupFromTrash()"  >
    <i class="fa fa-undo" aria-hidden="true"></i>
    {{ Lang::get('labels.RestoreFromTrash') }}
</div>
<div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="FullDeleteSelectedItems()"  >
    <i class="fa fa-trash" aria-hidden="true"></i>
    {{ Lang::get('labels.fulldelete') }}
</div>
<!--
    <div ng-show="BtnTrashProducts"  class="btn btn-default"  ng-click="moveGroupToTrash(@)"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.delete') }}
    </div>
    <div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="delete_selected_products(@)"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.fulldelete') }}
    </div>
-->
</div>
<!-- TOOLBAR -->
<div class="toolbars well well-sm">
      <span id="ShowAll" class="DatalistSelector active"  ng-click="showAll(0)" >      {{ Lang::get('labels.all') }}   </span>
      <span id="ShowTrashed"  class="DatalistSelector" ng-click="showAll(1)" >   {{ Lang::get('labels.Trash') }}  </span>
</div>
@endsection
