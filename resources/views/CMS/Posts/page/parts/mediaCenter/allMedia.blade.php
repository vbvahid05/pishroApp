@section('allMedia')

    <div class="col-md-12">
            <div class="col-md-2 pull-right">
                <ul  style="list-style: none;text-align: right;">
                    <li id="folderx@{{ mcf.id }}" class="uploadFolder" ng-repeat="mcf in MediaCenterFolders" ng-click="selectToViewFolderData(mcf.id)">
                        <i  class="@{{ mcf.trmrel_icon}}" aria-hidden="true"></i>
                        @{{ mcf.trmrel_title}}
                    </li>
                </ul>
        </div>
        <div class="col-md-10">
                <div class="col-md-2" ng-repeat="files in MediaCenterFiles">
                    <img src="/storage/mediaCenter/@{{ files.id }}/@{{ files.mdiac_filename }}" style="width: 100%;">
                    <label>@{{ files.mdiac_name }}</label>
                </div>
        </div>
    </div>

@endsection