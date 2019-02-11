@extends ('layouts.theme')
@section ('pagetitle', $pageTitle)
{{--Load Sections--}}
@include('CMS.Posts.page.parts.section_toolbars')
@include ('CMS.Posts.page.parts.section_mainBody')
@include('CMS.Posts.page.parts.section_leftSideBar')
{{--##############################################--}}
@section('content')
<div ng-app="Posts_App" ng-controller="Posts_Ctrl" >
    <input id="postType" type="hidden" value="{{$postType}}" >
    <input id="postID" type="hidden" value="{{$postId}}" >
    <input id="post_action" type="hidden" value="{{$action}}" >
    {{--ToolBar--}}
    @section ('section_toolbars') @show
    {{--Notification Bar--}}
    <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    {{--Content Section--}}
    <div class="row col-md-12">
        {{----------------------------}}
        <div class="col-md-9 SCmainBody pull-right">
             @section ('section_mainBody') @show
        </div>
        {{----------------------------}}
        <div class="col-md-3 SCleftSideBar pull-right">
             @section ('section_leftSideBar') @show
        </div>
        {{----------------------------}}
    </div>
</div>
@endsection