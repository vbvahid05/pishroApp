

/*##################### all-custommers.blade.php  ###########################################################*/
/*##################### all-custommers.blade.php  ###########################################################*/
          var app = angular.module('AllcustommerApp', ['simplePagination']);
          app.controller('AllcustommerCtrl', ['$scope', '$http','Pagination',
          function($scope, $http,Pagination)
          {
            var deleteMessage="انتقال به زباله دان ؟";
            var RestoreMessage="آیتم بازگردانده شود ؟";
            var fullDelete="آیتم مورد نظر شما به صورت کامل حذف شود ؟";
  /* -----------------------------------------*/

  /*---------GET ALL CUSTOMMERS ------------------------------------------------------*/
        function get_all_custommers(action)
        {

          $(".MainLoading").addClass("show");
          if (action==0 )
            {
                urlString=  "/services/all-custommers";
                $("#ShowAll").addClass("active");
                $("#ShowTrashed").removeClass("active");
                $scope.inAllDatalist=true;
                $scope.inTrashlist=false;
                $scope.BtnTrashProducts=true;$scope.BtnDeleteProducts=false;$scope.BtnRestoreProducts=false;
            }
          else
           {
                urlString=  "/services/all-Trashed-custommers";
                $("#ShowTrashed").addClass("active");
                $("#ShowAll").removeClass("active");
                $scope.inAllDatalist=false;
                $scope.inTrashlist=true;

                $scope.BtnDeleteProducts=true;$scope.BtnTrashProducts=false;$scope.BtnRestoreProducts=true;
           }
            $http({
                    method:"GET",
                    url:urlString
                 }).then (function getsuccess(response)
                            {
                              $scope.allcustommers=response.data;
                              $scope.pagination = Pagination.getNew(10);
                              $scope.pagination.numPages = Math.ceil($scope.allcustommers.length/$scope.pagination.perPage);
                                $(".MainLoading").removeClass("show");
                            },function  getErorr(response)
                            {
                            }
                          );
        }
        get_all_custommers(0);

        $scope.get_all_custommers_data=function (action)
        {
            get_all_custommers(action);
          //  $scope.publicNotificationMessage="";
        }

    /*------MOVE CUSTOMMER TO TRASH BY change DELETE FLAG-----------------------------*/

              $scope.Trash_Restore_delete = function($id,action)
              {
                  //
                  if  (action==0)   message=RestoreMessage;
                  if  (action==1)   message=deleteMessage;
                  if  (action==3)   message=fullDelete;
                  /*confirm ؟ */
                  access=false;
                  var r = confirm(message);
                  if (r == true) {access=true;} else {access=false; }
                  //----------------
                  if (access)
                  {
                      var cid=$id.toString();
                      var newFormData=
                          {
                              customerIdSelect:cid,
                              actionToken:action
                          };
                      $http.post('/services/Trash_Restore_delete',newFormData).then
                      (function xSuccess(response){
                          if (response.data =="1")
                          {
                              $( "#row"+$id ).hide(1000);
                              $( "#delete_msg" ).show(500);$( "#delete_msg" ).hide(1000);
                              toast_alert(deleted_Message,'success');
                          }
                          else if (response.data =="2")
                          {
                              $( "#row"+$id ).hide(1000);
                              $( "#delete_msg" ).show(500);$( "#delete_msg" ).hide(1000);
                              toast_alert(row_Restored_message,'success');
                          }
                          else
                          {
                              switch (response.data)
                              {
                                  case "-1":
                                      toast_alert(delete_Error_Message_CustommerInUse_invoice,'warning');
                                      break;
                                  case "-2":
                                      toast_alert(delete_Error_Message_CustommerInUse_stockrequest,'warning');
                                      break;
                                  case "-3":
                                      toast_alert(delete_Error_Message_CustommerInUse_invoice_stockrequest,'warning');
                                      break;
                              }
                          }
                      }), function xError(response)
                      {
                          console(response.data);
                      }
                  }
              };
  /*------------------------------checked checkbox--------------------------------*/
            $scope.checkall=function ()
            {
                $("#checkall").change(function(){
                  var checked = $(this).is(':checked');
                  if(checked){
                    $(".checkbox").each(function(){
                      $(this).prop("checked",true);
                    });
                  }else{
                    $(".checkbox").each(function(){
                      $(this).prop("checked",false);
                    });
                  }
                });
            }
  /*------------------------------------------------------------------------*/
            $scope.GroupTrash_Restore_fullDelete=function (action)
            {
              if (action==0){url="/services/Custommer_RestoreFromTrash";message=RestoreMessage;}
              if (action==1){url="/services/Custommer_moveSelectedToTrash";message=deleteMessage;}
              if (action==3){url="/services/Custommer_fullDelete";message=fullDelete;}
              /*confirm ؟ */
                access=false;
                 var r = confirm(message);
                 if (r == true) {access=true;} else {access=false; }
             //----------------
              if (access)
              {
                  var id_array =[];
                  $(".checkbox:checked").each(function() {
      		          id_array.push($(this).val());
      	           });

                  $http.post(url,id_array).then(function xSuccess(response)
                   {
                        $.each(id_array, function (index, value) {
                             $( "#row"+value ).hide(1000);
                        });

                   }), function xError(response)
                   {
                     alert('error');
                   }
              }
            }

              $scope.changePagin=function ($num)
              {
                $http({
                        method:"GET",
                        url:"/services/all-custommers"
                     }).then (function getsuccess(response)
                                {
                                  $scope.allcustommers=response.data;
                                  $scope.pagination = Pagination.getNew($num);
                                  $scope.pagination.numPages = Math.ceil($scope.allcustommers.length/$scope.pagination.perPage);
                                    $(".MainLoading").removeClass("show");
                                },function  getErorr(response)
                                {
                                }
                              );
              }
  /*-----------*/
          }]); //controller
