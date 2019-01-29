var app = angular.module('userSetting_App', ['simplePagination']);
app.controller('userSetting_Ctrl', ['$scope', '$http','Pagination',
    function($scope, $http,Pagination)
    {

        $scope.changeUserPassword=function (isvalid ) {
            if (isvalid)
            {
                arg={
                    password:$scope.paswrd
                }
                $http.post('/user/setting/changePassword',arg).then
                (function pSuccess(response)
                {
                    console.log(response.data)
                    if (response.data)
                    {
                        toast_alert('Changed ','success');
                        $(location).attr('href','/');
                    }
                    else
                        toast_alert('Error','danger');
                }), function xError(response)
                {
                    toast_alert(response.data,'danger');
                }
            }
            else
            {
                toast_alert('Some Error','danger');
            }
        }


    }]); //controller