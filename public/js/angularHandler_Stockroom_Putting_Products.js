

var app = angular.module('StackRoom_Putting_App', ['simplePagination' ] );


//-----------------------


//-----------------------
app.filter('Jdate', function() {
    return function(gdate) {
        var gdate;

            if (gdate !=undefined)
            {
                var res = gdate.split("-");
                day=parseInt   (res[2]);
                month=parseInt (res[1]);
                year=parseInt  (res[0]);

                return gregorian_to_jalali(year,month,day);
            }
    };
});
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//-----------------------
app.filter('handelPrintBtn', function() {
    return function(param) {
        var param;

        if (param =='print')
        {
            return ' چاپ ';
        }
        return param;
        // else return param;
    };
});

app.filter('handelReminedQTY', function() {
    return function(param) {
        var param;

        if (param !='print')
        {
            return param;
        }
        // else return param;
    };
});
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
app.filter('checkTotal', function() {
    return function(Qty,totalvalue,id) {
        if (Qty==totalvalue && totalvalue!=0)
        {
            $("."+"count"+id).addClass("numberBorder green");
            return Qty+"/"+totalvalue;
        }
        else if (Qty== 0 && totalvalue==0)
            return '-';
        else
            return Qty+"/"+totalvalue;
    };
});
/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
app.filter('get_orderP', function() {
    return function(orderid) {
     ProductsInOrder(orderid);
    };
});

/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^* */
app.filter('checkSerialStatus', function() {
    return function(serialStatus) {
        if (serialStatus>0 )
            return "خارج از انبار";
    };
});
/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
  app.filter('pTypeCat', function() {
      return function(rypecatid) {
        return  PublicF_AppFilter_pTypeCat(rypecatid);
      };
  });
