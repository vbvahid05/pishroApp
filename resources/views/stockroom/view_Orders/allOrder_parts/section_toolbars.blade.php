@section('section_toolbars')
<div class="toolbars well well-sm">

  <!--  All view -->
      <div ng-click="add_new()" ng-show="btn_Add_new" class="btn btn-default">
          <i class="fa fa-plus" aria-hidden="true"></i>
          {{ Lang::get('labels.Orders_add_new') }}
      </div>
@can('order_delete', 1)
      <div ng-click="move_Selected_to_Trash()" ng-show="btn_move_trash" class="btn btn-default">
            <i class="fa fa-trash" aria-hidden="true"></i>
          {{ Lang::get('labels.delete') }}
      </div>
<!--  trash view -->

    <div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="RestoreGroupFromTrash()"  >
        <i class="fa fa-undo" aria-hidden="true"></i>
        {{ Lang::get('labels.RestoreFromTrash') }}
    </div>

    <div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="FullDeleteSelectedItems()"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.fulldelete') }}
    </div>
@endcan
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
