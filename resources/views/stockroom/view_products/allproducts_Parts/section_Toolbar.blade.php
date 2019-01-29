@section('section_toolbar')
<div class="toolbars well well-sm">
    <a href="{{ url('/stock/product/new') }}" >
      <div class="btn btn-default" >
          <i class="fa fa-plus" aria-hidden="true"></i>
          {{ Lang::get('labels.AddNewProduct') }}
      </div>
    </a>
    <div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="RestoreGroupFromTrash()"  >
        <i class="fa fa-undo" aria-hidden="true"></i>
        {{ Lang::get('labels.RestoreFromTrash') }}
    </div>
    <div ng-show="BtnTrashProducts"  class="btn btn-default"  ng-click="moveGroupToTrash()"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.delete') }}
    </div>
    <div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="delete_selected_products()"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.fulldelete') }}
    </div>

</div>
<!-- TOOLBAR -->
<div class="toolbars well well-sm">
      <span  id="ShowAll" class="DatalistSelector"  ng-click="ShowAllProducts()" >      {{ Lang::get('labels.all') }}   </span>
      <span  id="ShowTrashed"  class="DatalistSelector" ng-click="ShowTrashedProducts()" >   {{ Lang::get('labels.Trash') }}  </span>
</div>
<!-- Notifications-->
  <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
@endsection
