
@section('uploadFile')
    https://www.youtube.com/watch?v=LRS-DrwdY_M

    <form ng-submit="submit()" name="form" role="form">
        <input ng-model="form.image" type="file" class="form-control input-lg"   onchange="angular.element(this).scope().uploadedFile(this)" style="width:400px" >
        <input type="submit" id="submit" value="Submit" />
        <br/>
        <img ng-src="@{{image_source}}" style="width:300px;">
    </form>
    <div class="progress">
        <div class="UploadBar progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" >

        </div>
    </div>

@endsection