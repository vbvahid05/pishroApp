@section('section_list')
@inject('publicClass', 'App\Mylibrary\PublicClass')



        <table class="table table-hover">
            <thead>
            <tr>
                <th><input type="checkbox" style="width: 15px !important;"></th>
                <th>{{ Lang::get('labels.posts_title') }}</th>
                <th>{{ Lang::get('labels.posts_author') }}</th>
                <th>{{ Lang::get('labels.posts_cat') }}</th>
                <th>{{ Lang::get('labels.posts_created_at') }} </th>
                <th>{{ Lang::get('labels.id') }}</th>
            </tr>
            </thead>

        @foreach ($dataList as $dl)
            <tr>
                <td><input type="checkbox" style="width: 15px !important;"></td>
                <td>{{$dl->post_title}}
                    ( <a href="<?php echo URL::current();?>/edit?id=<?php  echo $dl->Postid?>" >
                        {{lang::get('labels.edit')}} </a>
                       <span ng-click="post_delete( )"  > {{lang::get('labels.delete')}} </span>
                    )
                </td>
                <td>{{$dl->name}}</td>
                 <td>{{$dl->trmrel_title}}</td>
                <td>
                    <?php $date= $publicClass->gregorian_to_jalali_byString($dl->postsCreatedAt) ?>
                    {{$date[0]}}/{{$date[1]}}/{{$date[2]}}
                  </td>
                <td>{{$dl->Postid}}</td>
            </tr>
        @endforeach
            <tr>
                <td colspan="6">
                    <div style="float:  right;">
                        {{ $dataList->links() }}
                    </div>
                </td>
            </tr>
        </table>


@endsection