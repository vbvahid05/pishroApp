
/*#####################  allProducts.blade.php  ###########################################################*/
/*##################### allProducts.blade.php  ###########################################################*/
          var app = angular.module('productsApp', ['simplePagination']);
/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
          app.filter('pTypeCat', function() {
              return function(rypecatid) {
                return  PublicF_AppFilter_pTypeCat(rypecatid);
              };
          });

  /*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
          app.controller('productsCtrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
 {
    var deleteMessage="Move to Trah?";
    var fullDeleteMessage="Delete from Database?!";
    var restoreMessage="Restore From Trash?";
    /*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/





    function toast_is_Dublicate()
    {
    $(".publicNotificationMessage").show();
    $(".publicNotificationMessage").removeClass("alert alert-success");
    $(".publicNotificationMessage").addClass("alert alert-danger");
    $scope.publicNotificationMessage='اطلاعات وارد شده تکراری است ';
    $(".publicNotificationMessage").delay(3000).hide(100);
    }
    function toast_item_Added()
    {
    $(".publicNotificationMessage").show();
    $(".publicNotificationMessage").removeClass("alert alert-danger");
    $(".publicNotificationMessage").addClass("alert alert-success");
    $scope.publicNotificationMessage='درج شد'
    $(".publicNotificationMessage").delay(3000).hide(100);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    /*---------GET ALL Products ------------------------------------------------------*/
    function get_all_products(currentPage,pagein)
    {
        $(".MainLoading").addClass("show");
        var queries = {};
        $.each(document.location.search.substr(1).split('&'),function(c,q){
           if (q)
           {
               var i = q.split('=');
               queries[i[0].toString()] = i[1].toString();
           }
        });
      if (queries['recycle'])
      {
          $("#ShowTrashed").addClass("active");
          $("#ShowAll").removeClass("active");
          $scope.inTrashlist=true;
          $scope.inAllDatalist=false;
      }else
      {
          $("#ShowTrashed").removeClass("active");
          $("#ShowAll").addClass("active");

          $scope.inTrashlist=false;
          $scope.inAllDatalist=true;
      }
    $scope.formData = {}; // checked set defult radio Button in Product_type_cat

    //window.listStatusFlag = "all";
    $scope.BtnTrashProducts=true;$scope.BtnDeleteProducts=false;
    $scope.BtnRestoreProducts=false;
/*

    $http({
    method:"GET",
    url:"/services/all-products"
    //  url:"http://pishro.store/api/"
    }).then (function getsuccess(response)
    {
    $scope.allproducts=response.data;
    $scope.pagination = Pagination.getNew(pagein);
    $scope.pagination.numPages = Math.ceil($scope.allproducts.length/$scope.pagination.perPage);
        if (currentPage !='') $scope.pagination.page=currentPage;
    $(".MainLoading").removeClass("show");
    },function  getErorr(response)
    {
       if(response.data['message']=="Unauthenticated.")
          window.location.href = "/login";
    }
    );
    */
    }
     get_all_products(0,50);

	//-------------
	 $scope.changePagin=function ($num)
              {

                  get_all_products(0,10000);
                // $http({
                //         method:"GET",
                //         url:"/services/all-products"
                //      }).then (function getsuccess(response)
                //                 {
                //                   $scope.allcustommers=response.data;
                //                   $scope.pagination = Pagination.getNew($num);
                //                   $scope.pagination.numPages = Math.ceil($scope.allcustommers.length/$scope.pagination.perPage);
                //                     $(".MainLoading").removeClass("show");
                //                 },function  getErorr(response)
                //                 {
					// 				 if(response.data['message']=="Unauthenticated.")
					// 				 window.location.href = "/login";
                //                 }
                //               );
              }
	//-------------
	
    $scope.ShowAllProducts=function ()
    {
        $(location).attr('href', '/stock/allproducts')
        $('#ShowAll').addClass('active')
    // get_all_products(0,50);
    // $scope.publicNotificationMessage="";
    }
    /* -------------- Get All products From Trash -------------------------------------------*/
    function get_Trashed_products()
    {

    $(location).attr('href', '/stock/allproducts?recycle=1')
    $("#ShowTrashed").addClass("active");
    $("#ShowAll").removeClass("active");
    // $scope.inTrashlist=true;
    // $scope.inAllDatalist=false;
    //
    // $scope.BtnDeleteProducts=true;$scope.BtnTrashProducts=false;
    // $scope.BtnRestoreProducts=true;
    // $(".MainLoading").addClass("show");
    // $http({
    // method:"GET",
    // url:"/services/stock/all-trashed-products"
    // //  url:"http://pishro.store/api/"
    // }).then (function getsuccess(response)
    // {
    // $scope.allproducts=response.data;
    // $scope.pagination = Pagination.getNew(10);
    // $scope.pagination.numPages = Math.ceil($scope.allproducts.length/$scope.pagination.perPage);
    // $(".MainLoading").removeClass("show");
    // },function  getErorr(response)
    // {
    // }
    // );
    }

    $scope.ShowTrashedProducts=function ()
    {
    get_Trashed_products();
    }

    /*------MOVE product TO TRASH BY change DELETE FLAG-----------------------------*/
    $scope.moveToTrash = function($id)
     {
        /*confirm ؟ */
        access=false;
        var r = confirm(deleteMessage);
        if (r == true) {access=true;} else {access=false; }
        //----------------
        if (access)
        {
            var cid=$id.toString();
            var newFormData=
            {
                productIdSelect:cid,
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

            $http.post('/services/stock/moveToTrash',newFormData).then
            (function xSuccess(response){
               if (response.data=='InUse')
                  toast_alert(delete_Error_Message_ProductInUse,'warning');
                else
               {
                   toast_alert(deleted_Message,'success');
                   $( "#row"+$id ).hide(1000);
                   $( "#delete_msg" ).show(500);$( "#delete_msg" ).hide(1000);
               }

            }), function xError(response)
            {
            alert('Faild');
            //   console.log(JSON.stringify(jqXHR));
            //   console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        }
    };
    /*------Restore Single Product From TRASH Full DELETE -----------------------------*/
    $scope.RestoreFromTrash = function($id)
    {
    /*confirm ؟ */
    access=false;
    var r = confirm(restoreMessage);
    if (r == true) {access=true;} else {access=false; }
    //----------------
    if (access)
    {
    var cid=$id.toString();
    var newFormData=
    {
    productIdSelect:cid,
    };

    $http.post('/services/stock/RestoreFromTrash',newFormData).then
    (function xSuccess(response){
    $scope.delete_message="delete";

    //   alert('Success');
    $( "#row"+$id ).hide(1000);
    $( "#delete_msg" ).show(500);$( "#delete_msg" ).hide(1000);


    }), function xError(response)
    {
    alert('Faild');
    //   console.log(JSON.stringify(jqXHR));
    //   console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
    }
    };
    /*------------------------------checked checkbox--------------------------------*/
    $scope.checkall=function ($id)
    {

       $("#checkall"+$id).change(function()
       {
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
    $scope.moveGroupToTrash=function ()
    {
    /*confirm ؟ */
    access=false;
    var r = confirm(deleteMessage);
    if (r == true) {access=true;} else {access=false;  }
    //----------------
    if (access)
    {
    var id_array =[];
    $(".checkbox:checked").each(function() {
    id_array.push($(this).val());
    });

    $http.post('/services/stock/moveSelectedGroupToTrash',id_array).then(function xSuccess(response)
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
    /*------------------------------------------------------------------------*/
    $scope.RestoreGroupFromTrash=function ()
    {
    /*confirm ؟ */
    access=false;
    var r = confirm(restoreMessage);
    if (r == true) {access=true;} else {access=false;  }
    //----------------
    if (access)
    {
    var id_array =[];
    $(".checkbox:checked").each(function() {
    id_array.push($(this).val());
    });

    $http.post('/services/stock/RestoreGroupFromTrash',id_array).then(function xSuccess(response)
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
    /*-------------------Full Delete From Database*/
    $scope.DeleteFromDataBase=function ($id)
    {

    /*confirm ؟ */
    access=false;
    var r = confirm(fullDeleteMessage);
    if (r == true) {access=true;} else {access=false; }
    //----------------
    if (access)
    {
    var cid=$id.toString();
    var newFormData=
    {
    productIdSelect:cid,
    };

    $http.post('/services/stock/DeleteProductFromDataBase',newFormData).then
    (function xSuccess(response){
    $scope.delete_message="delete";

    //   alert('Success');
    $( "#row"+$id ).hide(1000);
    $( "#delete_msg" ).show(500);$( "#delete_msg" ).hide(1000);


    }), function xError(response)
    {
    alert('Faild');
    //   console.log(JSON.stringify(jqXHR));
    //   console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
    }
    }
    /*--------delete_selected_products_Group*/

    $scope.delete_selected_products=function ()
    {
    /*confirm ؟ */
    access=false;
    var r = confirm(fullDeleteMessage);
    if (r == true) {access=true;} else {access=false;  }
    //----------------
    if (access)
    {
    var id_array =[];
    $(".checkbox:checked").each(function() {
    id_array.push($(this).val());
    });

    $http.post('/services/stock/DeleteSelectedGroupFromDatabase',id_array).then(function xSuccess(response)
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


    /*##################### Product.blade.php  ###########################################################*/
    /*##################### Product.blade.php  ###########################################################*/

    $scope.onloadProductPage=function()
    {
    get_all_Brands();
    //get_all_Types(0);
    $scope.formData = {};$scope.formData.Product_type_cat="1"; // checked set defult radio Button in Product_type_cat
    }
    /*---------GET ALL Brands ------------------------------------------------------*/
    function get_all_Brands()
    {
    $http({
    method:"GET",
    url:"/service/stock/getProductBrands"

    }).then (function getsuccess(response)
    {
    $scope.AllBrands=response.data;
    },function  getErorr(response)
    {
    }
    );
    }
    //get_all_Brands();
    /*---------GET ALL Brands ------------------------------------------------------*/
      //    get_all_Types();

    $scope.updateTypeList=function()
    {
    brandId=$scope.selectedItem;
    get_all_Types(brandId);
    $( ".Product_Type .text.ng-binding" ).empty();

    }
    /*---------edit Product in Dimmer ------------------------------------------------------*/

    $scope.editProduct=function($productId)
    {
    //   $(".MainLoading").addClass("show");
       $('#editProduct').dimmer('show');
       var cid=$productId.toString();
       var newFormData=
       {
        productIdSelect:cid,
    };
       $http.post('/service/stock/getProductData',newFormData).then
       (function pSuccess(response){
       $product=response.data;
       console.log($product);
       $scope.thisProductID=$product[0].id;
       $scope.inpt_roduct_PartNumber_comersial=$product[0].stkr_prodct_partnumber_commercial;
       $scope.inpt_Product_title=$product[0].stkr_prodct_title;
       $scope.inpt_unitPrice= Number( $product[0].stkr_prodct_price);
       $scope.inpt_tadbir_stock_id=$product[0].stkr_tadbir_stock_id;

       if ($product[0].stkr_prodct_two_serial ==1 )
       $('#inpt_rodu').prop('checked', true);
       else $('#inpt_rodu').prop('checked', false);
       get_all_Brands();
       get_all_Types($product[0].stkr_prodct_brand.toString());
       //$scope.selectedType=$product[0].stkr_prodct_type;
       // In First Load
       $scope.SelectBrand=$product[0].stkr_prodct_brand.toString();
       $scope.SelectType=$product[0].stkr_prodct_type.toString();
       $scope.Product_type_cat=$product[0].stkr_prodct_type_cat.toString();
           // $product[0].stkr_prodct_type_cat.toString();

       $scope.inpt_Product_price=$product[0].stkr_prodct_price ;
       $(".MainLoading").removeClass("show");
       })
       , function xError(response)
       {
       alert('Faild');
       }
    }
     //DATA SERVICE--------------
     $scope.setRelatedPtype=function()
     {
        // alert($scope.SelectType);
         get_all_Types($scope.SelectBrand)
     }
     //---------------------------
     function get_all_Types(brandID)
     {
         if (brandID==0)   brandID="null";
         urlPath="/service/stock/getProductTypesByBrandID/"+brandID;
         $http({
             method:"GET",
             url: urlPath

         }).then (function getsuccess(response)
             {
                $scope.AllTypes=response.data;
               $scope.SelectType=$scope.SelectType.toString();  //$product[0].stkr_prodct_type.toString();
             },function  getErorr(response)
             {
             }
         );
     }


    //---------------------------

    $scope.editProduct_save=function()
    {
      // currentPage=($scope.pagination.page);
       $Product_brand=$scope.SelectBrand;
       $Product_Type=$scope.SelectType;
       $org_Product_price=$scope.inpt_unitPrice;

       if ($('#inpt_rodu').is(":checked")) {two_serial=1;}  else two_serial=0;
       $Product_type_cat =$scope.Product_type_cat;
       var newFormData=
       {
          Product_id:$scope.thisProductID,
          PartNumber_comersial:$scope.inpt_roduct_PartNumber_comersial,
          Product_title:$scope.inpt_Product_title,
          Product_brand:$Product_brand,
          org_Product_type:$Product_Type,
          Product_type_cat:$Product_type_cat,
          org_Product_price:$org_Product_price,
          prodct_two_serial:two_serial,
          tadbir_stock_id : $scope.inpt_tadbir_stock_id
       };

       $http.post('/service/stock/editUpdate_product',newFormData).then
       (function pSuccess(response){
          console.log(response.data);
         if (response.data=='partNumbetCommercial_is_dublicate')
             toast_alert('پارتنامبر تکراری است ' ,'danger');
         else {
           //  get_all_products(currentPage,10000);
             $('#editProduct').dimmer('hide');
             toast_alert('کالای مورد نظر با موفقیت ویرایش شد' ,'success');
             location.reload();
         }
    }),
              function xError(response)
              {
                  console.log(response.data)
              };

    }

    //--------------------
    $scope.editProduct_cancel=function()
    {
    $('#editProduct').dimmer('hide');
    }
    /* ------------------ Add new Product------------------------------------------------------*/
    $scope.addProductToDB=function()
    {
       if ($('#inpt_rodu').is(":checked")) {two_serial=1;}  else two_serial=0;
       //------------------------------
       $Product_brand=$("#inpr_Product_brand").val();
       $Product_Type=$("#inpr_Product_Type").val();
       $Product_type_cat =$scope.formData.Product_type_cat;
       $price=$("#inpt_Price").val();


       var $alert="";
       var $status=true;
       //---Form Data
       var newFormData={
          PartNumber_comersial:$scope.inpt_roduct_PartNumber_comersial,
          Product_title:$scope.inpt_Product_title,
          Product_brand:$Product_brand,
          org_Product_type:$Product_Type,
          Product_type_cat:$Product_type_cat,
          org_Product_price:$price,
          product_inpt_tadbir_stock_id :$scope.inpt_tadbir_stock_id,
          prodct_two_serial:two_serial,
       };

       /* Validation*/
       if (newFormData['Product_title']== null )  {$alert=$alert+" Title is requared \n"; $status=false;}
       if (newFormData['PartNumber_comersial']== null)  {$alert=$alert+" PartNumber is requared";$status=false;}
       // Validation
       if ($status)
       {
       $(".MainLoading").addClass("show");
       //--------POST
       $http.post('/service/stock/add_new_product',newFormData).then(
       function xSuccess(response)
       {
           console.log(response.data);
       /* Server Validation*/
       if (response.data =='partNumbetCommercial_is_dublicate')
       {
         $(".MainLoading").removeClass("show");
         $scope.part_numberError ='پارت نامبر تکراری است ';
         toast_alert($scope.part_numberError,'danger')
       }
       /* Server Validation*/
       else // ever things is Ok ans Successfully don...  ;)
       {
         $(location).attr('href', '/stock/allproducts')
         $(".MainLoading").removeClass("show");
       }

       }),
       function xError(response)
       {
         alert('error');
       }
       //------EOF-POST
       }
         else alert($alert);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++
    $scope.updateProductDB=function()
    {
    var $alert="";
    var $status=true;
    //Get ID
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('/');
    $id=(hashes[hashes.length-1]);
    //---Form Data
    var newFormData={
    Product_id:$id,
    PartNumber_comersial:$scope.inpt_roduct_PartNumber_comersial,
    Product_title:$scope.inpt_Product_title,
    Product_brand:$scope.inpr_Product_brand,
    org_Product_type:$scope.inpt_Product_type,
    org_Product_price:$scope.inpt_Product_price,
    };

    /* Validation*/
    if (newFormData['Product_title']== null )  {$alert=$alert+" Title is requared \n"; $status=false;}
    if (newFormData['PartNumber_comersial']== null)  {$alert=$alert+" PartNumber is requared";$status=false;}
    // Validation
    if ($status)
    {
    $(".MainLoading").addClass("show");
    //--------POST
    $http.post('/service/stock/editUpdate_product',newFormData).then(
    function xSuccess(response)
    {
    /* Server Validation*/
    if (response.data =='partNumbetCommercial_is_dublicate')
    {
    $(".MainLoading").removeClass("show");
    $( ".alert.alert-danger.ng-binding" ).show(500);
    $scope.part_numberError ='پارت نامبر تکراری است ';
    $( ".alert.alert-danger.ng-binding" ).delay(2000).hide(5000);
    }
    /* Server Validation*/
    else // ever things is Ok ans Successfully don...  ;)
    {

    $(location).attr('href', '/stock/allproducts')
    $(".MainLoading").removeClass("show");
    }

    }),
    function xError(response)
    {
    alert('error');
    }
    //------EOF-POST
    }
    else alert($alert);
    }
    /* +++++++++++++++++++++++++++++++++*/
    //Edit Product by load Product By id
    function loadProductByid()
    {
    $(".MainLoading").addClass("show");
    //-----
    var productID=
    {
    product_ID:$id,
    };
    //--------POST
    $http.post('/service/stock/getProductData',productID).then(
    function xSuccess(response)
    {
    $scope.product_details=response.data;
    $product=response.data;
    $scope.inpt_roduct_PartNumber_comersial=$product[0].stkr_prodct_partnumber_commercial;
    $scope.inpt_Product_title=$product[0].stkr_prodct_title;
    $scope.inpr_Product_brand=$product[0].stkr_prodct_brand;
    $scope.inpt_Product_type=$product[0].stkr_prodct_type;
    $scope.inpt_Product_price=$product[0].stkr_prodct_price  ;
    $(".MainLoading").removeClass("show");
    }),
    function xError(response)
    {
    alert('error');
    }
    //------EOF-POST
    };
    //Get ID
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('/');
    $id=(hashes[hashes.length-1]);
    if (parseInt($id)) loadProductByid($id);

    /*-----------*/
    /*##################### AllProduct Section AllBrands ###########################################################*/
    /* Brand Tab*/
    function  get_All_Brand_data()
    {
    $(".MainLoading").addClass("show");
    $http({
    method:"GET",
    url:"/service/stock/getProductBrands"

    }).then (function getsuccess(response)
    {
    $scope.AllBrandTabel=response.data;
    $scope.pagination = Pagination.getNew(10);
    $scope.pagination.numPages = Math.ceil($scope.AllBrandTabel.length/$scope.pagination.perPage);
    $(".MainLoading").removeClass("show");
    },function  getErorr(response)
    {
    }
    );
    }
    $scope.LoadBrandData=function()
    {
    get_All_Brand_data();
    $scope.publicNotificationMessage="";
    }

    $scope.add_New_Brand =function()
    {
    var promptNewType = prompt("عنوان برند جدید را وارد نمایید :")
    var typeArray={newBrand:promptNewType,};
    if (promptNewType != null)
    {
    $(".MainLoading").addClass("show");
    $http.post('/services/stock/addNewBrand2DB',typeArray).then(
    function xSuccess(response)
    {
    if (response.data=='is_dublicate')
    {
    toast_is_Dublicate();

    }
    else
    {
    toast_item_Added();
    }
    get_All_Brand_data();
    $(".MainLoading").removeClass("show");
    });
    }
    else {}
    }

    /*##################### type Of Products  Section  ###########################################################*/
    /* Types Tab------------------------------------------------------- */
    function  get_All_Product_Types_data()
    {
    $(".MainLoading").addClass("show");
    $http({
    method:"GET",
    url:"/service/stock/getProductTypesJoinBrand"

    }).then (function getsuccess(response)
    {
    $scope.AllTypesTabel=response.data;
    $scope.pagination = Pagination.getNew(10);
    $scope.pagination.numPages = Math.ceil($scope.AllTypesTabel.length/$scope.pagination.perPage);
    $(".MainLoading").removeClass("show");
    },function  getErorr(response)
    {
    }
    );
    }

    $scope.All_productTypes_OnLoadPage=function()
    {
    get_All_Product_Types_data();
    get_All_Brand_data();
    $scope.publicNotificationMessage="";
    }

    $scope.add_new_productType =function()
    {
    var Newtype=
    {
    parent_Brand_ID:$scope.brandName,
    product_Type_Name:$scope.newType,
    };
    $http.post('/services/stock/addNewType2DB',Newtype).then(
    function xSuccess(response)
    {
    if (response.data==100)
    toast_alert('Dublicated','warning');
    else
    {
    toast_alert('Added','success');
    get_All_Product_Types_data();
    $('#addNewType').dimmer('hide');
    $scope.newType="";
    $( ".text.ng-binding" ).empty();

    }

    });
    }
//-------------------------------------
    $scope.searchItem=function () {
        arg={
            keyWord:$scope.searchBox,
        }
        $http.post('/service/stock/searchProduct',arg).then
        (function pSuccess(response)
        {
           console.log(response.data)
        }), function xError(response)
        {
            toast_alert(response.data,'danger');
        }
    }


  /*-----------*/
 }]); //controller
/*__________________________ allproducts.blade.php / products.blade.php _____________________________________________*/
