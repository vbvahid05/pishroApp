@inject('publicLibrary', 'App\Mylibrary\PublicClass')
@section('section_leftSideBar')
    {{--<div class="ui selection dropdown">--}}
        {{--<input type="hidden" name="gender">--}}
        {{--<i class="dropdown icon"></i>--}}
        {{--<div class="default text">{{ lang::get('labels.published') }}</div>--}}
        {{--<div class="menu">--}}
            {{--<div class="item" data-value="1">{{ lang::get('labels.published') }}</div>--}}
            {{--<div class="item" data-value="0">{{ lang::get('labels.unPublished') }}</div>--}}
            {{--<div class="item" data-value="2">{{ lang::get('labels.archived') }}</div>--}}
            {{--<div class="item" data-value="3">{{ lang::get('labels.trash') }}</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="sideBoxs mid">
        <div class="header"> {{lang::get('labels.posts_category')}}</div>
        <div class="postcategury">
            <?php //echo  $publicLibrary->checkBoxList($categuryList,0,$dataList[0]->post_categury)?>
            <select id="post_Categury" class="form-control" >
            <?php
                    if ($hasValue)
                       echo  $publicLibrary->DropDownList($categuryList,0,$dataList[0]->post_categury,0);
                    else
                        echo  $publicLibrary->DropDownList($categuryList,0,0,0);
            ?>
            </select>
        </div>
    </div>
    <div class="ui sub header"></div>


    {{--<select class="js-example-basic-multiple" name="states[]" multiple="multiple">--}}
        {{--<option value="AL">Alabama</option>--}}
        {{--<option value="WY">Wyoming</option>--}}
    {{--</select>--}}

    <div class="sideBoxs mid">
     <div class="header">  {{lang::get('labels.posts_tags')}}</div>
<?php //var_dump($publicLibrary->getTagList($postId)) ?>
    <select id="post_tags" class="js-example-tokenizer form-control" multiple="multiple">
        <?php echo $publicLibrary->getTagList($postId);?>
        {{--<option selected="selected">orange</option>--}}
    </select>
    </div>
<br/>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bug" aria-hidden="true" style="color: #49758c;"></i>&nbsp;{{Lang::get('labels.images')}}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            @foreach($media as $m)
                <img class="img-responsive" src="/storage/{{$m->id}}/{{ $m->file_name }}" >

            @endforeach
            <div class="input-group mb-3">

                <div class="custom-file">
                    {{--@if($media)--}}

                    {{--@endif--}}

                    <img src="@{{imageUrl}}" style="width: 70%">
                    <input type="file" name="mediaLib" class="custom-file-input" id="mediaLib">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    <div class="btn btn-info" ng-click="showMediaCenter()">upload Image</div>
                </div>
            </div>
        </div>
    </div>



@endsection