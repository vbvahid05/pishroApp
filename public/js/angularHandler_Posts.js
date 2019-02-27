

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
    $scope.showMediaCenter=function()
    {
        SelectDimmer('mediaCenter');
        $('#Dimmer_page').dimmer('show');
    }
/*-----------*/
    $scope.form = [];
    $scope.files = [];
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
                    return formData;
                },
                data : $scope.form,
                headers: {
                    'Content-Type': undefined
                }
            }).then
            (function pSuccess(response)
            {
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
                    return formData;
                },
                data : $scope.form,
                headers: {
                    'Content-Type': undefined
                }
            }).then
            (function pSuccess(response)
            {
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



/*------------------*/
    $scope.UploadFileX=function()
    {
        // var form_Data= new FormData();
        // angular.forEach($scope.files,function (file) {
        // form_Data.append('file',file);
        // });
        //
        // $http.post('/mediaLibrary/Actions/upload' ,form_Data,
        //     {
        //         transformRequest: angular.identity,
        //         headers:{'Content-Type':undefined ,'Process-Data':false}
        //
        //     }).then(function spSuccess (response) {
        //         console.log(response.data);
        // }), function xError(response)
        // {
        //     toast_alert(response.data,'danger');
        // }





// Display the key/value pairs
//         for (var pair of form_Data.entries()) {
//             console.log(pair[0]+ ', ' + pair[1]);
//         }

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