app.controller('StackRoom_Putting_Ctrl', ['$scope', '$http','Pagination',
function($scope, $http,Pagination)
{

  var d = new Date();
  var strDate = gregorian_to_jalali(d.getFullYear(),d.getMonth()+1,d.getDate())
  var res = strDate.split("/");
  day=parseInt   (res[2]);
  month=parseInt (res[1]);
  year=parseInt  (res[0]);

  $scope.Cdays=day.toString();
  $scope.Cmonths=month.toString();
  $scope.Cyears=year.toString();

  serialFields = [];



  /*#####################   All Records  in StaockRoom #################################*/
  /*#####################  All Products in StaockRoom #################################*/
  function get_all_records(ListMode)
  {


    if (ListMode) //Deleted
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
           url:"/services/stock/all-Putting-Products/"+ListMode
        //  url:"http://pishro.store/api/"
       }).then (function getsuccess(response)
                  {
                     // alert(response.data);
                    //console.log(response.data);



                    $scope.allRows=response.data;
                    $scope.pagination = Pagination.getNew(10);
                    $scope.pagination.numPages = Math.ceil($scope.allRows.length/$scope.pagination.perPage);
                    $(".MainLoading").removeClass("show");
                    showProductOfEachOrder();
                  },function  getErorr(response)
                  {
                      if(response.data['message']=="Unauthenticated.")
                          window.location.href = "/login";
                  }
                );
$scope.convertDate="d";
  }
  get_all_records(0);



function showProductOfEachOrder(id)
{

   $("#products40").html("<b>Hello world!</b>");
   $("#products40").addClass("show");
}


  //--ShowAll Records Deleted or Not-Deleted
    $scope.showAll=function (mode)
    {
        get_all_records(mode);


    }


function ProductsInOrder(orderId)
{

  //++++++++++++++++++++++++++
  var Args={
      t:"xeeptningstk",
      mode:0,
      key:"stkr_stk_putng_prdct_order_id",
      value:orderId
      }
  $http.post('/Publicservices/relatedDatalist',Args).then
  (function xSuccess(response){
    console.log(response.data);
    alert(response.data.length,'success');

  }), function xError(response)
  {
    toast_alert(response.data,'danger');
  }
  //++++++++++++++++++++++++++
}



//-------Action New()
$scope.add_new=function ()
{
  getAllSerial(0);
  SelectDimmer('new');
  $('#Dimmer_page').dimmer('show');
  //$scope.add_new_putting_in_Dimmer=true; //show add_new_putting
  //$scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
  $scope.mode0_fiald=true;
  $scope.mode1_fiald=false;
  $("#mode0").addClass("positive");
  $("#mode1").removeClass("positive");
  changeModeReset();
  }

  $scope.closeDimmer=function()
  {
      $('#Dimmer_page').dimmer('hide');
  }

//---------------------------
  function SelectDimmer(dimmer)
  {
    switch(dimmer)
    {
      case 'new':
          $scope.FormTitle=lbl_new_puttingStock;
          $scope.add_new_putting_in_Dimmer=true; //show add_new_putting
          $scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
          $scope.viewRow_in_Dimmer=false;
          $scope.partInChassis_in_Dimmer=false;
          $scope.editRow_in_Dimmer=false;
          $scope.AddSubChassis_Parts_in_Dimmer=false;
          break;
      case 'edit':
          $scope.FormTitle=lbl_order_product_data;
          $scope.editRow_in_Dimmer=true;
          $scope.viewRow_in_Dimmer=false;
          $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
          $scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
          $scope.partInChassis_in_Dimmer=false;
          $scope.AddSubChassis_Parts_in_Dimmer=false;
          break;
      case 'view':
          $scope.FormTitle=lbl_View;
          $scope.viewRow_in_Dimmer=true;
          $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
          $scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
          $scope.partInChassis_in_Dimmer=false;
          $scope.editRow_in_Dimmer=false;
          $scope.AddSubChassis_Parts_in_Dimmer=false;
      break;
      case 'serialNumer':
        $scope.FormTitle=lbl_serialNumber;
        $scope.serialNumber_in_Dimmer=true; // serialNumber new/Edit
        $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
        $scope.viewRow_in_Dimmer=false;
        $scope.partInChassis_in_Dimmer=false;
        $scope.editRow_in_Dimmer=false;
        $scope.AddSubChassis_Parts_in_Dimmer=false;
      break;


      case 'AddSubChassis_Parts':
        $scope.FormTitle=lbl_partInChassis;
        $scope.partInChassis_in_Dimmer=true;
        $scope.serialNumber_in_Dimmer=false; // serialNumber new/Edit
        $scope.add_new_putting_in_Dimmer=false; //show add_new_putting
        $scope.viewRow_in_Dimmer=false;
        $scope.editRow_in_Dimmer=false;
      break;

    }
  }




  $scope.test_next=function()
  {

    SelectDimmer('AddSubChassis_Parts');
    $('#Dimmer_page').dimmer('show');
  }
  $scope.addNewTo_DB=function(nextStep)
  {
    var newFormData={
    productId: $("#ProductID").val(),
    orderId:$scope.OderList,
    Cdays:$scope.Cdays,Cmonths:$scope.Cmonths,Cyears:$scope.Cyears,
    Quantity:$scope.Quantity,
    partNumber:$scope.partNumber,
    Chassis_number:$scope.Chassis_number,
    SO_number:$scope.SO_number,
    SerialNumbers:$scope.choices
   }

   $http.post('/services/stock/PuttingToStock',newFormData).then
   (function pSuccess(response)
   {
     if (nextStep) //Add part In Chassis
      {
        PuttingProduct_Id=response.data;
        SelectDimmer('AddpartInChassis');
        $('#Dimmer_page').dimmer('show');
      }
    else
     {
      get_all_records(0);
      toast_alert(response.data,'success');
      $('#Dimmer_page').dimmer('hide');
    }
   }, function xError(response)
   {
     alert="";
     toast_alert(error_message,'danger');
    });


  /*
    $http.post('/services/stock/PuttingToStock',newFormData).then

    (function pSuccess(response)
    {
      get_all_records(0);
      toast_alert(Seved_Message,'success');
      $('#Dimmer_page').dimmer('hide');
      //   toast_alert('OK','success');
        //$product=response.data;
    }, function xError(response)
    {
      alert="";
      if (response.data.message) alert= alert+'اطلاعات وارد شده  نامعتبر می باشد :'+"<br/>";
      if (response.data.errors['Cdays']) alert= alert+'روز را در بخش تاریخ وارد کنید'+"<br/>";
      if (response.data.errors['Cmonths']) alert= alert+'مقدار ماه را مشخص کنید'+"<br/>";
      if (response.data.errors['Cyears']) alert= alert+'مقدار سال را وارد کنید'+"<br/>";
      toast_alert(alert,'danger');
    });
*/

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
             var newFormData= {selectesRowId:rowId,table:"xeeptningstk"};
             $http.post('/Publicservices/moveToTrash',newFormData).then
             (function xSuccess(response){
                $( "#row"+rowId ).hide(1000);
                 toast_alert(deleted_Message,'warning');
             }), function xError(response)
             {
                 toast_alert(response.data,'danger');
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
             var newFormData= {selectesRowId:rowId,table:"xeeptningstk"};
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
        access=false;var r = confirm(deleted_Message);if (r == true) {access=true;} else {access=false; }
     //----------------
       if (access)
         {
             var newFormData= {selectesRowId:rowId,table:"xeeptningstk"};
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
           $t="xeeptningstk";
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
             $t="xeeptningstk";
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
               $t="xeeptningstk";
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
//--------------- Edit Selected--------------
  $scope.EditSelected=function(rowId)
  {

    SelectDimmer('edit')
    $('#Dimmer_page').dimmer('show');
    $http({
    method:"GET",
    url:"/services/stock/show_Record_by_id/"+rowId
    }).then (function getsuccess(response)
        {
            $Data=response.data[0];
            $scope.ordrs_id           =$Data['OrderID'];
            $scope.ordrs_id_code      =$Data['stk_ordrs_id_code'];
            $scope.ordrs_id_number    =$Data['stk_ordrs_id_number'];
            $scope.seler_name         =$Data['stkr_ordrs_slr_name'];
            $scope.ordrs_putting_date =$Data['stk_ordrs_putting_date'];
            $scope.ordrs_comment      =$Data['stk_ordrs_comment'];
            $scope.AllProductsInOrder= response.data;
        },function  getErorr(response)
        {
         console.log(response.data);
        }
    );
  }
//-------------------------
    $scope.closeEditDimmer=function()
    {
        $('#Dimmer_page').dimmer('hide');
        $scope.editRow_in_Dimmer=false;

    }
//------------------------
  $scope.show_serial_fields=function(actionBTN,product_id ,Quantity,putting_productsID)
  {
    if ($scope.lastId !=product_id)
      {
       $('#productRowId'+product_id +' a.btn.btn-info') .addClass('hide');
        $scope.lastId=product_id;
        $(".divTableRowB").removeClass("selectedRow");
        $(".subrow").removeClass("subrow_Show");
        $("#productRowId"+product_id).addClass("selectedRow");
        $("#productRowId"+product_id+" .subrow").addClass("subrow_Show");
        $("#Dimmer_page").addClass("dimmer_scroller");
        //-----------------
          $scope.choicesx = [];
          $scope.SerialNumbers = [];
          $(".MainLoading").addClass("show");

//-----------------
    var Args={
         t:"xeeptprodusz",
         mode:0,
         key:"id",
         value:product_id
         }
        $http.post('/Publicservices/relatedDatalist',Args).then
        (function xSuccess(response){
         data=response.data;

        if ( data[0].stkr_prodct_two_serial)
        {
            $scope.haveTwoSerial=true;
            serial_status_mode="2s";  //2 Serial Number
        }
        else
        {
            $scope.haveTwoSerial=false;
            serial_status_mode="1s";
        }
         }), function xError(response)
          {
            toast_alert(response.data,'danger');
          }
//-----------------
          var Args={
               t:"xeeptnserls3",
               mode:0,
               key:"stkr_srial_putting_product_id",
               value:putting_productsID
               }

              $http.post('/Publicservices/relatedDatalist',Args).then
              (function xSuccess(response){

                  if (actionBTN=="Show_Serila")
                  {
                      $scope.subrowTable=true;
                      $scope.editSerialBTN=false;
                      $scope.subrowMessage_editMode=false;
                      $scope.editSerialBTN_inLine=false;
                      $('.divTableRowB.subBTNinRow a.btn.btn-info').removeClass('hide');
                      $('.divTablez') .removeClass('hide');
                      //*******************
                      //------GET COUNT OF SUB SERIAL  // count of Sub Chassis--------
                      var Args={
                          putting_product_id:putting_productsID,
                          ordrs_id : $scope.ordrs_id
                      }
                      $http.post('/services/stock/countOfSubChassis',Args).then
                      (function xSuccess(response)
                      {
                          $scope.SerialNumbers =response.data;
                      }), function xError(response)
                      {
                          toast_alert(response.data,'danger');
                      }
                      //------GET COUNT OF SUB SERIAL  // count of Sub Chassis--------
                      //********************
                  }
                  else  // Insert_Serila
                  {
                      $scope.editSerialBTN_inLine=true;

                      if (response.data.length==0)  // new mode
                      {

                          $scope.saveSerialBTN=true;
                          $scope.editSerialBTN=false;
                          for (i=1;i<=Quantity;i++)
                          {
                              var newItemNo = $scope.choicesx.length+1;
                              $scope.choicesx.push({'id':newItemNo});
                          }
                      }
                      else  //edit mode
                      {
                          $('.divTableRowB.subBTNinRow a.btn.btn-info').removeClass('hide');
                          $('#productRowId'+product_id +' a.btn.btn-info') .addClass('hide');
                          $('.divTablez') .addClass('hide');

                          $scope.editSerialBTN=true;
                          $scope.saveSerialBTN=false;
                          $scope.subrowMessage_editMode=true;
                          $scope.editSerialBTN_inLine=true;
                          //if insert Fiald Not available , show All serila Numbers
                          if (Quantity-response.data.length==0)
                          {
                             // $scope.SerialNumbers =response.data;
                              $scope.editSerialBTN=false;
                              $scope.subrowTable=false;
                              $scope.editSerialBTN_inLine=false;
                          }

                          for (i=1;i<=Quantity-response.data.length;i++)
                          {
                              $scope.choicesx.push({'id':newItemNo});
                          }
                      }
                  }
               //----------------------
              // alert(response.data.length,'success');
             $(".MainLoading").removeClass("show");
              }), function xError(response)
              {
                toast_alert(response.data,'danger');
              }
              //++++++++++++++++++++++++++
            $scope.puttingProductsID = putting_productsID;
    }
   else
   {
     // $('#productRowId'+product_id +' a.btn.btn-info') .removeClass('hide');
       $('.divTableRowB.subBTNinRow a.btn.btn-info').removeClass('hide');
     $(".divTableRowB").removeClass("selectedRow");
     $(".subrow").removeClass("subrow_Show");
     $scope.lastId=0;
   }


  }
//-------------------------
$scope.Show_SubChassis_Parts=function(serialParent,ProductParent,serialnumbersA,serialnumbersB,type_cat , product_id, qty, PuttingProductsID)
{
        $scope.echo_serialParent=serialParent;
        $scope.echo_ProductParent=ProductParent;//putting_productsID
        $scope.echo_serial_numbers_a =serialnumbersA;
        $scope.echo_serial_numbers_b =serialnumbersB;
        $scope.product_id =product_id;
        $scope.qty=qty;
        $scope.productsID=PuttingProductsID;

        var newFormData={
            serial_Parent: serialParent,
            Product_Parent:ProductParent,
        }

        $http.post('/services/stock/Get_subChassisParts',newFormData).then
        (function pSuccess(response)
        {

          //  console.log(response.data);
           if (type_cat==3)
          {
                SelectDimmer('AddSubChassis_Parts');
                $('#Dimmer_page').dimmer('show');
                $scope.SubChassisPartsArry = response.data;

           }
        }, function xError(response)
        {
            console.log(response.data);
            $(".divTableRowB").removeClass("selectedRow");
            $(".subrow").removeClass("subrow_Show");
        });
}
//-------------------------
$scope.close_partInChassisDimmer=function( product_id ,qty,putting_productsID)
{
    console.log(product_id+"/"+qty+"/"+putting_productsID);
    SelectDimmer('edit');
    $('#Dimmer_page').dimmer('show');
    $scope.show_serial_fields('Show_Serila',product_id ,qty,putting_productsID);
    $scope.show_serial_fields('Show_Serila',product_id ,qty,putting_productsID);

}



//-------------------------
//-------------------------
$scope.showSerialSubFields =function(product_id,serialParent,PuttingProductID,qty)
{
    $scope.product_idW=product_id;
    $scope.serialParentW =serialParent;
    $scope.PuttingProductIDW =PuttingProductID;
    $scope.qtyW =qty;

  $(".divTableRowB").removeClass("selectedRow");
  $(".subrow").removeClass("subrow_Show");
  $("#productRowId"+product_id).addClass("selectedRow");
  $("#productRowId"+product_id+" .subrow").addClass("subrow_Show");
  $scope.choicesx = [];
  //----------------- Have Two SerilaNumber ?
      var Args={
           t:"xeeptprodusz",
           mode:0,
           key:"id",
           value:product_id
           }
          $http.post('/Publicservices/relatedDatalist',Args).then
          (function xSuccess(response){
           data=response.data;
          if ( data[0].stkr_prodct_two_serial)
            $scope.haveTwoSerial=true;
          else
           $scope.haveTwoSerial=false;
           }), function xError(response)
            {
              toast_alert(response.data,'danger');
            }
    //-----------------

    //-----------------
  var Args={
        PuttingProduct_ID:PuttingProductID,
        serialParent_ID :serialParent,
        productID :product_id
       }
      $http.post('/services/stock/get_SubSerialNumbers',Args).then
      (function xSuccess(response)
      {
          console.log(response.data.length);
          $scope.SerialNumbers=response.data;
          if (qty-response.data.length==0)   $scope.BTN_SaveSubSerial=false;   else $scope.BTN_SaveSubSerial=true;
          for (i=1;i<=qty-response.data.length;i++)
          {
           $scope.choicesx.push({'id':i});
          }
      }), function xError(response)
      {

      }

  //-----------------

}
   //-----------------
    $scope.Remove_SubChassisSerial=function(serialId,serialNumberA,product_idW,serialParentW,PuttingProductIDW,qtyW)
    {
        access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
        if (access)
        {
            var Args={
                putting_productsID:PuttingProductIDW,
                serialID: serialId,
                typeCat:2,
                product_id :product_idW,
            }
            $http.post('/services/stock/delete_Serial_Number',Args).then
            (function xSuccess(response){
                $scope.showSerialSubFields(product_idW,serialParentW,PuttingProductIDW,qtyW);
                toast_alert(deleted_Message,'danger');
            }), function xError(response)
            {
                console.log(response.data);
            }
        }
    }
   // -----------------


$scope.SaveSubSerialFields=function (productid,serialParent,PuttingProductID,qty)
{
  var newFormData=
  { product_id :productid,
    SerialParent   :serialParent,
    puttingProductsID: PuttingProductID,
    SerialNumbers:$scope.choicesx,
    Quantity:qty
  }
  $http.post('/services/stock/SaveSubSerialFields',newFormData).then
  (function pSuccess(response)
    {
        if (response.data=='')
            toast_alert(Seved_Message,'success');
         else toast_alert(response.data,'warning');
      $(".divTableRowB").removeClass("selectedRow");
      $(".subrow").removeClass("subrow_Show");
    }, function xError(response)
    {
      console.log(response.data);
    });

}


//-------------------------
  $scope.saveSerialNumbers=function(productID,putting_productsID,qty)
  {

    var newFormData={
    puttingProductsID: putting_productsID,
    SerialNumbers:$scope.choicesx,
    Quantity:qty
     }
     $http.post('/services/stock/saveSerialNumbers',newFormData).then
     (function pSuccess(response)
     {
         toast_alert(Seved_Message,'success');
         $(".divTableRowB").removeClass("selectedRow");
         $(".subrow").removeClass("subrow_Show");
      }, function xError(response)
      {
        console.log(response.data);
        $(".divTableRowB").removeClass("selectedRow");
        $(".subrow").removeClass("subrow_Show");
       });

      console.log($scope.choicesx);
      }

/* -------------------------  */
   $scope.EditSerialNumbers=function(product_id,putting_productsID,qty)
   {
    $('.divTableRowB.subBTNinRow a.btn.btn-info').removeClass('hide');
     var newFormData=
     {  puttingProductsID :putting_productsID,
       SerialNumbers:$scope.choicesx,
       Quantity:qty
      }
      $http.post('/services/stock/editSerialNumbers',newFormData).then
      (function pSuccess(response)
      {
          if (response.data =="")
          {   $scope.onPageError="";
              toast_alert(edited_Message,'success');
              $(".divTableRowB").removeClass("selectedRow");
              $(".subrow").removeClass("subrow_Show");
          }
          else
          {
              $scope.onPageError=response.data;
              toast_alert(response.data,'warning');
              $(".divTableRowB").removeClass("selectedRow");
              $(".subrow").removeClass("subrow_Show");
          }



       }, function xError(response)
       {
         $(".divTableRowB").removeClass("selectedRow");
         $(".subrow").removeClass("subrow_Show");
          //toast_alert(response.data,'danger');
          console.log(response.data);
       });
    // $("#productRowId"+product_id).addClass("selectedRow");
  //     $("#productRowId"+product_id+" .subrow").addClass("subrow_Show");
   }

//-----------------delete Serial Number
    $scope.deleteSerialNumber=function(ChileId,id,Quantity,putting_productsID,type_cat )
    {
        access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
        if (access)
        {
            var Data = {
                typeCat:type_cat,
                putting_productsID: putting_productsID,
                serialID: ChileId,
            }
            $http.post('/services/stock/delete_Serial_Number', Data).then
            (function pSuccess(response) {
                console.log(response.data);
                if (response.data=='serialInChassis')
                    toast_alert(delete_SerialInChassis,'danger');
                else
                {
                    $scope.show_serial_fields('Show_Serila', id, Quantity, putting_productsID);
                    $scope.show_serial_fields('Show_Serila', id, Quantity, putting_productsID);
                }
            }, function xError(response) {

            });
        }
    }

  //--------------- View Selected--------------
    $scope.ViewSelected=function(rowId)
    {
      toast_alert(rowId,'info');
       SelectDimmer('view');
       $('#Dimmer_page').dimmer('show');
      //$scope.SelectedRowId=rowId;
      //getRelatedSerialNumbers(rowId);
      //$('#Dimmer_page').dimmer('show');
    }


    //-----------get Related SerialNumbers
        function getRelatedSerialNumbers(rowId)
              {
                 var Args={
                     t:"xeeptnserls3",
                     mode:0,
                     key:"stkr_srial_putting_product_id",
                     value:rowId
                     }
               $http.post('/Publicservices/relatedDatalist',Args).then(function xSuccess(response)
                {

                   $scope.allSerials=response.data;
                }), function xError(response)
                {
                  toast_alert(response.data,'warning');
                }
              }

//------- Get All Serials
        function getAllSerial(mode)
        {
           $t="xeeptprodusz";
           var Paramas =[$t];
           Paramas.push(mode);
           $http.post('/Publicservices/datalist',Paramas).then(function xSuccess(response)
            {
               $scope.partnumbers=response.data;
            }), function xError(response)
            {
              toast_alert(response.data,'warning');
            }
        }

//------- Get All Brands
                function getAllBrands()
                {  $scope.resultProduct=false;
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
                       mode:0,
                       key:"stkr_prodct_brand",
                       value:$scope.brandsID,
                       key2:"stkr_prodct_type",
                       value2:$scope.TypeID,
                       }
                 $http.post('/Publicservices/relatedDatalist2Fld',Args).then(function xSuccess(response)
                  {
                      $(".product_prtNum ").removeClass("loading");
                       $scope.products=response.data;
                  }), function xError(response)
                  {
                    toast_alert(response.data,'warning');
                  }
                }

//------------------------------------------
                function getAllOrderList()
                {
                  $(".OderList").addClass("loading");
                   var Args={all:0}
                   $http.post('/services/stock/getAllOrderList',Args).then(function xSuccess(response)
                    {
                         $scope.Oders=response.data;
                         $(".OderList").removeClass("loading");
                    }), function xError(response)
                    {
                      toast_alert(response.data,'warning');
                    }

                }
//------------------------------------------
                  function callCalender()
                  {
                     var Args={d:0 ,m:0 ,y:0}
                     $http.post('/Publicservices/ShowCalender',Args).then(function xSuccess(response)
                     {    var $cal=response.data;
                          $scope.days=$cal[0];
                          $scope.months=$cal[1];
                          $scope.years=$cal[2];
                     }), function xError(response)
                     {
                       toast_alert(response.data,'warning');
                     }
                  }
                  callCalender();


//----------------------------------
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
                            getAllOrderList();
                          }
                          else //Hide form Element when Products filter Changing
                          {  $scope.resultProduct=false;
                            $scope.ProductStatus=false;
                            $scope.OrderStatus=false;
                          }
                      }
                  else// find By PartNumber
                    {
                      $scope.resultProduct=true;
                      $scope.OrderStatus=true;
                      $scope.ProductStatus=true;
                      findProductByID ($scope.partnumbers_id);
                      getAllOrderList();
                    }

                }
