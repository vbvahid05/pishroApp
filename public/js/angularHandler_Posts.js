var app = angular.module('Posts_App', ['simplePagination']);
app.controller('Posts_Ctrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
{
    /*-----------*/
    function OnBoot()
    {
        postType=$('#postType').val();

    }
    OnBoot();

    /*-----------*/
    $scope.updatePostPage=function (){
        // alert( $("input[name='mainBodyEditor']").val());

        switch (postType)
        {
            case 'posts':
                var content = CKEDITOR.instances.post_content.getData();
                        arg={
                            postAction:$('#post_action').val(),
                            postID:$('#postID').val(),
                            postTitle:$('#post_Title').val(),
                            postCategury:$('#post_Categury').val(),
                            postContent: content,
                            tags:$('#post_tags').val(),
                            postImage:$('#mediaLib').val()
                        }




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

$scope.setPostCategory =function(id)
{
    $baseVal=$("#categuryList").val();
    $baseVal=$baseVal+','+id;
    $("#categuryList").val($baseVal);
    $(".catCheckBox").addClass('hidden');
}

}]); //controller
