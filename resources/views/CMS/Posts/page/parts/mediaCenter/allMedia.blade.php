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
        <div class=" mediaCenter-body col-md-10">
                <div class="mediaCenter-image col-md-2 pull-right" ng-repeat="files in MediaCenterFiles" ng-click="selectMediaFileFromList(files.id)">
                    <img ng-if="files.mdiac_mime_type == 'jpg' || files.mdiac_mime_type == 'png'" src="/storage/mediaCenter/@{{ files.id }}/thumb/@{{ files.mdiac_filename }}"  >
                    <i   ng-if="files.mdiac_mime_type == 'zip' || files.mdiac_mime_type == 'rar'" class="archive-files fa fa-file-archive-o" style="font-size: 40px"></i>

                    <label>@{{ files.mdiac_name }}</label>
                </div>
        </div>
    </div>

@endsection