//----------------------------------
                function findProductByID (pID)
                {
                  var Args={ productID:pID}
                  $http.post('/services/stock/getProductTitleBrandType',Args).then(function xSuccess(response)
                   {
                    $data=response.data;
                    $scope.echo_ProductID= $data[0].ProductsID;
                    $scope.echo_partNumber= $data[0].stkr_prodct_partnumber_commercial;
                    $scope.echo_Brand= $data[0].stkr_prodct_brand_title+" ";
                    $scope.prodct_type_cat= $data[0].stkr_prodct_type_cat;
                    $scope.echo_Type= $data[0].stkr_prodct_type_title;
                    $scope.echo_ProductTitle= $data[0].stkr_prodct_title;
                    //toast_alert($data[0].stkr_prodct_brand_title,'info');
                    if ($scope.prodct_type_cat==3)// is Chassis
                      {
                        $scope.show_Chassis_number=true;
                        $scope.show_SO_number=true;
                        $scope.new_form_control_SaveAndNext=true;
                        $scope.new_form_control=false;
                      }
                    else
                      {
                        $scope.show_Chassis_number=false;
                        $scope.show_SO_number=false;
                        $scope.new_form_control=true;
                        $scope.new_form_control_SaveAndNext=false;
                      }

                   }), function xError(response)
                   {
                     toast_alert(response.data,'warning');
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

//To finde PartNumber use two options
$scope.fiald_mode=function(mode)
{
  if (mode) // 3 filter
  {
    changeModeReset() ;
    $("#mode1").addClass("positive");
    $("#mode0").removeClass("positive");
    $scope.mode1_fiald=true;
    $scope.mode0_fiald=false;
    getAllBrands();

  }
  else  // filter By partNumber
  {
    changeModeReset() ;
    $("#mode0").addClass("positive");
    $("#mode1").removeClass("positive");
    $scope.mode0_fiald=true;
    $scope.mode1_fiald=false;
    getAllSerial(0);
  }
}

function changeModeReset()
{
    $scope.resultProduct=false;
    $scope.OrderStatus=false;
    $scope.ProductStatus=false;
    $scope.new_form_control=false;

    $(".partnumbers_id  .text.ng-binding" ).empty();
    $(".brandsID  .text.ng-binding" ).empty();
    $(".TypeID  .text.ng-binding" ).empty();
    $(".product_prtNum  .text.ng-binding" ).empty();
    $(".OderList  .text.ng-binding" ).empty();
    $(".calender.years  .text.ng-binding" ).empty();
    $(".calender.months  .text.ng-binding" ).empty();
    $(".calender.days    .text.ng-binding" ).empty();

    $scope.partNumber="";
    $scope.Quantity="";
    $scope.Chassis_number="";
    $scope.SO_number="";
    $scope.echo_ProductID="";
    $scope.echo_Brand="";
    $scope.echo_Type="";
    $scope.echo_ProductTitle="";
    $scope.echo_partNumber="";

}

//-----------------
//__SerialNumber Section in Dimmer___
$scope.show_serialNumber_form=function(pId)
{
  SelectDimmer('serialNumer');
  $('#Dimmer_page').dimmer('show');
}

$scope.close_serialN_dimmer=function()
{
  $('#Dimmer_page').dimmer('hide');
}

//-------------


  $scope.addNewChoice = function() {
    var newItemNo = $scope.choices.length+1;
    $scope.choices.push({'id':newItemNo});
    $scope.Quantity=parseInt($scope.Quantity)+1;
    if (parseInt($scope.Quantity)>=4) $("#Dimmer_page").addClass("dimmer_scroller");
  };

  $scope.removeChoice = function() {
    var lastItem = $scope.choices.length-1;
    $scope.choices.splice(lastItem);
    $scope.Quantity=parseInt($scope.Quantity)-1;
  };

  //--------------------------------------------

  $scope.makeSertilInput=function()
    {
      Quantity=  $scope.Quantity;
      $scope.choices = [];
        for (i=1;i<=Quantity;i++)
        {
          var newItemNo = $scope.choices.length+1;
          $scope.choices.push({'id':newItemNo});
        //    console.log($scope.choices);
          if (i>=4) $("#Dimmer_page").addClass("dimmer_scroller");

        }
    }
//---------------
//--------------------------------------

    $scope.checkEnterpressd=function ($event,id)
    {

        var keyCode = $event.which || $event.keyCode;
        if (keyCode===13)
        {
            newid=id+1;
            if (serial_status_mode =="2s" || $scope.haveTwoSerial)
            {
                $('.B'+id).trigger("focus");
            }
            else if  (serial_status_mode =="1s")
            {
                $('.A'+newid).trigger("focus");
            }
        }
    }


    $scope.checkEnterpressdBinputs=function ($event,id)
    {
        var keyCode = $event.which || $event.keyCode;
        if (keyCode===13)
        {
            newid=id+1;
            $('.A'+newid).trigger("focus");
        }
    }

//#######################################



}]);
