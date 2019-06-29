

var app = angular.module('Posts_App', ['simplePagination']);

app.directive('fileInput', ['$timeout', '$parse', function ($timeout, $parse) {
    return {

        link: function ($scope, element, attr) {
            element.on("change",function(event)
            {
                var files = event.target.files;
               // console.log(files[0].name);
                $parse(attr.fileInput).assign($scope,element[0].files);
                $scope.$apply();
            });
        }
    }
}]);
app.directive('ngRightClick', function($parse) {
    return function(scope, element, attrs) {
        var fn = $parse(attrs.ngRightClick);
        element.bind('contextmenu', function(event) {
            scope.$apply(function() {
                event.preventDefault();
                fn(scope, {$event:event});
            });
        });
    };
});



app.controller('Posts_Ctrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
{
    /*-----------*/
    function OnInit()
    {
        postType=$('#postType').val();
        MediaCenterSelectedArray=[];
    }
    OnInit();

    /*-----------*/
    $scope.updatePostPage=function (){
        // alert( $("input[name='mainBodyEditor']").val());
        switch (postType)
        {
            case 'posts':
                  var content = CKEDITOR.instances.post_content.getData();
                  arg=
                      {
                            postAction:$('#post_action').val(),
                            postID:$('#postID').val(),
                            postTitle:$('#post_Title').val(),
                            postCategury:$('#post_Categury').val(),
                            postContent: content,
                            tags:$('#post_tags').val(),
                            postImage:$scope.postThumb,
                            local:$('#local').val()
                        }
                        console.log(arg)
            break;
            case 'pages':
                var content = CKEDITOR.instances.post_content.getData();
                arg={
                    postAction:$('#post_action').val(),
                    postID:$('#postID').val(),
                    postTitle:$('#post_Title').val(),
                    postContent:content,
                }
            break;
        }
        if (arg)
        {
            $http.post('/all-posts/postActions/'+postType+'/newOrUpdate',arg).then
            (function pSuccess(response)
            {
                console.log(response.data);
                $scope.imageUrl=response.data;
                if (response.data==1)
                    toast_alert(Seved_Message,'success');
                else if (response.data==23000)
                    toast_alert('content cant be null','danger');

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }
    }
   /*-----------*/
    $scope.post_delete=function()
    {
        alert('d');
    }
/*----Media Center-------------------------------------*/
/*----Media Center-------------------------------------*/
 $scope.decrement=function()
 {
     $scope.itIsDeleteAction=true;
 }
    $scope.showMediaCenter=function(fileForTarget)
    {
        $scope.fileForTarget=fileForTarget;       //use in GetMediaFileByID()
                                                  //postThumb    postContentAtachments
        $scope.folderIsSelected=false;
        var Args={
            cms_terms:'filesGallery',
            folder:'',
        }

        $http.post('/mediaLibrary/Actions/showMediaCenterFolders',Args).then(
            function xSuccess(response)
            {
                SelectDimmer('mediaCenter');
                $('#Dimmer_page').dimmer('show');
                //console.log(response.data)
                $scope.MediaCenterFolders=response.data;
            }), function xError(response)
            {
                toast_alert(response.data,'warning');
            }
    }
 /*---showMediaFiles---------------------*/
     $scope.showAllMedia=function(viewmode,folder)
     {

         var Args={
             viewmode:viewmode, //sort by type Or AllFiles
             folder:folder
         }
         console.log(Args);

         $http.post('/mediaLibrary/Actions/showMediaCenterFiles',Args).then(
             function xSuccess(response)
             {
                 $scope.MediaCenterFiles=response.data;
                 $scope.waitForLoad=true;
             }), function xError(response)
         {
             toast_alert(response.data,'warning');
         }

     }

// __________________
    $scope.selectToViewFolderData=function(folderID)
    {
        $scope.current_Folder_ID=folderID;
        $('.uploadFolder').removeClass('active');
        $('#folderx'+folderID).addClass('active');
        $scope.TargetFolderToView=folderID;
        $scope.folderIsSelected=true;
        $scope.view_Mode='all';
        $scope.waitForLoad=false;
        $scope.showAllMedia($scope.view_Mode,$scope.TargetFolderToView);
    }
// __________________
    $scope.selectMediaFileFromList=function(id)
    {
      if ( jQuery.inArray(id, MediaCenterSelectedArray)== -1)
      {
          MediaCenterSelectedArray.push(id);
          $("#tikID"+id).addClass("selected");
      }
      else
      {
          MediaCenterSelectedArray = jQuery.grep(MediaCenterSelectedArray, function(value) {
              return value != id;
          });
          $("#tikID"+id).removeClass("selected");
      }
        $scope.PublicMediaCenterResult=MediaCenterSelectedArray;
        $scope.$numberOfSelectedItems=MediaCenterSelectedArray.length;
        $scope.cancelSelectedItem=true;
    }
    //----------------------------------------------------------
    $scope.returnSelectedMediaCenterValue=function(action)
    {
        var Args={
            fileIdArray:$scope.PublicMediaCenterResult, //sort by type Or AllFiles
        }
        $http.post('/mediaLibrary/Actions/GetMediaFileByID',Args).then(
            function xSuccess(response)
            {
                switch (action)
                {
                    case 'delete':
                        var Args={
                            SelectedArray:MediaCenterSelectedArray, //sort by type Or AllFiles
                        }
                        $http.post('/mediaLibrary/Actions/DeleteMediaFileByID',Args).then(
                            function xSuccess(response)
                            {
                                console.log(response.data)
                                MediaCenterSelectedArray=[];
                                $scope.selectToViewFolderData($scope.current_Folder_ID);
                                $scope.cancelSelectedItem=false;
                            }),function xError(response) {toast_alert(response.data,'warning');}
                    break;
                    case 'cancel':
                        // MediaCenterSelectedArray=[];
                        // $(".selectedFile").removeClass('selected');
                        MediaCenterSelectedArray=[];
                        $scope.selectToViewFolderData($scope.current_Folder_ID);
                        $scope.cancelSelectedItem=false;
                        break;
                    default :
                        GetMediaFileByID(response.data);
                        $(".selectedFile").removeClass('selected');
                    break;
                }


            }), function xError(response)
        {
            toast_alert(response.data,'warning');
        }
    }

    //----------------------------------------------------------
    function GetMediaFileByID(MediaFileByIdResultArray)
    {
        $scope.PublicMediaCenterResult=[];
        MediaCenterSelectedArray=[];

        switch ($scope.fileForTarget)
        {
            case 'postThumb':
                lengt= MediaFileByIdResultArray.length;
                $scope.postThumb=MediaFileByIdResultArray[lengt-1];
                $scope.postThumbFromDB=true;
                break;

            case 'postContentAtachments':
                var jsonConvertedData = JSON.stringify(MediaFileByIdResultArray);
                $("#postContentAtachments").val(jsonConvertedData);
                CKEDITOR_insert_file_to_content();
                break;
        }
        $('#Dimmer_page').dimmer('hide');
    }

    /*---UPLOAD----*/
    $scope.selectUploadFolder=function(folderID)
    {
        $('.uploadFolder').removeClass('active');
        $('#folder'+folderID).addClass('active');
        $scope.TargetFolder=folderID;
        $scope.folderIsSelected=true;
    }
/*-----------*/
    $scope.form = [];
    $scope.files = [];
    $scope.UploadedFileList=[];
    /*-----------*/
    $scope.submit = function() {

         Totalcount =$scope.files.length;
            image = $scope.files[0];
            $http({
                method  : 'POST',
                url     : '/mediaLibrary/Actions/upload',
                processData: false,
                transformRequest: function (data) {
                    var formData = new FormData();
                    formData.append("image", image);
                    formData.append("folder",  $scope.TargetFolder);
                    return formData;
                },
                data : $scope.form,
                headers: {
                    'Content-Type': undefined
                }
            }).then
            (function pSuccess(response)
            {
                  console.log(response.data)
                  $scope.UploadedFileList.push(response.data)
                 $("#UploadBar0").addClass('done');
                   uploadData(Totalcount ,0 );
             });

    };

    function uploadData(Totalcount ,currentItem )
    {

        if (currentItem<Totalcount)
        {

            currentItem++;
            image = $scope.files[currentItem];
            $("#UploadBar"+currentItem).addClass('done');

            $http({
                method  : 'POST',
                url     : '/mediaLibrary/Actions/upload',
                processData: false,
                transformRequest: function (data) {
                    var formData = new FormData();
                    formData.append("image", image);
                    formData.append("folder",  $scope.TargetFolder);
                    return formData;
                },
                data : $scope.form,
                headers: {
                    'Content-Type': undefined
                }
            }).then
            (function pSuccess(response)
            {
                console.log(response.data)
                $scope.UploadedFileList.push(response.data)
                $(".UploadBar").addClass('done');
                  uploadData(Totalcount ,currentItem );
             });
        }
        else
            console.log($scope.UploadedFileList)
    }

    /*-----------*/
    $scope.uploadedFile = function(element) {
        $scope.files=[];
        $scope.UploadedFileList=[];

        $scope.currentFile = element.files[0];
        var reader = new FileReader();
        reader.onload = function(event) {
            $scope.image_source = event.target.result;
            $scope.$apply(function($scope) {
                $scope.files = element.files;
            });
        }
        reader.readAsDataURL(element.files[0]);
    }

/*----Media Center-------------------------------------*/
$scope.setPostCategory =function(id)
{
    $baseVal=$("#categuryList").val();
    $baseVal=$baseVal+','+id;
    $("#categuryList").val($baseVal);
    $(".catCheckBox").addClass('hidden');
}

    function SelectDimmer(dimmer)
    {
        switch(dimmer) {
            case 'mediaCenter':
                $scope.FormTitle = 'mediaCenter';
                $scope.section_media_center_dimmer = true; //show add_new_putting
                break;
        }
    }

}]); //controller
