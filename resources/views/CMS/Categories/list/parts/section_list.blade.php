@section('section_list')
@inject('publicClass', 'App\Mylibrary\PublicClass')




<div class="categoryManagement">
    <div ng-app="CMS_category_app" ng-controller="CMS_category_Ctrl" >
        <input type="hidden" id="local" name="local" value="{{$local}}">
        <input type="hidden" id="postType" name="postType" value="{{$postType}}">
        <input type="hidden" ng-model="term_id" id="term_id" name="postType" value="{{$term_ID}}">



    <div class="col-md-8 pull-right">
        <p ng-bind-html="catList"></p>
    </div>
    <div class="col-md-4">
        <form ng-submit="saveNewCategory()" class="ui form newCategory">
            <div class="fields">
                <label>{{lang::get('labels.catName')}}</label>
                <input  ng-model="newCatName" type="text"   required >
            </div>
            <div class="fields">
                <label>{{lang::get('labels.catSlug')}}</label>
                <input ng-model="newCatSlug" type="text"  required >
            </div>
            <div class="fields">
                <label>{{lang::get('labels.catParent')}}</label>
            </div>
            <div class="fields parents">
                <select id="newCatParent" class=" ui fluid dropdown "
                        ng-bind-html="selectCatList">
                </select>
            </div>
            <br/>
            <button type="submit" class="btn btn-success">save</button>
        </form>
    </div>

    </div>
</div>





@endsection