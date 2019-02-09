@section('section_toolbars')
    <div class="ToolBar col-md-12 ">
        <button  class="btn btn-success"  >
            <i class="fa fa-file-o"></i>
            {{Lang::get('labels.newPost')}}
        </button>
        <div class="col-md-2 pull-left">
            <div  class="btn btn-primary  btn-block "  ng-click="updatePostPage()" >
                <i class="fa fa-save"></i>
                {{Lang::get('labels.update')}}
            </div>
        </div>

    </div>
@endsection