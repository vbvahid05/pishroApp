
@section('uploadFile')

<div class="col-md-12">
    <div class="col-md-2 pull-right">
        <ul  style="list-style: none;text-align: right;">
            <li id="folder@{{ mcf.id }}" class="uploadFolder" ng-repeat="mcf in MediaCenterFolders" ng-click="selectUploadFolder(mcf.id)">
                <i  class="@{{ mcf.trmrel_icon}}" aria-hidden="true"></i>
                @{{ mcf.trmrel_title}}
            </li>
        </ul>
    </div>

    <div class="col-md-10" ng-show="folderIsSelected">
        <form ng-submit="submit()" name="form" role="form">
            <input multiple ng-model="form.image" type="file" id="embedpollfileinput"  class="inputfile pull-right"   onchange="angular.element(this).scope().uploadedFile(this)" style="width:400px" >
            <input type="submit"  value="Submit" class="uploadBtn" />
            <label for="embedpollfileinput" class="selectTofileBtn ui huge green right floated button" style="color: white !important;">
                <i class="ui upload icon"></i>
                Upload image
            </label>
            <br/>
            <img ng-src="@{{image_source}}" style="width:300px;">
        </form>
        <hr>
        <div class="row">
            <div class="col-md-2" ng-repeat="file in  UploadedFileList">
                <div ng-if="file.id !=null" class="col-md-12 mediaCenterImages" style="background-image: url( /storage/mediaCenter/@{{  file.id}}/thumb/@{{file.image}} ) ">
                    <div class="uploadFile progress">
                        <div id="UploadBar0" class="UploadBar progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" >
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

@endsection