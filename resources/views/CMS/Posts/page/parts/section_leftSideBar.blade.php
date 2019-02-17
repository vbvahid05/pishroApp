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


@endsection