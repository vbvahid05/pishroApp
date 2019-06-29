@section('section_toolbars')
    {{--<div class="ToolBar col-md-12 ">--}}
        {{--<a href="/all-posts/posts/{{$local}}/new">--}}
            {{--<button  class="btn btn-success"  >--}}
                {{--<i class="fa fa-file-o"></i>--}}
                {{--{{Lang::get('labels.newPost')}}--}}
            {{--</button>--}}
        {{--</a>--}}
    {{--</div>--}}
    <div class="ToolBar col-md-12 ">
        @foreach ($all_language as $allLang)
         <a href="/all-Categories/{{$allLang->lang_title}}/{{$postType}}" class="btn btn-default languageBTN @if($allLang->lang_title == $local) {{'active'}}  @endif" >   {{$allLang->lang_name}}  </a>
        @endforeach
    </div>



@endsection