/*__________________________ all-custommers.blade.php  _____________________________________________*/

/*##################### custommers.blade.php  ###########################################################*/
/*##################### custommers.blade.php  ###########################################################*/
    var app = angular.module('custommerApp', []);
    app.controller('custommerCtrl', function($scope, $http)
    {
      //  Messages
      var recordAdded="درج شد";
      var enterName="نام را وارد کنید";
      var enterLastName ="نام خانوادگی را وارد کنید";
      var enterMobileNumber ="شماره تلفن همراه را وارد کنید";
      var enterMobileNumberValid="شماره تلفن همراه را به صورت صحیح وارد نمایید - 12 رقمی"
      var MobileNumberDuplicate ="شماره موبایل تکراری است ";
      var enterCodeMelli ="کد ملی را وارد بفرمایید ";
      var enterValidCodeMelli ="کد ملی را به صورت صحیح وارد کنید (10رقمی)";
      var orgNameIsDuplicated="نام سازمان تکراری است ";

      //Public Function
      function toast_alert(message,status)
      {
       $(".publicNotificationMessage").removeClass("ng-binding");

        if (status=='success')
        {
           $(".publicNotificationMessage").show();
           $(".publicNotificationMessage").removeClass("alert alert-warning");
           $(".publicNotificationMessage").removeClass("alert alert-danger");
           $(".publicNotificationMessage").addClass("alert alert-success");
        }
       if (status=='danger')
        {
          $(".publicNotificationMessage").show();
          $(".publicNotificationMessage").removeClass("alert alert-success");
          $(".publicNotificationMessage").removeClass("alert alert-warning");
          $(".publicNotificationMessage").addClass("alert alert-danger");
        }
        if (status=='warning')
         {
           $(".publicNotificationMessage").show();
           $(".publicNotificationMessage").removeClass("alert alert-success");
           $(".publicNotificationMessage").removeClass("alert alert-danger");
           $(".publicNotificationMessage").addClass("alert alert-warning");
         }
        //$scope.publicNotificationMessage=message;
        $(".publicNotificationMessage").html(message);
        $(".publicNotificationMessage").delay(3000).hide(100);
      }
      //-------------------------

      $scope.addNewPerson=function()
      {
        $alert="";
        $status=true;
          var newFormPerson={
            custommer_first_name:$scope.first_name,
            custommer_last_name:$scope.last_name,
            custommer_codeMelli:$scope.codeMelli,
            custommer_tel:$scope.custommer_tel,
            custommer_Mobile:$scope.custommer_Mobile,
            custommer_email:$scope.custommer_email,
            custommer_address:$scope.custommer_address,
            custommer_postalcode:$scope.custommer_postalcode,
          };
          //-------
            var cMobile = newFormPerson['custommer_Mobile'];
        ;

              if (newFormPerson['custommer_first_name'] ===undefined )  {$alert=$alert+enterName +"<br/>"; $status=false;}
              if (newFormPerson['custommer_last_name'] ===undefined)  {$alert=$alert+enterLastName +"<br/>";$status=false;}
              // if (newFormPerson['custommer_Mobile'] ===undefined)  {$alert=$alert+enterMobileNumber +"<br/>";$status=false;}
              //   else if (cMobile.length <=10 )  { $alert=$alert+ enterMobileNumberValid+"<br/>";$status=false;}
             if ($status)
                {
              //-------
                $http.post('/services/addNewPerson',newFormPerson).then(
                function xSuccess(response)
                 {
                   if (response.data ==100)
                   {
                       toast_alert(MobileNumberDuplicate,'danger');
                   }
                  else
                     {
                         toast_alert(recordAdded,'success');
                         $scope.first_name="";
                         $scope.last_name="";
                         $scope.codeMelli="";
                         $scope.custommer_tel="";
                         $scope.custommer_Mobile="";
                         $scope.custommer_email="";
                         $scope.custommer_address="";
                         $scope.custommer_postalcode="";
                         window.location.href ='/all-custommers';
                     }

                 });
              }
              else
              {
                toast_alert($alert,'danger');
              }
       }
//----------------
       $scope.addNewOrganization=function()
       {
           $alert="";
           $status=true;
           var arg = {
               org_name: $scope.org_name,
               org_tel: $scope.org_tel,
               org_codeeghtesadi: $scope.org_codeeghtesadi,
               org_postalCode: $scope.org_postalcode,
               org_address: $scope.org_address
           }
            if (arg['org_name'] ===undefined ) {$alert=$alert+Message_OrgName +"<br/>"; $status=false;}
            if (arg['org_tel'] ===undefined )  {$alert=$alert+Message_Tel +"<br/>"; $status=false;}

           if ($status)
           {
               $http.post('/services/addOrg',arg).then(
                   function xSuccess(response)
                   {
                       if (response.data ==100)
                       {
                           toast_alert(MobileNumberDuplicate,'danger');
                       }
                       else
                       {
                           toast_alert(recordAdded,'success');
                           $scope.org_name="";
                           $scope.org_tel="";
                           $scope.org_codeeghtesadi="";
                           $scope.org_postalCode="";
                           $scope.org_address="";
                       }
                   });
           }
           else
               toast_alert($alert,'danger');

       }




       //
       //     msg="";
       //     if($scope.org_name =='' || $scope.org_name ==null)
       //         msg=Message_OrgName;
       //     if ($scope.org_tel =='' || $scope.org_tel ==null)
       //         msg="* "+msg+'<br/>'+"* "+Message_Tel;
       //     if(msg !="")
       //         toast_alert(msg,'warning');
       //     else {
       //         arg = {
       //             org_name: $scope.org_name,
       //             org_codeeghtesadi: $scope.org_codeeghtesadi,
       //             org_tel: $scope.org_tel,
       //             org_postalCode: $scope.org_postalcode,
       //             org_address: $scope.org_address
       //         }
       //         console.log(arg);
       //     }
       //     $http.post('/services/addOrg',arg).then
       //     (function xSuccess(response)
       //     {
       //         alert(response.data);
       //          $scope.org_name="";
       //          $scope.org_codeeghtesadi="";
       //          $scope.org_tel="";
       //          $scope.org_postalcode="";
       //          $scope.org_address="";
       //          toast_alert(Seved_Message,'success')
       //     }), function xError(response)
       //     {
       //         toast_alert(error_message,'danger');
       //         console.log(response.data)
       //     }
       // }
//--------------------------------

     function GetAll_NullORG_Custommers()
     {
       $(".MainLoading").addClass("show");
       $http({
       method:"GET",
       url:"/services/all-custommersNullORG"
       }).then (function getsuccess(response)
       {
         $scope.allCustommers=response.data;
           $(".MainLoading").removeClass("show");
       });
     }

//--------------------------------
      function  get_org_data()
      {
         $(".MainLoading").addClass("show");
         $http(
           {
             method : "GET",
             url : "services/orgName"
           }).then(function mySuccess(response)
            {
                $scope.values=response.data;
                $scope.AllOrganisations=response.data;
                  $(".MainLoading").removeClass("show");
                //$scope.statuscode = response.status;
             }, function myError(response)
             {
           //   $scope.values = response.statusText;
             });
        }

//-------------------------------------
         function get_all_posts_in_org ()
         {
           $(".MainLoading").addClass("show");
           $http(
             {
               method : "GET",
               url : " /services/orgPostinORG"
             }).then(function mySuccess(response)
              {
                  $scope.Allposts=response.data;
                    $(".MainLoading").removeClass("show");
                  //$scope.statuscode = response.status;
               }, function myError(response)
               {
             //   $scope.values = response.statusText;
               });
         }

//-----------------------------------------------
  $scope.LoaderPersonInOrganization=function()
  {
    GetAll_NullORG_Custommers();
    get_all_posts_in_org ();
    get_org_data();
  }
//-------------------------------------------
$scope.updateCustommerInfo=function()
{
  alert="";
  $status=true;
  $(".MainLoading").addClass("show");
  var newFormData={
    custommerInfo_custommerid:$scope.custommerid,
    custommerInfo_custommerOrgId:$scope.custommerOrgId,
    custommerInfo_postInOrg:$scope.postInOrg,
    custommerInfo_tel_inOrg:$scope.tel_inOrg,
    custommerInfo_desc:$scope.desc,
  };

  if (newFormData['custommerInfo_custommerid']    ===undefined )  {alert=alert+MessageDefine_Custommer +"<br/>"; $status=false;}
  if (newFormData['custommerInfo_custommerOrgId'] ===undefined )  {alert=alert+MessageDefine_Org +"<br/>"; $status=false;}
  if (newFormData['custommerInfo_postInOrg']      ===undefined )  {alert=alert+MessageDefine_Post +"<br/>"; $status=false;}

  if ($status)
   {  $http.post('/services/Custommer_updateCustommerInfo',newFormData).then(function xSuccess(response)
        {
         toast_alert(recordAdded,'success');
           $(".MainLoading").removeClass("show");
        });
   }
   else
   {
       $(".MainLoading").removeClass("show");
     toast_alert(alert,'danger');
   }
}
//-------------------------------------------


      $scope.addOrgtoDB = function() //add Click
            {
              var newFormData={
                org_name:$scope.newORGname,
                org_tel:$scope.neworg_tel,
                org_address:$scope.neworg_address,
                org_postalCode:$scope.neworg_postalCode,
                org_codeeghtesadi:$scope.newoorg_codeeghtesadi,
              };
              $http.post('/services/addOrg',newFormData).then(function xSuccess(response)
               {
                   //$scope.statuscode = response.status;
                   get_org_data();
                   $scope.messageng = true;
                   $('#messageBar').show();
                   $scope.message="درج شد ";
                   $('#messageBar').delay(500).fadeOut('slow');
                     $(".MainLoading").removeClass("show");
                   $scope.newORGname="";$scope.neworg_tel="";$scope.neworg_address="";$scope.neworg_postalCode="";$scope.newoorg_codeeghtesadi="";
                   $('#newORGform').dimmer('hide');

              }, function xError(response)
              {
                 get_org_data();
                $('#messageBarDanger').show();
                $scope.messageng_Danger = true;
                $scope.messageDanger="بروز خطا";
                  $(".MainLoading").removeClass("show");
               $('#messageBarDanger').delay(2000).fadeOut('slow');

            //   $scope.values = response.statusText;
              });

            }

              $scope.cancel_new_org= function()
              {
                 $scope.newORGname="";
                 $('#newORGform').dimmer('hide');
              }
    });

 /*__________________________ all_Orgs.blade.php  _____________________________________________*/
