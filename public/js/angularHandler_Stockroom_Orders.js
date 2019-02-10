

var app = angular.module('StackRoom_Orders_App', ['simplePagination']);

app.filter('Jdate', function() {
    return function(gdate) {
      //  var gdate;
        if (gdate !=undefined) {
            var res = gdate.split('-');
            day = parseInt(res[2]);
            month = parseInt(res[1]);
            year = parseInt(res[0]);
            return gregorian_to_jalali(year, month, day);
        }
    };
});



app.filter('pTypeCat', function() {
    return function(rypecatid) {
      return  PublicF_AppFilter_pTypeCat(rypecatid);
    };
});



app.controller('StackRoom_Orders_Ctrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
{
var sritems = [];
var sritems_temp = [];
var puttingIDList = [];
  /*#####################  putting_products.blade.php All Products in StaockRoom #################################*/
  /*#####################  putting_products.blade.php All Products in StaockRoom #################################*/
  function get_all_orders(mode,currentPage,pages)
  {
      /*
    dates=(toJalaali(2018, 2, 17));
    alert(  dates['jy']+"/"+dates['jm']+"/"+dates['jd'])  ;
    */
    if (mode) //Deleted
    {
      $scope.inTrashlist=true;
      $scope.inAllDatalist=false;
      $("#ShowTrashed").addClass("active");
      $("#ShowAll").removeClass("active");
      $scope.BtnRestoreProducts=true;
      $scope.BtnDeleteProducts=true;
      $scope.btn_move_trash=false;
    }
    else //viewables
    {  $scope.inAllDatalist=true;
       $scope.inTrashlist=false;
       $("#ShowAll").addClass("active");
       $("#ShowTrashed").removeClass("active");
       $scope.btn_Add_new=true;
       $scope.btn_move_trash=true;
       $scope.BtnRestoreProducts=false;
       $scope.BtnDeleteProducts=false;
    }

    //$scope.loading =true;
    $(".MainLoading").addClass("show");
  $http({
          method:"GET",
           url:"/services/stock/all-orders/"+mode
        //  url:"http://pishro.store/api/"
       }).then (function getsuccess(response)
                  {
                    dataArray=response.data;

                    $scope.allRows=dataArray[0];
                    $scope.OrderStatus=dataArray[1];
                    $scope.OrderSeller=dataArray[2];
                    $scope.OrderUsers=dataArray[3];

                    $scope.pagination = Pagination.getNew(pages);
                    $scope.pagination.numPages = Math.ceil($scope.allRows.length/$scope.pagination.perPage);
                      if (currentPage !='') $scope.pagination.page=currentPage;
                    $(".MainLoading").removeClass("show");
                  },function  getErorr(response)
                  {
                      if(response.data['message']=="Unauthenticated.")
                          window.location.href = "/login";
                  }
                );
  }
  get_all_orders(0,0,10);
//--ShowAll Records Deleted or Not-Deleted
  $scope.showAll=function (mode)
  {    $scope.Publicmode=mode;
      // get_all_orders(mode);
      get_all_orders(mode,0,10);
        $scope.partnumbers_id="sd";
  }
//-----------------------------------------------

    $scope.changePagin=function()
    {
        get_all_orders($scope.Publicmode ,0,10000);

    }

//-----------------------------------------------


//-----------------------------------------------



function resetform()
{

  //^^^^^^^^^^^^^^^^^
  //$scope.Order_id='';
  //$scope.Order_code ='';
  $scope.Order_Date  ='';
  $scope.status_code ='';
  $scope.sellerName= '';
  $scope.orderComment = '';
  $scope.ordStatus = '';
  $scope.ord_status='';
  $scope.seller_id='';
  $("#Order_Number").val("");
  $("#ord_status").val("");

  $("#mode0").addClass("positive");
  $("#mode1").removeClass("positive");
  $scope.mode1_fiald=false;
  $scope.resultProduct=false;

  sritems=[];
  $scope.addedRows="";

  //^^^^^^^^^^^^^^^^^
}
//------------------
  $scope.EditSelected=function (rowId)
  {
     $scope.Loading_waitForDB=true;
     $scope.order_Desc_showing=false;

     $scope.OrderID=rowId;
     $scope.FormTitle=editOrder_title;
     $scope.new_form_control=false;
     $scope.edit_form_control=true;
     $scope.ProductListinOrder=true;

     resetform();

     //..............
     SelectDimmer('edit');
     $('#Dimmer_page').dimmer('show');
     sritems=[];
     var newFormData={Selected_id:rowId,};
     $http.post('/service/stock/getOrderData',newFormData).then
     (function pSuccess(response)
       {
        data= response.data;
        //@@@@@@@@@@@@@@@@@@@@@@@@
        if (data !="")
        {
            $scope.puttingStockID=data[0]['rowID'];
            $scope.echoOrder_id=data[0]['Order_id'];
            $scope.Order_code =data[0]['ordrs_code'];
            $scope.ordrs_id_number=data[0]['ordrs_number'];
            $scope.Order_Date  =data[0]['ordrs_date'];
            $scope.status_code =data[0]['ordr_statu'];
            $scope.sellerName= data[0]['sellerName'];
            $scope.orderComment = data[0]['orderComment'];
            $scope.ordStatus = data[0]['ordr_statu'].toString();
            sritems=response.data;

            arryLenght=sritems.length;

            //$('#orderComment').val(data[0]['orderComment']);
            if (data[0]['orderComment'] ==null)
                $scope.order_Desc_showing=true;

            var i;
            for (i=0;i<=arryLenght-1;i++)
            {
              sritems[i].rowID=i;
              puttingIDList.push(sritems[i].putting_productsID);
            }
            if (arryLenght>=0)$("#Dimmer_page").addClass("dimmer_scroller");
            $scope.addedRows=  sritems;

           // GetPuttingID();
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@
        else
        {
           $scope.edit_form_control=false;
           $scope.formStatus='new';
          var newFormData={Selected_id:rowId,};
          $http.post('/service/stock/Order/get_Just_OrderData',newFormData).then
          (function pSuccess(response)
            {
                data= response.data;
                $scope.echoOrder_id=data[0]['Order_id'];
                $scope.Order_code =data[0]['ordrs_code'];
                $scope.ordrs_id_number=data[0]['ordrs_number'];
                $scope.Order_Date  =data[0]['ordrs_date'];
                $scope.status_code =data[0]['ordr_statu'];
                $scope.sellerName= data[0]['sellerName'];
                $scope.orderComment = data[0]['orderComment'];
                $scope.ordStatus = data[0]['ordr_statu'].toString();

            }), function xError(response)
            {
              toast_alert(response.data,'danger');
            }
        }
                $scope.Loading_waitForDB=false;
        //@@@@@@@@@@@@@@@@@@@@@@@@
       }), function xError(response)
       {
         toast_alert(response.data,'danger');
       }
  }
  //EditOrder_DB----------------
    $scope.EditOrder_DB=function(i)
    {
        EditOrder(1);
    }

// function
    function EditOrder(hideDimmer)
    {
        console.log(sritems);
        currentPage=($scope.pagination.page);
        if(sritems.length)
        {
            var Args=
                {
                    OrdersProducts:sritems,
                    ordStatus:$scope.ordStatus
                }
            $http.post('/services/stock/Order/Update_ProductOrders_DB',Args).then(
                function xSuccess(response)
                {
                    //toast_alert(edited_Message,'success');
                    get_all_orders(0,currentPage,10);
                    toast_alert(edited_Message,'success');
                    if (hideDimmer)
                        $('#Dimmer_page').dimmer('hide');
                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
        }
        else {
            $('#Dimmer_page').dimmer('hide');
        }
    }

  //Update form data
  $scope.UpdateFormData=function()
  {

    var Args={
        ord_id:$scope.thisRowID,
        ord_id_number:$scope.formData.Order_Number,
        ord_seller_id:$scope.seller_id,
        ord_status:$scope.formData.ord_status,
        ord_MoreInfo:$scope.orderMessage,
        }

        $http.post('/service/stock/Order/updateOrder',Args).then(
           function xSuccess(response)
         {

            // get_all_orders(0,currentPage,100000);
           $('#Dimmer_page').dimmer('hide');
           toast_alert(edited_Message,'success');

         }), function xError(response)
         {
           toast_alert(response.data,'warning');
         }


  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Public Action buttons
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//-------
  $scope.MoveToTrash=function (rowId)
  {
    /*confirm ؟ */
      access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
   //----------------
     if (access)
       {
           var newFormData= {selectesRowId:rowId};
           $http.post('/services/stock/Order/DeleteOrder_From_list',newFormData).then
           (function xSuccess(response){
             if (response.data==0 )
             {
               $( "#row"+rowId ).hide(1000);
               toast_alert(deleted_Message,'warning');
             }
             else {
                 toast_alert(delete_Error_Message,'danger');
             }


           }), function xError(response)
           {
               // toast_alert(response.data,'danger');
           }
      }
   }
//-------
  $scope.RestoreFromTrash=function (rowId)
  {
    /*confirm ؟ */
      access=false;var r = confirm(Q_Restor_Message);if (r == true) {access=true;} else {access=false; }
   //----------------
     if (access)
       {
           var newFormData= {selectesRowId:rowId,table:"xeeoirder"};
           $http.post('/Publicservices/RestoreFromTrash',newFormData).then
           (function xSuccess(response){
              $( "#row"+rowId ).hide(1000);
               toast_alert(row_Restored_message,'success');
           }), function xError(response)
           {
               toast_alert(response.data,'danger');
           }
      }
  }
//-------
  $scope.DeleteFromDataBase=function (rowId)
  {
    /*confirm ؟ */
      access=false;var r = confirm(Q_Full_delete_Message);if (r == true) {access=true;} else {access=false; }
   //----------------
     if (access)
       {
           var newFormData= {selectesRowId:rowId,table:"xeeoirder"};
           $http.post('/Publicservices/DeleteFromDB',newFormData).then
           (function xSuccess(response){
              $( "#row"+rowId ).hide(1000);
               toast_alert(deleted_Message,'danger');
           }), function xError(response)
           {
               toast_alert(response.data,'danger');
           }
      }
  }

/*------------move_Selected_to_Trash-----------------*/
  $scope.move_Selected_to_Trash=function ()
  {
     /*confirm ؟ */
       access=false;
        var r = confirm(deleteMessage);
        if (r == true) {access=true;} else {access=false;  }
    //----------------
     if (access)
     {
         $t="xeeoirder";
         var id_array =[$t];
         $(".checkbox:checked").each(function() {id_array.push($(this).val());  });
         $http.post('/Publicservices/moveSelectedToTrash',id_array).then(function xSuccess(response)
          {
               $.each(id_array, function (index, value) {
                $( "#row"+value ).hide(1000);
               });
               toast_alert(deleted_Message  ,'warning');
          }), function xError(response)
          {
            toast_alert(response.data,'warning');
          }
      }
  }
  /*------------move_Selected_to_Trash-----------------*/
    $scope.RestoreGroupFromTrash=function ()
    {
       /*confirm ؟ */
         access=false;
          var r = confirm(deleteMessage);
          if (r == true) {access=true;} else {access=false;  }
      //----------------
       if (access)
       {
           $t="xeeoirder";
           var id_array =[$t];
           $(".checkbox:checked").each(function() {id_array.push($(this).val());  });
           $http.post('/Publicservices/RestoreGroupFromTrash',id_array).then(function xSuccess(response)
            {
                 $.each(id_array, function (index, value) {
                  $( "#row"+value ).hide(1000);
                 });
                 toast_alert(row_Restored_message,'success');
            }), function xError(response)
            {
              toast_alert(response.data,'warning');
            }
        }
    }

    /*------------Full Delete Selected Items-----------------*/
      $scope.FullDeleteSelectedItems=function ()
      {
         /*confirm ؟ */
           access=false;
            var r = confirm(deleteMessage);
            if (r == true) {access=true;} else {access=false;  }
        //----------------
         if (access)
         {
             $t="xeeoirder";
             var id_array =[$t];
             $(".checkbox:checked").each(function() {id_array.push($(this).val());  });
             $http.post('/Publicservices/FullDeleteSelectedItems',id_array).then(function xSuccess(response)
              {
                   $.each(id_array, function (index, value) {
                    $( "#row"+value ).hide(1000);
                   });
                   toast_alert(Full_delete_Message,'danger');
              }), function xError(response)
              {
                toast_alert(response.data,'warning');
              }
          }
      }
  /*------------------------------checked checkbox--------------------------------*/
            $scope.checkall=function ($id)
            {

                $("#checkall"+$id).change(function(){
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
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  /*####Single Order #################  section_add_new_order.blade.php   #################################*/
  /*#####################  section_add_new_order.blade.php  #################################*/

//Get all Sellers
function get_all_Sellers()
{
  $http({
          method:"GET",
           url:"/services/stock/all-sellers"
        //  url:"http://pishro.store/api/"
       }).then (function getsuccess(response)
                  {
                    $scope.allsellers=response.data;
                  },function  getErorr(response)
                  {
                  }
                );
}
 get_all_Sellers();

//get_all_Status
 function get_all_Status()
 {
   $http({
           method:"GET",
            url:"/services/stock/all-Status"
         //  url:"http://pishro.store/api/"
        }).then (function getsuccess(response)
                   {
                     $scope.allstatus=response.data;
                   },function  getErorr(response)
                   {
                   }
                 );
 }
 get_all_Status();

// Add new record ____________________________________________
$scope.add_new=function ()
{


  resetform();
  $(".text.ng-binding" ).empty();
  $('textarea').val('');
  SelectDimmer('new');
  //SelectDimmer('test');
  $('#Dimmer_page').dimmer('show');
  $scope.FormTitle=addNewOrder_title;

  $scope.edit_form_control=false;
  generateNewOrderCode();
  //generate new Order code

  //$scope.edit_form_control=true;

}
//addNewOrderTo_DB
$scope.addNewOrderTo_DB=function ()
{
  var newOrder={
      Order_code :$scope.Order_code,
      order_id:$scope.Order_id,
      Order_Number :$scope.formData.Order_Number,
      order_seller:$scope.seller_id,
      order_status:$scope.formData.ord_status,
      order_comment:$scope.orderMessage,
      }



  $http.post('/services/stock/addNewOrder',newOrder).then(
  function xSuccess(response)
   {
    // resetform();
      get_all_orders();
      //toast_alert('success','success');
      $('#new_order').dimmer('hide');
      SelectDimmer('addProductToOrder');
      $('#Dimmer_page').dimmer('show');
      //---------------
      var newFormData={Selected_id:$scope.Order_id,};
      $http.post('/service/stock/Order/get_Just_OrderData',newFormData).then
      (function pSuccess(response)
        {
            data= response.data;
            $scope.echoOrder_id=data[0]['Order_id'];
            $scope.Order_code =data[0]['ordrs_code'];
            $scope.ordrs_id_number=data[0]['ordrs_number'];
            $scope.Order_Date  =data[0]['ordrs_date'];
            $scope.status_code =data[0]['ordr_statu'];
            $scope.sellerName= data[0]['sellerName'];
            $scope.orderComment = data[0]['orderComment'];
            $scope.ordStatus = data[0]['ordr_statu'].toString();
        }), function xError(response)
        {
          toast_alert(response.data,'danger');
        }
        //---------------
   },
     function myError(response)
      {
        alert="";
        if (response.data.errors['order_seller']) alert= alert+'فروشنده را مشخص نمایید'+"<br/>";
        if (response.data.errors['order_status']) alert= alert+'وضعیت را مشخص نمایید'+"<br/>";
        if (response.data.errors['order_comment']) alert= alert+'تعداد کاراکترها از حد مجاز بیشتر است '+"<br/>";
        toast_alert(alert,'danger');
      });


}

$scope.addProductToOrder=function()
{
  SelectDimmer('addProductToOrder');
  $('#Dimmer_page').dimmer('show');
}


function generateNewOrderCode()

{
  $http({
        method:"GET",
         url:"/services/stock/Order/generateNewOrderCode"
      //  url:"http://pishro.store/api/"
     }).then (function getsuccess(response)
                {  $data=response.data
                  $scope.Order_code=$data[1];
                  $scope.Order_id=$data[0];
                },function  getErorr(response)
                {
                }
              );
}

$scope.closeDimmer=function ()
{
  $('#Dimmer_page').dimmer('hide');
}
// Add new record ____________________________________________
//---------------------------
  function SelectDimmer(dimmer)
  {
    switch(dimmer)
    {
      case 'test':
          $scope.Tets_in_Dimmer=true;
      break;
      case 'new':
          $scope.FormTitle=lbl_new_puttingStock;
          $scope.formStatus='new';
          $scope.EditNewOrder_in_Dimmer=true;
          $scope.add_ProductToOrder_in_Dimmer=false;
          $scope.add_A_PartToChassis_in_Dimmer=false;
          break;
      case 'edit':
          $('textarea').val('');
          $scope.FormTitle=lbl_editOrder;
          $scope.formStatus='edit';
          //$scope.EditNewOrder_in_Dimmer=true;
          //$scope.add_ProductToOrder_in_Dimmer=false;
          $scope.add_ProductToOrder_in_Dimmer=true;
          $scope.EditNewOrder_in_Dimmer=false;
          $scope.mode0_fiald=true;
          $scope.add_A_PartToChassis_in_Dimmer=false;
          getAllSerial(0);
          break;
      case 'addProductToOrder':
          $scope.FormTitle=lbl_AddProductInOrder;
          $scope.add_ProductToOrder_in_Dimmer=true;
          $scope.EditNewOrder_in_Dimmer=false;
          //-----------
          $scope.mode0_fiald=true;
          $scope.add_A_PartToChassis_in_Dimmer=false;
          getAllSerial(0);
      break;

      case 'serialNumer':
        $scope.FormTitle=lbl_serialNumber;
        $scope.serialNumber_in_Dimmer=true; // serialNumber new/Edit
        $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
        $scope.viewRow_in_Dimmer=false;
        $scope.partInChassis_in_Dimmer=false;
        $scope.add_A_PartToChassis_in_Dimmer=false;
      break;

      case 'add_A_PartToChassis':
        $scope.FormTitle=lbl_partInChassis;
        $scope.add_A_PartToChassis_in_Dimmer=true;
        $scope.EditNewOrder_in_Dimmer=false;
        $scope.add_ProductToOrder_in_Dimmer=false;
        $scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
        $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
        $scope.viewRow_in_Dimmer=false;
      break;
    }
  }


  //To finde PartNumber use two options
  $scope.fiald_mode=function(mode)
  {
      $scope.modeis=mode;
    if (mode) // 3 filter
    {
      changeModeReset() ;
      $("#mode1").addClass("positive");
      $("#mode0").removeClass("positive");

        $("#modex1").addClass("positive");
        $("#modex0").removeClass("positive");
      $scope.mode1_fiald=true;
      $scope.mode0_fiald=false;
      getAllBrands();

    }
    else  // filter By partNumber
    {
      changeModeReset() ;
      $("#mode0").addClass("positive");
      $("#mode1").removeClass("positive");
        $("#modex0").addClass("positive");
        $("#modex1").removeClass("positive");
      $scope.mode0_fiald=true;
      $scope.mode1_fiald=false;
      getAllSerial(0);
      getAllSerial_byCatType(0);
    }
  }
//------------------
  function changeModeReset(sritems)
  {

  }

  //------- Get All PartNumber
          function getAllSerial(mode)
          {
             $http.get('/services/stock/partNumberList').then(function xSuccess(response)
              {
                 $scope.partnumbers=response.data;
              }), function xError(response)
              {
                toast_alert(response.data,'warning');
              }
          }

          function getAllSerial_byCatType(mode)
          {
               var Args={
                   t:"xeeptprodusz",
                   mode:0,
                   key:"stkr_prodct_type_cat",
                   value:2
                   }
             $http.post('/Publicservices/relatedDatalist',Args).then(function xSuccess(response)
              {
                 $scope.partnumbersByCatType=response.data;
              }), function xError(response)
              {
                toast_alert(response.data,'warning');
              }
          }





//------- Get All Brands
          function getAllBrands()
          {
             $scope.resultProduct=false;
             mode=0;
             $t="xeepbrndssz";
             var Paramas =[$t];
             Paramas.push(mode);
             $http.post('/Publicservices/datalist',Paramas).then(function xSuccess(response)
              {
                 $scope.brands=response.data;
              }), function xError(response)
              {
                toast_alert(response.data,'warning');
              }
          }
//-----------get Related Type
            $scope.getRelatedType=function ()
              {
                    $scope.resultProduct=false;
                    $(".TypeID").addClass("loading");
                    $( ".TypeID  .text.ng-binding" ).empty();
                    $( ".product_prtNum  .text.ng-binding" ).empty();

                   var Args={
                       t:"xeepTypsssz",
                       mode:0,
                       key:"stkr_prodct_type_In_brands",
                       value:$scope.brandsID
                       }
                 $http.post('/Publicservices/relatedDatalist',Args).then(function xSuccess(response)
                  {
                    $(".TypeID").removeClass("loading");
                     $scope.types=response.data;
                  }), function xError(response)
                  {
                    toast_alert(response.data,'warning');
                  }

              }
  //----------- get Related Products
                  $scope.getRelatedProducts=function ()
                  {
                  //    $scope.resultProduct=false;
                     $(".product_prtNum  .text.ng-binding" ).empty();
                     $(".product_prtNum ").addClass("loading");
                     var Args={
                         t:"xeeptprodusz",
                         mode:'val3Neg',
                         key:"stkr_prodct_brand",
                         value:$scope.brandsID,
                         key2:"stkr_prodct_type",
                         value2:$scope.TypeID,
                         key3:"stkr_prodct_type_cat",
                         value3:2,
                         }

                   $http.post('/Publicservices/relatedDatalist3Fld',Args).then(function xSuccess(response)
                    {
                        $(".product_prtNum ").removeClass("loading");
                         $scope.products=response.data;
                    }), function xError(response)
                    {
                      toast_alert(response.data,'warning');
                    }
                  }
//**********************************
                $scope.getRelatedProducts_ByType=function (type_cat)
                {
                //    $scope.resultProduct=false;
                   $(".product_prtNum  .text.ng-binding" ).empty();
                   $(".product_prtNum ").addClass("loading");

                    var Args={
                        brandsID:$scope.brandsID,
                        TypeID:$scope.TypeID,
                        typeCat:type_cat,
                    }
                 $http.post('/services/stock/Order/getRelatedProducts_ByType',Args).then(function xSuccess(response)
                  {
                      $(".product_prtNum ").removeClass("loading");
                       $scope.products=response.data;
                  }), function xError(response)
                  {
                    toast_alert(response.data,'warning');
                  }
                }
//----------------------------------
                    // find By PartNumber
                $("#partnumber_list_in_Order").change(function() {
                    partnumbers_id=$("#partnumber_list_in_Order").val();
                    $scope.resultProduct=true;
                    $scope.OrderStatus=true;
                    $scope.ProductStatus=true;
                    findProductByID (partnumbers_id);
                });
//----------------------------------
    // find By PartNumber
            $("#selectSubChassis_partnumber").change(function() {
                partnumbers_id=$("#selectSubChassis_partnumber").val();
                $scope.resultProduct=true;
                $scope.OrderStatus=true;
                $scope.ProductStatus=true;
                findProductByID (partnumbers_id);
            });


              $scope.selectProduct=function(mode)
                {

                  if (mode) // fillter
                      {
                        if ($scope.product_prtNum)
                          {
                            $scope.resultProduct=true;
                            $scope.OrderStatus=true;
                            $scope.ProductStatus=true;
                            findProductByID ($scope.product_prtNum);
                          }
                          else //Hide form Element when Products filter Changing
                          {  $scope.resultProduct=false;
                            $scope.ProductStatus=false;
                            $scope.OrderStatus=false;
                          }
                      }
                      else
                  {
                      partnumbers_id=$scope.partnumbers_id;
                      $scope.resultProduct=true;
                      $scope.OrderStatus=true;
                      $scope.ProductStatus=true;
                      findProductByID (partnumbers_id);
                  }
                }
  //----------------------------------

  //----------------------------------
                  function findProductByID (pID)
                  {
                    var Args={ productID:pID}
                    $http.post('/services/stock/getProductTitleBrandType',Args).then(function xSuccess(response)
                     {
                      $scope.product_QTY=1;
                      $data=response.data;
                      $scope.echo_ProductID= $data[0].ProductsID;
                      $scope.echo_partNumber= $data[0].stkr_prodct_partnumber_commercial;
                      $scope.echo_Brand= $data[0].stkr_prodct_brand_title+" ";
                      $scope.brandID = $data[0].BrandID;
                      $scope.prodct_type_cat= $data[0].stkr_prodct_type_cat;
                      $scope.echo_Type= $data[0].stkr_prodct_type_title;
                      $scope.TypeId= $data[0].TypeID;
                      $scope.echo_ProductTitle= $data[0].stkr_prodct_title;

                      //toast_alert($data[0].stkr_prodct_brand_title,'info');
                      //*****************
                      if ($data[0].stkr_prodct_type_cat ==2)
                      $scope.targetChassis_field=true;
                      else
                      $scope.targetChassis_field=false;
                        //toast_alert('MONFASEHE>>>','danger');
                      //*****************
                          $scope.show_Chassis_number=false;
                          $scope.show_SO_number=false;

                          $scope.new_form_control_SaveAndNext=false;

                     }), function xError(response)
                     {
                       toast_alert(response.data,'warning');
                     }
                  }
  //------------------------------------------
$scope.add_product_to_order=function(formStatus)
{
  //toast_alert($scope.Order_id+'/'+$scope.echo_ProductID+"/"+$scope.product_QTY+"@"+$scope.echo_partNumber,'info');
  i=0;result=0;
  if (formStatus=='new' || sritems.length==0)
  {
    $scope.ProductListinOrder=true;
    $scope.new_form_control=true;
    $scope.edit_form_control=false;
   }
  else
  {
    $scope.ProductListinOrder=false;
    $scope.new_form_control=false;
    $scope.edit_form_control=true;
  }
  sritems.forEach(doAction);
  function doAction()
  {
     if (sritems[i].partNumber ==$scope.echo_partNumber)
     {
       result++;
     }
     i++;
  }
  //--------------
  if (result >=1)
  {
    falg=false;
    toast_alert(error_duplicated_p_message,'danger');
  }
  else {
    falg=true;
  }

  //-----------------

  if (falg)
    {
    //  $scope.echo_Brand   $scope.echo_Type     $scope.echo_ProductTitle  $scope.product_QTY $scope.prodct_type_cat
      sritems.push({
          "rowID" :sritems.length,
          "Order_id" :$scope.echoOrder_id,
          "productId" : $scope.echo_ProductID,
          "partNumber" : $scope.echo_partNumber,
          "QTY" : $scope.product_QTY,
          "Brand"  :$scope.echo_Brand  ,
          "Type"  :$scope.echo_Type   ,
          "type_cat" :$scope.prodct_type_cat,
          "ProductTitle"  :$scope.echo_ProductTitle
           });
         $scope.addedRows=  sritems;
        if (sritems.length >=1)$("#Dimmer_page").addClass("dimmer_scroller");
        console.log(sritems);
    }
}
//----------------------------------------------
$scope.addNewTo_DB=function(i)
{
  if(sritems.length)
  {
      $http.post('/services/stock/Order/Insert_ProductOrders_To_DB',sritems).then(
      function xSuccess(response)
      {
        toast_alert( Seved_Message,'success');
         $('#Dimmer_page').dimmer('hide');
      }),
       function xError(response)
      {
        toast_alert(response.data,'warning');
      }
  }

}
//----------------------------------------------
$scope.changeQTY=function (rowid )
{
    var txt;
    OldQTY=sritems[rowid].QTY;

    var newQTY = prompt(insetNewQTY_message, OldQTY);

    if (newQTY == null || newQTY == "") {
        toast_alert('empty !!?','warrning');
    } else {
          sritems[rowid].QTY=newQTY;
    }
}

$scope.testIt =function(id)
{
    alert('s'+id);
}

//---------------------------------------
  $scope.changeSubQTY=function (rowid ,Qty,orderID,ProductID,puttingStockID)
  {
    var newQTY = prompt(insetNewQTY_message, Qty);
    if (newQTY != null && newQTY >0)
    {
      var newFormData=
          {
            table:"xeeptningstk",
            rowTitle:"stkr_stk_putng_prdct_qty",
            selectesRowId:rowid,
            rowValue:newQTY
          };
          $http.post('/Publicservices/UpdateSingleRecord',newFormData).then
          (function xSuccess(response){
            //toast_alert('QTY UpDated','success');
            get_List_PartOfChissisPartNumber(0);
            Show_partsOfChassis (ProductID,orderID,puttingStockID);
          }), function xError(response)
          {
              toast_alert(response.data,'danger');
          }
    }
  }
//----------------------------------------------
$scope.removeProductRow =function (rowid,Order_id,putting_productsID,productId) {

    access = false;
    var r = confirm(deleteMessage);
    if (r == true) {
        access = true;
    } else {
        access = false;
    }
    if (putting_productsID && access) {
        var Arg = {OrderId: Order_id, puttingProductsID: putting_productsID};
        $http.post('/services/stock/Order/Order_checkSingleItemToDelete', Arg).then
        (function xSuccess(response) {
            console.log(response.data);
            switch (response.data) {
                case'deleted':
                    $("#DivRow" + rowid).hide(1000);
                    $("#DivRowx" + productId).addClass('hide');
                    //$( "#DivRowx"+productId ).hide(1000);
                    sritems.splice(rowid, 1);
                    for (i = 0; i <= sritems.length - 1; i++) {
                        sritems[i].rowID = i;
                    }
                    toast_alert(deleted_Message, 'success');
                    break;
                case'deleteSerial':
                    toast_alert(delete_Error_Message_Serial, 'danger');
                    break;

                case'deletePartofchassis':
                    toast_alert(delete_Error_Message_PartOfChassis, 'danger');
                    break;
            }
        }), function xError(response) {
            console.log(response.data);
        }
    }
    else {
        // alert(rowid);
        $("#DivRow" + rowid).hide(1000);
        $("#DivRowx" + rowid).hide(1000);

        sritems.splice(rowid, 1);
        for (i = 0; i <= sritems.length - 1; i++) {
            sritems[i].rowID = i;
        }
    }
}

    function GetPuttingID() {
        //arr = $.unique(puttingIDList);
        for (i = 0; i <= puttingIDList.length - 1; i++) {
            serialInDB(puttingIDList[i])
        }
        //alert(puttingIDList[i].putting_productsID );
        //console.log(puttingIDList[i].putting_productsID);

    }

    function serialInDB(pid) {
        var newFormData =
            {
                table: "xeeptnserls3",
                mode: 0,
                key: "stkr_srial_putting_product_id",
                value: pid
            };
        $http.post('/Publicservices/GetCount', newFormData).then
        (function xSuccess(response) {
            $("#serialID" + pid).html(response.data);
        }), function xError(response) {
            toast_alert(response.data, 'danger');
        }
    }

//-----------------------

    function get_List_PartOfChissisPartNumber(mode) {

        var Args = {
            t: "xeeptprodusz",
            mode: 0,
            key: "stkr_prodct_type_cat",
            value: 2
        }
        $http.post('/Publicservices/relatedDatalist', Args).then(function xSuccess(response) {
            $scope.part_numbers = response.data;
        }), function xError(response) {
            toast_alert(response.data, 'warning');
        }
    }

//-------
    $scope.addToChasiss = function (id, pID, OrdID, puttingStockID) {
//  toast_alert(id+'/'+pID+'/'+OrdID,'info');
        $(".divTableRowB").removeClass("selectedRow");
        $(".subrow").removeClass("subrow_Show");
        $("#DivRow" + id).addClass("selectedRow");
        $("#DivRow" + id + " .subrow").addClass("subrow_Show");
        $("#Dimmer_page").addClass("dimmer_scroller");

        $scope.product_QTY = 1;
        $scope.currentChassis = pID;
        $scope.targetChassis = pID.toString();
        get_List_PartOfChissisPartNumber(0);

        Show_partsOfChassis(pID, OrdID, puttingStockID);

    }
//------------
    $scope.ShowBTN_addToChasiss = function (catType, rowID) {
        if (catType == 3)
            $("#btnAddToChasiss" + rowID).addClass("show");
    }


    function Show_partsOfChassis(ProductID, orderID, puttingStockID) {
        console.log(ProductID, orderID, puttingStockID);
        $scope.waitForSubRows = true;
        array_sub_row = [];
        var Args = {
            order_ID: orderID,
            Product_ID: ProductID,
            puttingStock_ID: puttingStockID
        }

        $http.post('/service/stock/getOrderData_partsInChassis', Args).then(function xSuccess(response) {
            array_sub_row = response.data;
            $scope.SubRows = array_sub_row;
            //console.log(array_sub_row);
            $scope.waitForSubRows = false;
        }), function xError(response) {
            toast_alert(response.data, 'warning');
        }
    }


    $scope.AddaPartToChassis = function (orderId, productId, Brand, Type, ProductTitle, partNumber, putting_productsID) {

        SelectDimmer('add_A_PartToChassis');
        $('#Dimmer_page').dimmer('show');
        $scope.orderID = orderId;
        $scope.chassis_id = productId;
        $scope.chassis_title = ProductTitle;
        $scope.chassis_Brand = Brand;
        $scope.chassis_Type = Type;
        $scope.chassis_partNumber = partNumber;
        $scope.putting_productsID = putting_productsID;
        //console.log($scope.brandsIDX);
        getAllSerial_byCatType(0);
        $scope.resultProduct = false;
    }
//-----------------------
    $scope.add_ChassesPart_to_DB = function (chassis_id, ProductID, orderID, puttingStockID, putting_productsID) {

        chasid = chassis_id;
        //  toast_alert($scope.partnumbers_id+'-'+$scope.product_QTY+'-'+ $scope.chassis_id,'info');
        var newFormData =
            {
                orderid: orderID,
                productid: ProductID,
                //chassisid:chasid,
                QTYValue: $scope.product_QTY,
                chassisid: putting_productsID
            };
        //---------------------

        $http.post('/services/stock/Order/add_ChassesPart_to_DB', newFormData).then(
            function xSuccess(response) {
                if (response.data == 1)
                    toast_alert(Seved_Message, 'success');
                else
                    toast_alert(error_duplicated_p_message, 'danger');
                //--
                SelectDimmer('edit');
                $('#Dimmer_page').dimmer('show');
                $(".divTableRowB").removeClass("selectedRow");
                $(".subrow").removeClass("subrow_Show");
                $("#DivRow" + chasid).addClass("selectedRow");
                $("#DivRow" + chasid + " .subrow").addClass("subrow_Show");
                $("#Dimmer_page").addClass("dimmer_scroller");
                $scope.resultProduct = false;
                //--
                get_List_PartOfChissisPartNumber(0);
                Show_partsOfChassis(chasid, orderID, putting_productsID);
                $scope.fiald_mode(0);
            }),
            function xError(response) {
                toast_alert(response.data, 'warning');
            }


    }

    $scope.backToEditPage = function (id) {
        $scope.fiald_mode(0);
        SelectDimmer('edit');
        $('#Dimmer_page').dimmer('show');
        $(".divTableRowB").removeClass("selectedRow");
        $(".subrow").removeClass("subrow_Show");
        $("#DivRow" + id).addClass("selectedRow");
        $("#DivRow" + id + " .subrow").addClass("subrow_Show");
        $("#Dimmer_page").addClass("dimmer_scroller");
    }
//------------------------------------------
    $scope.edit_order_info = function () {
        $scope.order_Desc_showing = true;
        // alert($scope.OrderID);
    }
//------------------------------------------
    $scope.close_SelectedRow = function (product_id) {
        $('#DivRow' + product_id).removeClass('selectedRow');
        $('.subrow').removeClass('subrow_Show');

    }
//------------------------------------------


    $scope.update_Order_field = function (field) {
        switch (field) {
            case 'orderComment' :
                $scope.order_Desc_showing = false;
                value = $('#orderComment').val();
                break;
        }

        var Args = {
            OrderID: $scope.OrderID,
            field: field,
            value: value
        }

        $http.post('/services_stock/orders/updateStackrequest_info', Args).then(function xSuccess(response) {
            if (response.data == 1) {
                if ($scope.formStatus == 'new')
                    $scope.addNewTo_DB(0);
                else {
                    EditOrder(false);
                    $scope.EditSelected($scope.OrderID);
                }

                get_all_orders(0, $scope.pagination.page, 10);
                toast_alert(edited_Message, 'success');
            }
            else {
                toast_alert(error_message, 'danger');
            }
        }), function xError(response) {
            toast_alert(response.data, 'warning');
        }


    }
//------------------------------------------

    $scope.ReloadData = function (OrderID) {
        $scope.EditSelected(OrderID);
    }

}]);
