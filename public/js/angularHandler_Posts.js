

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
}])



app.controller('Posts_Ctrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
{
    /*-----------*/
    function OnInit()
    {
        postType=$('#postType').val();
    }
    OnInit();

    /*-----------*/
    $scope.updatePostPage=function (){
        // alert( $("input[name='mainBodyEditor']").val());
        switch (postType)
        {
            case 'posts':

                let photo = document.getElementById("mediaLib").files[0];  // file from input
                let req = new XMLHttpRequest();
                let formData = new FormData();

                formData.append("photo", photo);


                postImage=$('#mediaLib').val();

                // $("#mediaLib").val(this.files && this.files.length ?
                //     this.files[0].name : this.value.replace(/^C:\\fakepath\\/i, ''));


                // postImage=   document.getElementById("mediaLib").files[0];
                console.log(photo);
                var content = CKEDITOR.instances.post_content.getData();
                        arg={
                            postAction:$('#post_action').val(),
                            postID:$('#postID').val(),
                            postTitle:$('#post_Title').val(),
                            postCategury:$('#post_Categury').val(),
                            postContent: content,
                            tags:$('#post_tags').val(),
                            postImage:   document.getElementById("mediaLib").files[0].name

                        }

              //  postImage:$('#mediaLib').val()


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

    $scope.showMediaCenter=function()
    {
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
                console.log(response.data)
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

                 console.log(response.data)
                 $scope.MediaCenterFiles=response.data;
             }), function xError(response)
         {
             toast_alert(response.data,'warning');
         }

     }

// __________________
    $scope.selectToViewFolderData=function(folderID)
    {
        $('.uploadFolder').removeClass('active');
        $('#folderx'+folderID).addClass('active');
        $scope.TargetFolderToView=folderID;
        $scope.folderIsSelected=true;
        $scope.view_Mode='all';
        $scope.showAllMedia($scope.view_Mode,$scope.TargetFolderToView);
    }
// __________________
    $scope.selectMediaFileFromList=function(id)
    {
        alert(id)
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
            console.log(image);
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
                $scope.UploadedFileList.push(response.data)
                console.log(response.data);
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
                $scope.UploadedFileList.push(response.data)
                console.log(response.data);
                $(".UploadBar").addClass('done');
                  uploadData(Totalcount ,currentItem );
             });
        }
        else
            console.log('completed')
    }

    /*-----------*/

    $scope.uploadedFile = function(element) {
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