/*__________________________ ALL Organizations List  _____________________________________________*/

var app = angular.module('AllOrgApp', ['simplePagination']);
app.controller('AllOrgCtrl', ['$scope', '$http','Pagination',
    function($scope, $http,Pagination)
    {

        //---------
        function SelectDimmer(dimmer)
        {
            switch(dimmer) {
                case 'test':
                    $scope.Tets_in_Dimmer = true;
                    break;
                case 'edit':
                    $scope.FormTitle = lbl_edit_org_info;
                    $scope.formStatus = 'edit';
                    $scope.section_new_edit_Organization_in_Dimmer = true;
                    // $scope.add_ProductToOrder_in_Dimmer = false;
                    // $scope.add_A_PartToChassis_in_Dimmer = false;
                    break;
            }
        }
        //..................
        function get_all_Orgs(mode)
        {
            if (mode) //Deleted
            {
                $scope.inTrashlist=true;
                $scope.inAllDatalist=false;
                $("#ShowTrashed").addClass("active");
                $("#ShowAll").removeClass("active");

                $scope.BtnDeleteProducts=true;
                $scope.BtnRestoreProducts=true;
                $scope.btn_edit=false;
                $scope.btn_move_trash=false;
            }
            else //viewables
            {  $scope.inAllDatalist=true;
                $scope.inTrashlist=false;
                $("#ShowAll").addClass("active");
                $("#ShowTrashed").removeClass("active");

                $scope.btn_edit=true;
                $scope.btn_move_trash=true;
                $scope.BtnRestoreProducts=false;
                $scope.BtnDeleteProducts=false;
            }
            //$scope.loading =true;
            $(".MainLoading").addClass("show");

            var Args={mode:mode};
            $http.post('/services/all-ORG-data',Args).then
              (function getsuccess(response)
                {
                    console.log(response.data);
                     $scope.allRows=response.data;
                    $scope.pagination = Pagination.getNew(10);
                    $scope.pagination.numPages = Math.ceil($scope.allRows.length/$scope.pagination.perPage);
                    $(".MainLoading").removeClass("show");
                },function  getErorr(response)
                {
                    console.log(response.data);
                    if(response.data['message']=="Unauthenticated.")
                        window.location.href = "/login";
                }
            );
        }
        get_all_Orgs(0);
//----------------
        $scope.get_all_Orgs=function(mode)
        {
            get_all_Orgs(mode);
        }
//--------------------
        $scope.ShowEdit_dimmer=function(Org_id)
        {
            if (Org_id !=0) //EDIT
            {
                $scope.editORGinfoBTN=true;
                $scope.newORGinfoBTN=false;
                SelectDimmer('edit');
                $('#Dimmer_page').dimmer('show');

                var Args={
                    t:"xeOrGkReeqDlrsz",
                    mode:0,
                    key:"id",
                    value:Org_id
                }
                $http.post('/Publicservices/relatedDatalist',Args).then
                (function xSuccess(response){
                    data=response.data;
                    $scope.org_id=Org_id;
                    $scope.organization_name=data[0].org_name;
                    $scope.codeghtesadi=parseInt(data[0].org_codeeghtesadi);
                    $scope.tel=parseInt(data[0].org_tel);
                    $scope.postalcode=parseInt(data[0].org_postalCode);
                    $scope.address=data[0].org_address;

                }), function xError(response)
                {
                    toast_alert(error_message,'danger')
                }
            }
            else //NEW
            {
                //**INIT
                $scope.newORGinfoBTN=true;
                $scope.editORGinfoBTN=false;
                //------
                $scope.organization_name="";
                $scope.codeghtesadi="";
                $scope.tel="";
                $scope.postalcode="";
                $scope.address="";
                //--------
                SelectDimmer('edit');
                $('#Dimmer_page').dimmer('show');
                //--------
            }
        }
//-----------
        $scope.editORGinfo=function(orgid)
        {
                msg = "";
                if ($scope.organization_name == '' || $scope.organization_name == null)
                    msg = Message_OrgName;
                if ($scope.tel == '' || $scope.tel == null)
                    msg = "* " + msg + '<br/>' + "* " + Message_Tel;

                if (msg != "")
                    toast_alert(msg, 'warning');
                else {
                    arg = {
                        orgID: orgid,
                        org_name: $scope.organization_name,
                        org_codeeghtesadi: $scope.codeghtesadi,
                        org_tel: $scope.tel,
                        org_postalCode: $scope.postalcode,
                        org_address: $scope.address
                    }

                    if (orgid!=0) //Just EDIT Item
                    {
                        $http.post('/services/UpdateOrg', arg).then
                        (function xSuccess(response) {
                            get_all_Orgs(0);
                            $('#Dimmer_page').dimmer('hide');

                        }), function xError(response) {
                            toast_alert(error_message, 'danger');
                            console.log(response.data)
                        }
                    }
                    else  //is a  NEW  Item
                    {
                        $http.post('/services/addOrg',arg).then
                        (function xSuccess(response)
                        {
                          if (response.data=='ok')
                          {
                              toast_alert(Seved_Message,'success')
                              get_all_Orgs(0);
                              $('#Dimmer_page').dimmer('hide');
                          }
                        }), function xError(response)
                        {
                            toast_alert(error_message,'danger');
                            console.log(response.data)
                        }
                    }


                  }
        }
//---------------
        $scope.close_dimmer=function()
        {
            $scope.organization_name="";
            $scope.codeghtesadi="";
            $scope.tel="";
            $scope.postalcode="";
            $scope.address="";
            $('#Dimmer_page').dimmer('hide');

        }

//----------------
    $scope.trashAction=function(action ,Orgid)
    {
        switch (action)
        {
            case 'del' :  msg=deleteMessage; break;
            case 'hardDel': msg=Q_Full_delete_Message ;break;
            case 'reStore': msg=Q_Restor_Message ;break;
        }
        var r = confirm(msg);
        if (r == true) {access=true;} else {access=false; }

        if (access)
        {
            arg = {
                orgID: Orgid,
                Action :action
            }

            $http.post('/services/trashAction',arg).then
                (function xSuccess(response)
                {
                    switch (action)
                    {
                      case 'del' :
                          if (response.data=="InUseId")
                              toast_alert(delete_error_forDeleteOrganizationFirstDeleteCustommer,'warning')
                          else
                               toast_alert(deleted_Message,'success');
                               get_all_Orgs(0);
                      break;
                      case 'reStore' :
                          toast_alert(row_Restored_message,'success');
                          get_all_Orgs(1);
                      break;
                      case 'hardDel' :
                          toast_alert(Full_delete_Message,'success');
                          get_all_Orgs(1);
                      break;
                    }
                }), function xError(response)
                {
                    // toast_alert(error_message,'danger');
                    // console.log(response.data)
                }
        }
    }





        //
        //
        //
        // if (r == true) {access=true;} else {access=false; }
        //
        // if (action == 'del' && access==true) {
        //     $http.post('/services/SoftDeleteOrg',arg).then
        //     (function xSuccess(response)
        //     {
        //         if (response.data=="InUseId")
        //             toast_alert(delete_error_forDeleteOrganizationFirstDeleteCustommer,'warning')
        //         else
        //             toast_alert(deleted_Message,'success')
        //         get_all_Orgs(0);
        //     }), function xError(response)
        //     {
        //         toast_alert(error_message,'danger');
        //         console.log(response.data)
        //     }    }







    }]); //controller


