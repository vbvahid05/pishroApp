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
    $scope.updatePostPage=function ()
    {
        switch (postType)
        {
        case 'posts':{
                        arg={
                            postAction:$('#post_action').val(),
                            postID:$('#postID').val(),
                            postTitle:$('#post_Title').val(),
                            postCategury:$('#post_Categury').val(),
                            postContent:$('#post_content').val(),
                        }

                        $http.post('/all-posts/postActions/'+postType+'/newOrUpdate',arg).then
                        (function pSuccess(response)
                        {
                            if (response.data)
                                ;
                            toast_alert(response.data,'success');

                        }), function xError(response)
                        {
                            toast_alert(response.data,'danger');
                        }
                   }
        }
    console.log(arg);
    }
    /*-----------*/

$scope.setPostCategory =function(id)
{
    $baseVal=$("#categuryList").val();
    $baseVal=$baseVal+','+id;
    $("#categuryList").val($baseVal);
    $(".catCheckBox").addClass('hidden');
}

}]); //controller
