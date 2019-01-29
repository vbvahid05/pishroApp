@section('section_toolbars')
<div class="toolbars well well-sm">

  <!--  All view -->
    @can('invoice_create', 1)
        <button ng-click="add_new_invoice()" ng-showx="btn_Add_new" class="btn btn-default">
            <i class="fa fa-plus" aria-hidden="true"></i>
            {{ Lang::get('labels.new_invoice') }}
        </button>
    @endcan

    @can('invoice_delete', 1)
        <div ng-click="GroupRestoreORMoveToTrash(0)" ng-show="btn_move_trash" class="btn btn-default">
            <i class="fa fa-trash" aria-hidden="true"></i>
            {{ Lang::get('labels.delete') }}
        </div>
   @endcan
<!--  trash view -->
    @can('invoice_delete', 1)
        <div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="GroupRestoreORMoveToTrash(1)"  >
            <i class="fa fa-undo" aria-hidden="true"></i>
            {{ Lang::get('labels.RestoreFromTrash') }}
        </div>
        <div ng-show="BtnFullDeleteProducts"  class="btn btn-default"  ng-click="GroupRestoreORMoveToTrash(2)"  >
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
@can('invoice_delete', 1)
    <div class="toolbars well well-sm">
          <span id="ShowAll" class="DatalistSelector active"  ng-click="showAll(0)" >      {{ Lang::get('labels.all') }}   </span>
          <span id="ShowTrashed"  class="DatalistSelector" ng-click="showAll(1)" >   {{ Lang::get('labels.Trash') }}  </span>
    </div>
@endcan

@endsection
