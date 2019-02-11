@section('section_toolbars')
    <div class="ToolBar col-md-12 ">
        <a href="/all-posts/posts/new">
            <button  class="btn btn-success"  >
                <i class="fa fa-file-o"></i>
                {{Lang::get('labels.newPost')}}
            </button>
        </a>
    </div>
@endsection