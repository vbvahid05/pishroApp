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
                            postID:$('#postID').val(),
                            postTitle:$('#postTitle').val(),
                        }
                   }
        }
    console.log(arg);
    }
    /*-----------*/

$scope.setAction =function(id)
{
    $baseVal=$("#categuryList").val();
    $baseVal=$baseVal+','+id;
    $("#categuryList").val($baseVal);
}

}]); //controller
