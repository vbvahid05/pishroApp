@include('CMS.Posts.page.parts.mediaCenter.allMedia')
@include('CMS.Posts.page.parts.mediaCenter.uploadFile')
@section('section_media_center_dimmer')
    <div ng-show="section_media_center_dimmer">
        <div   class="ui segment" style="
        position: fixed;
    top: 5%;
    bottom: 5%;
    left: 5%;
    right: 5%;
    background-color: #fff;
    z-index: 1001;
    border-top: 4px solid #4CAF50;">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>

            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <hr/>
                <!------ ------>
                <div class="ui tabular menu">
                    <div class="item " data-tab="tab-home">All Media</div>
                    <div class="item active" data-tab="tab-name11">Upload</div>
                </div>
                <div class="ui tab " data-tab="tab-home"> @section('allMedia')  @show</div>
                <div class="ui tab active" data-tab="tab-name11"> @section('uploadFile')  @show </div>

                <!------ ------>
            </div>
        </div>
    </div>
@endsection
