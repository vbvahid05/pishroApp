@section ('section_filter')
    <div class="row">
        <div class="PostFilterBar col-md-4 " style="height: 100px;">
            <select ng-model="selectedCateory"  ng-change="catergorySelected()" >
                  <option   ng-repeat="x in category_list_by_Term_type" value="@{{x.termID}}">@{{x.termTitle}}</option>
            </select>
        </div>
        <form ng-submit="add_new_wCategory_Item()">
            <div  class="col-md-2">
                <span ng-show="!newCategory_InputBox && postType =='menu'" class="newCategory" ng-click="show_newCategory_InputBox()">
                    <i class="fa fa-plus"></i>
                   دسته بندی جدید
                </span>
            </div>
            <div ng-show="newCategory_InputBox" class="col-md-2">
                <input ng-model="newCategoryName" class="form-control" type="text" style="width: 100%!important;" placeholder="عنوان دسته جدید" required="required">
            </div>
            <div  ng-show="newCategory_InputBox" class="col-md-2">
                <button type="submit" class="btn btn-success">add</button>
                <span ng-click="hide_newCategory_InputBox()" class="btn btn-warning">cancel</span>

            </div>
        </form>
    </div>

@endsection