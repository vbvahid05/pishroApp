@section('section_filter')
<div class="filters ui search">
    <div class="ui icon input pull-right">
        <?php //placeholder="{{ Lang::get('labels.search') }}" ?>
        {{--<input  ng-model="search.$" class="prompt " type="text"  ng-keypress="changePagin()" ng-blur="changePagin()">--}}
        {{--<i class="search icon"></i>--}}
    </div>

    <div class="results"></div>
</div>

@endsection
