@extends ('layouts.theme')
@section ('pagetitle', $pageTitle)
{{--Load Sections--}}
@include('CMS.Categories.list.parts.section_toolbars')
@include ('CMS.Categories.list.parts.section_filter')
@include('CMS.Categories.list.parts.section_list')
{{--##############################################--}}

@section('content')

    <div ng-app="CMS_category_app" ng-controller="CMS_category_Ctrl" >

<div class="row PageTitle">
    @if(isset($pageTitle))<h2>  <div class="pageTitle col-md-12">   <i class="{{$pageIcon}}" aria-hidden="true"></i>    {{$pageTitle}}   </div>  </h2>@endif
</div>
    {{--ToolBar--}}
    @section ('section_toolbars') @show
    {{--Notification Bar--}}
    <div id="publicNotificationMessage" class="publicNotificationMessage"></div>
    {{--Filter Bar--}}
    @section ('section_filter')   @show
    {{--List Section--}}
    @section ('section_list')     @show
    </div>
@endsection