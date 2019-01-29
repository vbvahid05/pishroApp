@section('section_type_filter')
<div class="filters ui search">
    <div class="ui icon input">
        <?php //placeholder="{{ Lang::get('labels.search') }}" ?>
        <input ng-model="search.$" class="prompt" type="text"  ng-keypress="changePagin(10000)" ng-blur="changePagin(10)">
        <i class="search icon"></i>
    </div>
    <div class="results"></div>
</div>
@endsection
