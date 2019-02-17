
var app = angular.module('Setting_App', ['simplePagination']);
app.controller('setting_Ctrl', ['$scope', '$http','Pagination',
    function($scope, $http,Pagination)
    {
       function onload()
       {
           getAllRoles();
           getAllUserRoles();
       }
       onload();

        var id_array =[];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.updateRole=function()
        {
            console.log($scope.actionList);
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function getAllRoles()
        {
            var newFormData={mode:0,};
            $http.post('/setting/user/getAllRoles',newFormData).then
            (function pSuccess(response)
            {
                $scope.RolesData= response.data;
                console.log(response.data);
                $scope.NewRole_box=true;

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function getAllActions()
        {
            var newFormData={mode:0,};
            $http.post('/setting/user/getAllActions',newFormData).then
            (function pSuccess(response)
            {
                return  response.data;
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function getAllUserRoles()
        {
            $scope.showspinner_Loading=true;
            var newFormData={mode:0,};
            $http.post('/setting/user/getAllUserRoles',newFormData).then
            (function pSuccess(response)
            {
                $scope.user_Roles= response.data;
                $scope.showspinner_Loading=false;

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $scope.show=function(id,formTitle)
        {
            $scope.Dmr_New_Edit_Roles=true;
            $scope.Dmr_new_edit_user_roles=false;
            $scope.roleID=id;
            $('#Dimmer_page').dimmer('show');
            $scope.FormTitle=formTitle;
            var newFormData={mode:0,};
            $http.post('/setting/user/getAllActionsAndSelectedActions/'+id,newFormData).then
            (function pSuccess(response)
            {
                console.log(response.data);
                $scope.ActionsData= response.data;
                $data= response.data;
                arrayLenght=$data.length;
                id_array=[];
                for(i=0;i<=arrayLenght-1;i++)
                {
                    if ($data[i]['Selected']==1)
                        id_array.push($data[i]['id']);
                }
                console.log(id_array);
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.setAction=function(id)
        {
            $scope.showWaiting=true;
            var CheckRoleAction={
                roleID:$scope.roleID,
                actionID :id
            };

            $http.post('/setting/user/CheckRoleAction',CheckRoleAction).then
            (function pSuccess(response)
            {
                console.log(response.data);
                $scope.showWaiting=false;

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.closeEditDimmer=function()
        {
            $scope.Dmr_New_Edit_Roles=false;
            $('#Dimmer_page').dimmer('hide');
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.saveRoleActionCheckList=function()
        {
            var TaskData={roleID:$scope.roleID,actionArray:id_array};
            $http.post('/setting/user/saveRoleActionCheckList/',TaskData).then
            (function pSuccess(response)
            {

                console.log(response.data);
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.NewRole =function () {
            $scope.NewRole_box=false;
            $scope.ShowNewRole=true;
            $scope.Role_name ="";
            $scope.Role_Slug="";
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.cancel_newRole=function () {
            $scope.NewRole_box=true;
            $scope.ShowNewRole=false;
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.Save_newRole=function () {

            var NewRole={
                Role_name:$scope.Role_name,
                Role_Slug :$scope.Role_Slug
            };

            $http.post('/setting/user/addNewRole',NewRole).then
            (function pSuccess(response)
            {
                $scope.NewRole_box=true;
                $scope.ShowNewRole=false;
                getAllRoles();
                console.log(response.data);
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.delete_role=function (Roleid)
        {
            /*confirm ؟ */
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if (access)
            {
                var Role={
                    Role_id:Roleid,
                };
                $http.post('/setting/user/DeleteRole',Role).then
                (function pSuccess(response)
                {
                    if (response.data ==1)
                    {
                        getAllRoles();
                        toast_alert('Deleted','success');
                    }
                    else
                        toast_alert('Can not Delete','danger');
                    console.log(response.data);
                }), function xError(response)
                {
                    toast_alert(response.data,'danger');
                }
            }
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.show_user_role=function (show_user_role,userID,username,title)
        {
            $scope.selected2=show_user_role;
            $scope.Dmr_new_edit_user_roles=true;
            $scope.Dmr_New_Edit_Roles=false ;
            $scope.FormTitle=lbl_setting_Edit;

            $scope.showUserRole_id=show_user_role;
            $scope.userID=userID;
            $scope.userName=username;
            $scope.customeroleTitle=title;


            //  $scope.selected2=show_user_role ;
            $scope.roleList=$scope.RolesData;

            $('#Dimmer_page').dimmer('show');
        }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.selectss=function () {
            // alert($scope.selected2)
            // $val=$("input[type='radio'][name='selected2']:checked");

            var selValue = $('input[name=selected2]:checked').val();

            var Role={
                userID:$scope.userID,
                selValue : selValue ,
                customeroleTitle : $scope.customeroleTitle

            };

            $http.post('/setting/user/editUserRole',Role).then
            (function pSuccess(response)
            {
                getAllUserRoles();
                $('#Dimmer_page').dimmer('hide');
                $scope.Dmr_new_edit_user_roles=false;
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }

            // alert($scope.userID+'__'+selValue);
        }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $scope.NewUser=function () {
             $scope.NewUser_box=true;
        }

      $scope.cancel_newUser=function () {
             $scope.NewUser_box=false;
             $('#userForm')[0].reset();
        }


        $scope.resetForm = function() {
            $('#userForm')[0].reset();
        };


        $scope.Save_newUser=function (isvalid) {
            if (isvalid)
            {
                arg={
                    username: username=$scope.username,
                    usernameID:$scope.usernameID,
                    roleid :$scope.roleTitle,
                    password:$scope.password
                }
                $http.post('/setting/user/AddnewUser',arg).then
                (function pSuccess(response)
                {
                    if (response.data=='User Successfully Added')
                    {
                        toast_alert('کاربر جدید اضافه شد ','success');
                        getAllUserRoles();
                        $scope.resetForm();
                        $scope.NewUser_box=false;
                    }
                    else if (response.data=='duplicated')
                        toast_alert('شناسه کاربری تکراری است ','danger');

                }), function xError(response)
                {
                    toast_alert(response.data,'danger');
                }
            }
            else
            {
                toast_alert('Form is Invalid ','danger');
            }
        }

        $scope.set_user_delete=function (rowID,role_details) {
            /*confirm ؟ */
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if (access && role_details!='administrator' )
            {
                arg={
                    userActionRoleID: rowID,
                }
                $http.post('/setting/user/set_user_delete',arg).then
                (function pSuccess(response)
                {
                    if (response.data)
                        getAllUserRoles();


                }), function xError(response)
                {
                    toast_alert(response.data,'danger');
                }
            }
            else if (role_details =='administrator')
            {
                toast_alert(message_CantDeleteAdmin,'warning');
            }

        }


        $scope.showPassFiealds=function (userID) {
            $(".subrowz").addClass('hidden');
            $("#editRow"+userID).removeClass('hidden');
            $scope.currentID=userID;
        }

//--------------------------------------------------------
        $scope.changeUserPassword=function (isvalid) {

           if (isvalid)
           {
               arg={
                   userID: $scope.currentID,
                   password:$("#PASsword"+$scope.currentID).val()
               }
               $http.post('/user/setting/changePassword',arg).then
               (function pSuccess(response)
               {
                   if (response.data)
                   {
                       toast_alert(message_changedPassword,'success');
                       $(".subrowz").addClass('hidden');
                   }
                   else
                       toast_alert(error_message,'danger');
               }), function xError(response)
               {
                   toast_alert(response.data,'danger');
               }
           }
        }

        $scope.CancelChangePass=function () {
            $(".subrowz").addClass('hidden');
        }


    }]);
