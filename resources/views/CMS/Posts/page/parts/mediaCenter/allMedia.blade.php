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
        <div class="mediaCenter-body col-md-10">
            <i ng-show="!waitForLoad" class="fa fa-spinner fa-spin waitForLoading" ></i>
                <div class="mediaCenter-image col-md-2 pull-right" ng-repeat="files in MediaCenterFiles" ng-click="selectMediaFileFromList(files.id)" ng-right-click="decrement()">
                    <div ng-if="files.mdiac_mime_type == 'jpg' || files.mdiac_mime_type == 'png'" class="image-file"  style=" background: url(/storage/mediaCenter/@{{ files.id }}/thumb/@{{ files.mdiac_filename }})"   > </div>
                    <i   ng-if="files.mdiac_mime_type == 'zip' || files.mdiac_mime_type == 'rar'" class="archive-files fa fa-file-archive-o" style="font-size: 40px"></i>

                    <i class="selectedFile fa fa-check greenx"  id="tikID@{{ files.id }}"></i>
                    <label>@{{ files.mdiac_name }}</label>
                </div>
        </div>
    </div>
    <div class="MediaCenterActions row">
        <div ng-showx="!itIsDeleteAction" class="btn-success btn pull-left" ng-click="returnSelectedMediaCenterValue()" style="margin-left: 10px;">{{lang::get('labels.select')}}</div>
        <div ng-showx="itIsDeleteAction" class="btn-danger btn pull-left" ng-click="returnSelectedMediaCenterValue('delete')" style="margin-left: 10px;">{{lang::get('labels.delete')}}</div>
        <div ng-show="cancelSelectedItem" class="btn-warning btn pull-left" ng-click="returnSelectedMediaCenterValue('cancel')" style="margin-left: 10px;">{{lang::get('labels.cancel')}} (@{{ $numberOfSelectedItems }})</div>
    </div>
@endsection