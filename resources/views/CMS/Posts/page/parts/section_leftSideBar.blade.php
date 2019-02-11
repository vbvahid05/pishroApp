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
    <select name="skills" class="ui fluid search dropdown">
        <option value="">Skills</option>
        <option value="angular">Angular</option>
        <option value="css">CSS</option>
        <option value="design">Graphic Design</option>
        <option value="ember">Ember</option>
        <option value="html">HTML</option>
        <option value="ia">Information Architecture</option>
        <option value="javascript">Javascript</option>
        <option value="mech">Mechanical Engineering</option>
        <option value="meteor">Meteor</option>
        <option value="node">NodeJS</option>
        <option value="plumbing">Plumbing</option>
        <option value="python">Python</option>
        <option value="rails">Rails</option>
        <option value="react">React</option>
        <option value="repair">Kitchen Repair</option>
        <option value="ruby">Ruby</option>
        <option value="ui">UI Design</option>
        <option value="ux">User Experience</option>
    </select>

@endsection