@section('section_allcustomers_toolbars')
<div class="toolbars well well-sm">
    <a href="{{ url('/custommer') }}" >
        <div class="btn btn-default" >
          <i class="fa fa-plus" aria-hidden="true"></i>
           {{ Lang::get('labels.newCustommer') }}
        </div>
    </a>

    <div ng-show="BtnRestoreProducts"  class="btn btn-default"  ng-click="GroupTrash_Restore_fullDelete(0)"  >
        <i class="fa fa-undo" aria-hidden="true"></i>
        {{ Lang::get('labels.RestoreFromTrash') }}
    </div>
    <div ng-show="BtnTrashProducts"  class="btn btn-default"  ng-click="GroupTrash_Restore_fullDelete(1)"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
          {{ Lang::get('labels.DeleteCustommer') }}
    </div>
    <div ng-show="BtnDeleteProducts"  class="btn btn-default"  ng-click="GroupTrash_Restore_fullDelete(3)"  >
        <i class="fa fa-trash" aria-hidden="true"></i>
        {{ Lang::get('labels.fulldelete') }}
    </div>



</div>

<div class="toolbars well well-sm">
      <span id="ShowAll" class="DatalistSelector"  ng-click="get_all_custommers_data(0)" >      {{ Lang::get('labels.all') }}   </span>
      <span id="ShowTrashed"  class="DatalistSelector" ng-click="get_all_custommers_data(1)" >   {{ Lang::get('labels.Trash') }}  </span>
</div>
@endsection
