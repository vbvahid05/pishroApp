@section ('section_filter')
    <div class="PostFilterBar col-md-12 ">
        <?php $activeAll=''; $activeTrash='';
        ($viewListMode=='trash')? $activeTrash='active':$activeAll='active'?>
        <a href="/all-posts/{{$postType}}" id="ShowAll" class="DatalistSelector {{$activeAll}}" ng-click="ViewPostList(0)">     {{lang::get('labels.all')}}     </a>
        <a href="/all-posts/{{$postType}}?view=trash" id="ShowAll" class="DatalistSelector {{$activeTrash}} " ng-click="ViewPostList(1)">      {{lang::get('labels.Trash')}}   </a>
    </div>
@endsection