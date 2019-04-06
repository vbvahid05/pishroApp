

var app = angular.module('Sell_warranty_App', ['simplePagination']);

app.directive('onFinishRender', ['$timeout', '$parse', function ($timeout, $parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {

            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                    if ( !! attr.onFinishRender) {
                        $parse(attr.onFinishRender)(scope);
                    }
                });
            }
        }
    }
}])

app.filter('isZiro', function() {
    return function(value,rowID,rowCol) {

        //console.log("."+rowID+"rec"+rowCol);
        if (value !=0)
        {
            if (rowCol%2!=0)
                $("."+rowID+"rec"+rowCol).addClass("greenBlueX");
            else
                $("."+rowID+"rec"+rowCol).addClass("purple");
            return value;
        }
        else  return value;

    };
});
//------------
app.filter('Vcurrency',function()
{
    return function (BValue)
    {
        var  BaseValue=BValue+"";
        var  Value = BaseValue.split(".");

        leftVal=Value[0];
        RightVal=Value[1];
        //--------------
        res="";
        j=0;
        for(i=leftVal.length-1;i>=0;i--)
        {
            j++;
            if (j%3!=0)
            {
                res=leftVal[i]+res;
            }
            else
            {
                if (i!=0) res=","+leftVal[i]+res;
                else res=leftVal[i]+res;
            }
        }
        //--------------
        if (Value.length>=2)
        {
            return res+'.'+RightVal;
        }
        else
        {
            return res;
        }
    }
});
//------------
app.filter('signeChecker', function() {
    return function(value,rowID) {
        if (value<=0)
            $("."+"AvlStock"+rowID).addClass("red");
        else
            $("."+"AvlStock"+rowID).addClass("green");
        return value;
    };
});
//-----------
app.filter('checkMax', function() {
    return function(value,productType) {
        if (productType == 3)
        {
            return  1;
        }
        else
        {
            return  value;
        }

    };
});
//-----------
app.filter('Jdate', function() {
    return function(gdate) {
        var gdate;
        if (gdate !=undefined)
        {
            var res = gdate.split("-");
            day = parseInt(res[2]);
            month = parseInt(res[1]);
            year = parseInt(res[0]);

            return gregorian_to_jalali(year, month, day);
        }
    };
});
//-----------
app.filter('stockRequestTYPE', function() {
    return function(type) {
        if (type==1)
            return "تعهدی";
        else
            return "قطعی";
    };
});
//-------------
app.filter('ifNotnullEchoLabel', function() {
    return function(type) {
        if (type!=null)
            return "شناسه ی سریال نامبر  : "+type;
    };
});
//-------------
app.filter('DurationType', function() {
    return function(type) {
        if (type==30)
            return "ماه";
        if (type==365)
            return "سال";
    };
});


//-------------
app.filter('pTypeCat', function() {
    return function(rypecatid) {
        return  PublicF_AppFilter_pTypeCat(rypecatid);
    };
});



/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
app.controller('Sell_warranty_Ctrl', ['$scope','$http','Pagination','$filter','$sce',
    function($scope, $http,Pagination,$filter,$sce )
    {
//---------------###############################---------------
     function OnInit()
        {
            $scope.pageTypeIs=$('#pageType').val();
            var stockRequestProducts = [];
            var sritems = [];
            var invoice_detilas=[];
            totalEPL=0;
            getList_Warranty_Request($scope.pageTypeIs);
            $scope.masterArray=[];


        }
        OnInit();
//---------------###############################---------------
        //@@@ stock Request @@@
//---------------###############################---------------
        function getList_Warranty_Request(pageType)
        {


            var Args={mode:pageType}
            $http.post('/sell/stockRequest/service/warranty/getWarrantyList/1',Args).then(function xSuccess(response)
                 {
                     listArray=response.data;
                     $scope.allRowsZ=listArray;
                     $scope.Public_Page_Type=pageType;
                     console.log(response.data);

                     $http.post('/sell/stockRequest/service/warranty/GetSerialNumbers/1',Args).then(function xSuccess(response)
                        {
                            var content=response.data;
                            $('.ui.search')
                                .search({
                                    source : content,
                                    searchFields   : [
                                        'serial_number'
                                    ],
                                    fields: {
                                        results : 'serial_number',

                                    },
                                    fullTextSearch: false
                                }) ;
                       }), function xError(response)
                        {
                        }

                 }), function xError(response)
                {
                }
        }
///-------------------------------------------------
        $scope.newUpdateWarranty=function ($action,id) {
            $('.errorMessage').html('');
            $('.serialIcon').addClass('hide');
            $scope.ShowAlternativeSerialFlage=false;

            switch ($action)
            {
                case 'new':
                    $scope.ViewMode=0;
                    SelectDimmer('new');
                    $('#Dimmer_page').dimmer('show');
                    myArray=[];
                    $scope.stockrequestsID       ='';
                    $scope.custommerName         ='';
                    $scope.custommerFamily       ='';
                    $scope.orgName               ='';
                    $scope.DeliveryDate ='';
                    $scope.RegistrDate  ='';
                    $scope.warranty_delevery_date='';
                    $scope.warranty_start_date   ='';
                    $scope.WarrantyPeriod ='';
                    $scope.WarrantyDuration ='';
                    $scope.SeriallistArray=[];
                    $scope.Public_warrantyID='';
                    $scope.Warranty_total_Period='';


                    $scope.partnumber='';
                    $scope.Brand='';
                    $scope.Type='';
                    $scope.prodctTitle='';
                    $scope.snA='';
                    $scope.snB='';

                    break;
                case 'edit':
                    $scope.Public_warrantyID=id;
                    $scope.ViewMode=1;

                    $scope.partnumber='';
                    $scope.Brand='';
                    $scope.Type='';
                    $scope.prodctTitle='';
                    $scope.snA='';
                    $scope.snB='';

                    SelectDimmer('new');
                    $('#Dimmer_page').dimmer('show');

                    var Args={warrantyID:id   }
                    $http.post('/sell/stockRequest/service/warranty/getSavedWarrantyDataByID',Args).then(function xSuccess(response)
                    {
                        $dataValue=[];
                        $data=response.data[1];
                        $dataValue=response.data[2];

                        if ($data)
                        {
                            $scope.SeriallistArray=[];
                            i=0;
                            $data.forEach(doThisAction);
                            function doThisAction()
                            {
                            ($dataValue.length)? alternative_ser=$dataValue[i]['alternative_serial_sn']: alternative_ser=null;
                            ($dataValue.length)? alternative_ser_b=$dataValue[i]['alternative_serial_sn_b']: alternative_ser_b=null;
                            ($dataValue.length)? alternative_sn_id=$dataValue[i]['alternative_serial_sn']: alternative_sn_id='';
                            ($dataValue.length)? warrantie_id=$dataValue[i]['warrantie_id']: warrantie_id=$data[i]['warrantyID'];
                                var myArray = {
                                    warrantyID : $data[i]['warrantyID'] ,
                                    id:$data[i]['SN_ID'],
                                    snA:$data[i]['snA'] ,
                                    snB: $data[i]['snB'] ,
                                    prodctTitle:  $data[i]['prodctTitle'] ,
                                    partNumber:    $data[i]['partnumber'] ,
                                    alternativeSerialSn : alternative_ser,
                                    alternativeSerialSn_b : alternative_ser_b,
                                    alternativeSerialId :  $data[i]['alternative_serial_ID']  ,
                                    warrantie_id : warrantie_id

                                };
                                $scope.SeriallistArray.push(myArray);
                                // if (alternative_ser ==null)
                                //     $('#alternative_serial'+$data[i]['SN_ID']).val('');
                                // alert('alternative_serial'+$data[i]['SN_ID'] +' val '+alternative_ser);

                                // $('#alternative_serial'+$data[i]['SN_ID']).val('sdsdsdsdsd'+ $data[i]['SN_ID']);
                                // $('#alternative_serial'+$data[i]['SN_ID']).val('sdsdsdsdsd'+ $data[i]['SN_ID']);

                                i++;
                            }
                        }

                        console.log($scope.SeriallistArray);
                        //-----------------
                        baseData=response.data[0];
                        $DefultstockrequestID=baseData['stockrequestsID'];
                        $scope.defultStockRId=$DefultstockrequestID;

                        $scope.stockrequestsID       =baseData['stockrequestsID'];
                        $scope.custommerName         =baseData['custommerName'];
                        $scope.custommerFamily       =baseData['custommerFamily'];
                        $scope.orgName               ='-'+baseData['orgName'];
                        $scope.DeliveryDate =baseData['stockreqDelivery_date'];
                        $scope.RegistrDate  =baseData['stockreqRegistr_date'];
                        $scope.warranty_delevery_date=Date_Convert_gregorianToJalali(baseData['warranty_delivery_date']);
                        $scope.warranty_start_date   =Date_Convert_gregorianToJalali(baseData['warranty_start_date']);
                        $scope.WarrantyPeriod =baseData['WarrantyPeriod'] ;
                        $scope.WarrantyDuration =baseData['WarrantyDuration'].toString();

                        $scope.Warranty_total_Period=baseData['stockrequests_warranty_priod'];
                        $scope.Warranty_total_Expired_Date=Date_Convert_gregorianToJalali(baseData['stockrequests_warranty_ExpiredDate']);

                        $(".total_Expired").removeClass('label-success');$(".total_Expired").removeClass('label-danger');
                        if ( baseData['stockrequests_warranty_ExpiredDate'] >=baseData['todayDate'])
                           $(".total_Expired").addClass('label-success')
                        else
                            $(".total_Expired").addClass('label-danger')
                    }), function xError(response)
                    {
                    }
                break;
            }

            switch ($scope.Public_Page_Type)
            {
                case 'addRequest':
                    $scope.addRequest=true;
                    $scope.stockOut=false;

                    $scope.RequestMode=true;
                    console.log('addRequest')
                    break;
                case 'stockOut':
                    $scope.stockOut=true;
                    $scope.addRequest=false;

                    $scope.RequestMode=false;
                    console.log('stockOut')
                    break;
            }
        }
///-------------------------------------------------
        $scope.ShowAlternativeSerial_Input=function(id)
        {
            $scope.ShowAlternativeSerialFlage=true;
            $('#alternative_serial'+id).val('');
        }
///-------------------------------------------------
        $("#SerialNumberList").change(function() {

            SerialNumber = $("#SerialNumberList").val();
            $scope.Warranty_total_Period ='';
            $scope.warranty_start_date ='';
            $scope.WarrantyPeriod='';
            $scope.WarrantyDuration ='';
            $scope.Warranty_total_Expired_Date ='';
            $(".total_Expired").removeClass('label-success');$(".total_Expired").removeClass('label-danger');

            var Args={SerialNumberID:SerialNumber,}
            $http.post('/sell/stockRequest/service/warranty/getInfoAroundSerialNumber',Args).then(function xSuccess(response)
            {
                data= response.data;

                $scope.serialId=data[0]['SN_ID'];

                $scope.partnumber   =data[0]['partnumber'];
                $scope.Brand        =data[0]['Brand'];
                $scope.Type         =data[0]['Type'];
                $scope.prodctTitle  =data[0]['prodctTitle'];
                $scope.snA          =data[0]['snA'];
                $scope.snB          =data[0]['snB'];

                $scope.stockrequestsID       =data[0]['stockrequestsID'];
                $scope.custommerName         =data[0]['custommerName'];
                $scope.custommerFamily       =data[0]['custommerFamily'];
                $scope.orgName               ='-'+data[0]['orgName'];
                $scope.DeliveryDate =data[0]['stockreqDelivery_date'];
                $scope.RegistrDate  =data[0]['stockreqRegistr_date'];

                $scope.Warranty_total_Period =data[0]['stockrequests_warranty_priod'];
                $scope.warranty_start_date   =Date_Convert_gregorianToJalali( data[0]['stockreqDelivery_date']);
                $scope.WarrantyPeriod=data[0]['stockrequests_warranty_priod'] ;
                $scope.WarrantyDuration="30";
                $scope.Warranty_total_Expired_Date=Date_Convert_gregorianToJalali(data[0]['Warranty_total_Expired_Date']);

                if ( data[0]['Warranty_total_Expired_Date'] >=data[0]['todayDate'])
                    $(".total_Expired").addClass('label-success')
                else
                    $(".total_Expired").addClass('label-danger')


            }), function xError(response)
            {
            }
        });

///-------------------------------------------------

   function addToArray()
   {
       var myArray = {
           id:$scope.serialId,
           snA: $scope.snA,
           snB: $scope.snB,
           prodctTitle:  $scope.prodctTitle ,
           partNumber:  $scope.partnumber
       };
       $scope.SeriallistArray.push(myArray);
   }
///-------------------------------------------------
 $scope.addSerialToList=function()
 {
     i=0;
     result=0;
     if ($scope.serialId )
     {
         if ($scope.SeriallistArray.length==0)
         {
             addToArray();
             $DefultstockrequestID=$scope.stockrequestsID;
             $scope.defultStockRId=$DefultstockrequestID;
         }
         else
         {
             $scope.SeriallistArray.forEach(doAction);
             function doAction()
             {
             if ($scope.SeriallistArray[i].id == $scope.serialId) { result++;  }i++;}
             if (result<1 && $DefultstockrequestID == $scope.stockrequestsID)
             {  addToArray();  }
         }
         if ($DefultstockrequestID != $scope.stockrequestsID)
         {
             toast_alert('stockrequest is Changed','danger');
         }
         console.log($scope.SeriallistArray);
     }
     else  toast_alert('select a Serial Number' ,'warnign');
 }
///-------------------------------------------------
 $scope.removeFromList=function(index,id)
 {
     /*confirm ؟ */
     access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
     if (access)
     {
            if ($scope.Public_warrantyID)
            {
                var Args={warrantyID:$scope.Public_warrantyID,
                    SerialNumberID:id }
                $http.post('/sell/stockRequest/service/warranty/RemoveSerialFromList',Args).
                then(function xSuccess(response)
                {
                    console.log(response.data);
                    $scope.SeriallistArray.splice(index, 1);
                })
                    , function xError(response)
                {
                }
            }
            else
                $scope.SeriallistArray.splice(index, 1);
     }
 }

///-------------------------------------------------
$scope.save_Update_Warranty=function (action) {
    var WarrantyInfoArray = {
        stockrequestsID:$scope.stockrequestsID,
        delevery_date:$("#warranty_delevery_date").val(),
        start_date: $("#warranty_start_date").val(),
        WarrantyPeriod:$("#WarrantyPeriod").val(),
        WarrantyDuration:$scope.WarrantyDuration
    };
    // $scope.SeriallistArray.push(myArray);
        masterArray=[];

    if ($scope.SeriallistArray.length !=0 )
    {
        masterArray.push(WarrantyInfoArray);
        masterArray.push($scope.SeriallistArray);

        switch (action)
        {
            case 'save':
                  $url='/sell/stockRequest/service/warranty/SaveWarrantyForm/0';
            break;

            case 'saveAndSendToStock':
                $url='/sell/stockRequest/service/warranty/SaveWarrantyForm/1';
                break;

            case 'update':
                 $url='/sell/stockRequest/service/warranty/UpdateWarrantyForm/0';
                 masterArray.push($scope.Public_warrantyID);
            break;

            case 'updateAndSendToStock':
                $url='/sell/stockRequest/service/warranty/UpdateWarrantyForm/1';
                masterArray.push($scope.Public_warrantyID);
                break;

        }

        $http.post($url,masterArray).
        then(function xSuccess(response)
        {
            if (response.data)
            {
                toast_alert(Seved_Message,'success');
                getList_Warranty_Request($scope.pageTypeIs);
                $scope.close_warranty_dimmer();

            }
            console.log(response.data)



        }), function xError(response)
        {
        }

    }
    // console.log(masterArray);
}
///-------------------------------------------------
        $scope.Add_alternative_serial=function(warrantie_id,faulty_serial)
        {

            var Args={
                warrantyID:warrantie_id,
                faulty_serialID:faulty_serial ,
                alternative_serial :$("#alternative_serial"+faulty_serial).val()
            }

            $http.post('/sell/stockRequest/service/warranty/addAlternativeSerial',Args).
            then(function xSuccess(response)
            {
                $respond=response.data;
                //console.log($respond[0]['error']);

                if ($respond[0]['error'] =='Ok')
                {
                    $('#SNb'+faulty_serial).html($respond[0]['value'])  ;
                    $('#Tikicon'+faulty_serial).removeClass('hide');
                    $('#failedIcon'+faulty_serial).addClass('hide');
                    $('#errorMessage'+faulty_serial).html('')  ;

                    // $("#alternative_serial"+faulty_serial).attr('readonly', true);

                }
                else
                {
                    errorMessage="";
                    switch ($respond[0]['code'])
                    {
                        case  '100' :
                                errorMessage="این سریال وجود ندارد";
                         break;
                        case  '101' :
                                errorMessage="سریال خارج شده";
                         break;

                        case  '102' :
                                errorMessage="عدم مطابقت سریال با کالا";
                         break;
                    }
                    $('#errorMessage'+faulty_serial).html(errorMessage)  ;
                    $('#failedIcon'+faulty_serial).removeClass('hide');
                    $('#Tikicon'+faulty_serial).addClass('hide');
                }



            })
                , function xError(response)
            {
            }
        }
///-------------------------------------------------
 $scope.backToWarrantyRequest =function(arry)
 {
     i=0;
     errorMessage="";
     arry.forEach(doAction);
     function doAction()
     {
         if (arry[i]['alternativeSerialSn'] ==null)
             errorMessage=errorMessage+arry[i]['partNumber']+"<br/>";
         i++

     }

    if (errorMessage.length==0)
    {
        var Args={
            warrantyID:$scope.Public_warrantyID,
        }

        $http.post('/sell/stockRequest/service/warranty/backToWarrantyRequest',Args).
        then(function xSuccess(response)
        {
            getList_Warranty_Request($scope.pageTypeIs);
            toast_alert('انجام شد' ,'info');
            $scope.close_warranty_dimmer();
            console.log(response.data);
        })
            , function xError(response)
        {
        }
    }
     else
     toast_alert(errorMessage ,'danger');
 }
///-------------------------------------------------
//  $scope.getPDF=function(warranty_id)
//  {
//      var Args={
//          warrantyID:warranty_id,
//      }
//      $http.get('sell/warranty/pdf/'+warranty_id).
//      then(function xSuccess(response)
//      {
//          return response.data;
//
//      })
//          , function xError(response)
//      {
//      }
//  }

///-------------------------------------------------
//    $scope.save_Update_alternative_serial=function()
//    {
//        Seriallist=$scope.SeriallistArray;
//        console.log(Seriallist)
//        $scope.Serialls=[];
//         i=0;
//        Seriallist.forEach(doThisAction);
//        function doThisAction()
//        {
//            var myArray = {
//
//                id:Seriallist[i]['id']
//
//            };
//
//            $scope.Serialls.push(myArray);
//            i++;
//        }
//        console.log($scope.Serialls)
//
//    }

///-------------------------------------------------
    $scope.close_warranty_dimmer=function()
    {
        $('#Dimmer_page').dimmer('hide');
    }


///-------------------------------------------------

        $scope.saveOrUpdate_alternative_serial=function ($event,warrantie_id ,faulty_serial)
        {
            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {

                $scope.Add_alternative_serial($scope.Public_warrantyID,faulty_serial);
                $scope.newUpdateWarranty('edit',$scope.Public_warrantyID);
                // newid=id+1;
                // $('.A'+newid).trigger("focus");
            }
        }

///-------------------------------------------------
        $scope.delete_alternative_serial=function (warrantyID,alternativeSerialId ,fultSN) {
            var Args={
                warrantyID:$scope.Public_warrantyID,
                faulty_serialID:fultSN ,
                alternative_serial :alternativeSerialId
                    }

            $http.post('/sell/stockRequest/service/warranty/delete_alternative_serial',Args).
            then(function xSuccess(response)
            {
                if(response.data == 'failed')
                {
                    toast_alert('بروز خطا','danger')
                    // $scope.newUpdateWarranty('edit',warrantyID);
                }
                else {
                     toast_alert(deleted_Message,'warning');
                    $scope.snA          ='';
                    $scope.snB          ='';
                    $('#SNb'+fultSN).html('');
                    $('#alternative_serial'+fultSN).val('');
                    $("#alternative_serial"+fultSN).attr('readonly', false);
                    $("#Tikicon"+fultSN).addClass('hide');


                    $scope.newUpdateWarranty('edit',$scope.Public_warrantyID)


                    // i=0;
                    // data=$scope.SeriallistArray;
                    // data.forEach(doThisAction);
                    // function doThisAction()
                    // {
                    //     if ($scope.SeriallistArray[i]['fultSN']==fultSN)
                    //     {
                    //         var myArray = {
                    //             warrantyID : $data[i]['warrantyID'] ,
                    //             id:$data[i]['SN_ID'],
                    //             snA:$data[i]['snA'] ,
                    //             snB: $data[i]['snB'] ,
                    //             prodctTitle:  $data[i]['prodctTitle'] ,
                    //             partNumber:    $data[i]['partnumber'] ,
                    //             alternativeSerialSn :'',
                    //             alternativeSerialId :  ''  ,
                    //             warrantie_id : warrantie_id
                    //
                    //         };
                    //         $scope.SeriallistArray.push(myArray);
                    //     }
                    //     i++;
                    // }
                    // console.log($scope.SeriallistArray);
                     // $scope.newUpdateWarranty('edit',$scope.Public_warrantyID);

                }
            })
                , function xError(response)
            {
                console.log(response.data);
            }
        }
//**************Public Functions
        function SelectDimmer(dimmer)
        {
            switch(dimmer)
            {
                case 'new':
                    $scope.selectedModeIs=  'new';
                    $scope.FormTitle=lbl_Warranty_StockRequest;
                    $scope.section_new_edit_in_Dimmer=true; //show add_new_putting
                    $scope.section_sub_chassis_list=false;
                    //Page Decoration
                    $scope.newStockRequestForm=true;
                    $scope.ViewStockRequestForm =false;
                    $scope.selectProductBar=false;
                    $scope.resultProduct=false;
                    $scope.tabelContainer=false;
                    $scope.addNew_form_control=false;
                    $scope.edit_form_control=false;
                    //reset fields
                    $scope.sr_type="";
                    $scope.sr_custommer="";
                    $scope.sr_preFaktorNum="";
                    $scope.sr_deliveryDate="";
                    break;

                case 'edit':
                    $scope.selectedModeIs='edit';
                    $scope.FormTitle=lbl_TakeOutProducts;
                    $scope.FormTitle_viewMode =lbl_view_stockRequest;

                    $scope.section_convert_stockrequerst_in_Dimmer=false;

                    $scope.section_new_edit_in_Dimmer=true; //show add_new_putting
                    $scope.section_sub_chassis_list=false;
                    $scope.section_pdf_Setting_dimmer=false;
                    //Page Decoration
                    $scope.newStockRequestForm=false;
                    $scope.ViewStockRequestForm =true;
                    $scope.selectProductBar=true;$scope.mode0_fiald =true;
                    $scope.resultProduct=false;
                    $scope.tabelContainer=true;
                    $scope.addNew_form_control=false;
                    $scope.edit_form_control=false;
                    //reset fields
                    $scope.sr_type="";
                    $scope.sr_custommer="";
                    $scope.sr_preFaktorNum="";
                    $scope.sr_deliveryDate="";

                    $scope.totalQTY="";
                    $scope.product_QTY="";
                    $scope.maxQTY=1000;
                    $scope.stockRequestProductsArray=[];
                    $scope.confirmStockRequestBTN=false;

                    break;

                case 'convert_StockRequest':
                    $scope.section_convert_stockrequerst_in_Dimmer=true;
                    $scope.section_pdf_Setting_dimmer=false;
                    $scope.FormTitle_convert='CONVERT';
                    break;

                case 'section_pdf_Setting_dimmer':
                    $scope.section_pdf_Setting_dimmer=true;
                    $scope.section_convert_stockrequerst_in_Dimmer=false;
                    $scope.section_new_edit_in_Dimmer=false;
                    $scope.FormTitle_Setting='pdf Setting ';
                    break;



                case 'new_invoice':
                    $scope.section_new_edit_invoice_in_Dimmer=true;
                    $scope.formStatus='new';
                    $scope.section_pdfSetting_dimmer=false;
                    $scope.section_searchInvoice_dimmer =false;
                    // Form Controllers
                    break;

                case 'edit_invoice':
                    $scope.section_new_edit_invoice_in_Dimmer=true;
                    $scope.section_convert_stockrequerst_in_Dimmer=false;
                    $scope.section_addSubProduct_dimmer=false;
                    $scope.formStatus='edit';
                    $scope.FormTitle=lbl_Edit_invoice;
                    $scope.FormTitle_viewMode=lbl_Edit_invoice;
                    $scope.section_pdfSetting_dimmer=false;
                    $scope.section_searchInvoice_dimmer =false;
                    break;

                case 'subPartToinvoice' :
                    $scope.section_addSubProduct_dimmer=true;
                    $scope.section_new_edit_invoice_in_Dimmer=false;
                    $scope.section_convert_stockrequerst_in_Dimmer=false;
                    $scope.section_new_edit_invoice_in_Dimmer=false;
                    break;


                case 'sub_chassis_list':
                    $scope.section_sub_chassis_list=true;
                    $scope.section_new_edit_in_Dimmer=false;
                    $scope.section_new_edit_invoice_in_Dimmer=false;
                    // $scope.formStatus='edit';
                    $scope.FormTitle_viewMode='sub_chassis';
                    break;



                case  'section_pdfSetting' :
                    $scope.section_pdfSetting_dimmer=true;
                    $scope.section_new_edit_invoice_in_Dimmer=false;
                    $scope.section_addSubProduct_dimmer=false;
                    $scope.section_sub_chassis_list=false;
                    $scope.section_searchInvoice_dimmer =false;
                    break;


                case  'section_searchInvoice' :
                    $scope.section_searchInvoice_dimmer =true;
                    $scope.section_pdfSetting_dimmer=false;
                    $scope.section_new_edit_invoice_in_Dimmer=false;
                    $scope.section_addSubProduct_dimmer=false;
                    $scope.section_sub_chassis_list=false;
                    break;
            }
        }

//**************
        $scope.showSubchassisParts=function (chassisID,StockRequestRowID,StockRequestID,product_partnumbers ,ProductTitle,index) {
            SelectDimmer('sub_chassis_list');
            $('#Dimmer_page').dimmer('show');
            $scope.FormTitle='lbl_partList';
            $scope.partnumbers =product_partnumbers;
            $scope.ProductTitle =ProductTitle;
            $scope.index =index;

            $scope.StockRequestID=StockRequestID;
            $scope.chassisID =chassisID;
            $scope.StockRequestRowID=StockRequestRowID;

            //------Get Current Form Type -------------------------

            //-----------------------------------------------------


            var args=
                {qmode:1,StockRequest_ID:StockRequestID ,chassisID:chassisID ,StockRequestRowID:StockRequestRowID };
            $http.post('/services_sell/Stockrequest/GetSubChassisParts',args).then
            (function xSuccess(response)
            {
                console.log(response.data);
                $scope.SubChassispart=response.data[0];
                $scope.formType=response.data[1];
                $scope.saved_SubchassisParts=[];
                get_saved_SubchassisParts(StockRequestRowID);

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
        }

//---------------
        function get_saved_SubchassisParts(StockRequestRowID)
        {

            $scope.showEmptyListMessage=false;
            $scope.showspinner=true;
            var args=
                {   qmode:1,ParentChasisID:StockRequestRowID};
            $http.post('/services_sell/Stockrequest/get_saved_SubchassisParts',args).then
            (function xSuccess(response)
            {

                $scope.saved_SubchassisParts=response.data;
                if (response.data.length !=0)
                    $scope.saved_SubchassisParts=response.data;
                else
                    $scope.showEmptyListMessage =true;
                $scope.showspinner=false;

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }

        }
//**************
        $scope.closeSubchassisParts=function()
        {
            StockRequestID=($scope.echo_StockRequestID);
            SelectDimmer('edit');
            $('#Dimmer_page').dimmer('show');
            $scope.EditSelected(StockRequestID);

        }
//**************
        $scope.deleteSubChassisItem=function(StockRequestID , chassisID ,stckreqstDtlRowID,productID,subchassisProductID,formType)
        {
            var args=
                {
                    formType :formType,
                    stckreqstDtlRowID:stckreqstDtlRowID,
                    productID :subchassisProductID
                };
            $http.post('/services_sell/Stockrequest/delete_SubChassis_Item',args).then
            (function xSuccess(response)
            {
                if (response.data=='done')
                {
                    $scope.showSubchassisParts  (productID,chassisID,StockRequestID )
                    // $scope.showSubchassisParts(chassisID,stckreqstDtlRowID,StockRequestID);
                }
                else
                    toast_alert(response.data,'danger');
                console.log(response.data)

            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }


        }



        $scope.closeDimmer=function()
        {
            $('#Dimmer_page').dimmer('hide');
            getList_StockRequest(0);
        }
//**************
//ToolBar BTN      ||-> Add New StockRequest
        $scope.add_new=function()
        {
            SelectDimmer('new');
            $('#Dimmer_page').dimmer('show');
            getList_AllCustommers(0);

            $("#mode0").addClass("positive");
            $("#mode1").removeClass("positive");
            $scope.mode0_fiald=true;
            $scope.mode1_fiald=false;
        }
// BTN      ||-> edit Stock Request Row
        $scope.EditSelected=function(StockRequest_id)
        {
            $scope.PublicStockRequestid=StockRequest_id;
            SelectDimmer('edit');
            $('#Dimmer_page').dimmer('show')
            $("#mode0").addClass("positive");
            $("#mode1").removeClass("positive");
            $scope.mode0_fiald=true;
            $scope.mode1_fiald=false;
            $scope.mode=0;

            $scope.showpreFaktorNum=false;
            $scope.showCustommerList=false;
            $scope.showDliverDate=false;
            $scope.showRegistrdays=false;


            getList_PartNumbers(0);

            $(".section_new_edit").removeClass("lowOpacity");
            var args=
                {
                    qmode:0,
                    StockRequestID:StockRequest_id
                };
            $http.post('/services/sell/getStockRequestData_by_id',args).then
            (function xSuccess(response)
            {
                $resp=response.data[0];
                $scope.sr_cstmr_id=  $resp.cstmr_id
                $scope.sr_custommer=$resp.cstmrName+' '+$resp.cstmrFamily;
                $scope.sr_type=$resp.stockRequestsType.toString();
                $scope.sr_preFaktorNum=$resp.contract_number;

                $('.selectpicker').selectpicker('val', $resp.cstmr_id.toString());

                $scope.sr_deliveryDate=$resp.delivery_date;
                var res =$scope.sr_deliveryDate.split("-");
                $scope.jalaiDliver=gregorian_to_jalali( parseInt(res[0]), parseInt(res[1]), parseInt(res[2]));
                var res =$scope.jalaiDliver.split("/");
                $scope.Dliverdays=res[2];
                $scope.DliverMonths=res[1];
                $scope.Dliveryears=res[0];

                $scope.sr_registration_date=$resp.registration_date;
                var res =$scope.sr_registration_date.split("-")
                $scope.jalaiRegistr=gregorian_to_jalali( parseInt(res[0]), parseInt(res[1]), parseInt(res[2]));
                var res =$scope.jalaiRegistr.split("/");
                $scope.Registrdays=res[2];
                $scope.RegistrMonths = res[1];
                $scope.Registryears = res[0];


//-----------------Get Organization Name -------
                if ($resp.cstmrOrganization) // if cstmr Organization not null
                {
                    var args=
                        {qmode:1,StockRequestID:StockRequest_id};
                    $http.post('/services/sell/getStockRequestData_by_id',args).then
                    (function xSuccess(response)
                    {
                        $resp=response.data[0];
                        $scope.sr_Org_Name=$resp.orgName;
                    }), function xError(response)
                    {
                        toast_alert(response.data,'danger');
                    }
                }
//--------------GET stockrequests Products---------------
                $scope.Loading_waitForDB=true;
                var args=
                    {qmode:2,StockRequestID:StockRequest_id};
                $http.post('/services/sell/getStockRequestData_by_id',args).then
                (function xSuccess(response)
                {
                    console.log(response.data);
                    stockRequestProducts=response.data;
                    $scope.stockRequestProductsArray= stockRequestProducts;

                    $scope.Loading_waitForDB=false;
                    //  $resp=response.data[0];
                    //  $scope.sr_Org_Name=$resp.orgName;
                }), function xError(response)
                {
                    toast_alert(response.data,'danger');
                }
//-----------------------------
                console.log(response.data);
                $("#Dimmer_page").addClass("dimmer_scroller");
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }
            $scope.echo_StockRequestID =StockRequest_id;
            //$scope.sr_custommer="@";
            $('.refreshBtn i.fa.fa-refresh').removeClass('fa-spin');
        }

        //-------------------
        $scope.DeleteRequestFromBaseList=function(rowid)
        {
            /*confirm ؟ */
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if(access)
            {
                var Args = {
                    rowid: rowid,
                }
                $http.post('/services/sell/Delete_StockRequest_From_BaseList', Args).then(function xSuccess(response) {
                    if (response.data == 1) {
                        $("#row" + rowid).hide(1000);
                    }
                    else if (response.data == 0) {
                        toast_alert(delete_error_message_cant_delete_base_Stack_request, 'danger');
                    }
                    console.log(response.data)
                }), function xError(response) {
                }
            }

        }
        //-------------------
        $scope.Delete_product_of_Request=function(index,type,StockRequestID,productID,StockRequestRowID ,formType)
        {
            /*confirm ؟ */
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if(access)
            {
                var Args={
                    index:index,
                    type:formType,
                    StockRequestID:StockRequestID,
                    productID:productID,
                    StockRequest_RowID :StockRequestRowID,
                }
                console.log(Args);

                // //JSON.stringify(data))
                $http.post('/services_sell/Stockrequest/Delete_product_of_Request', Args).then(function xSuccess(response)
                {    console.log(response.data);

                    if (response.data !='SerialFlagError')
                    {
                        stockRequestProducts.splice(index, 1);
                        $("#DivRow" + index).hide(1000);
                    }
                    else toast_alert(delete_SerialFlagError,'danger');

                }), function xError(response) { }
            }
        }

//**************()
//Load List



        //--------------------------------------------------------
        $scope.changePagin=function()
        {
            $('.vbDropList').addClass('show');
            getList_StockRequest(0,0,100000);

        }
//-------------------------------------------------
//     $scope.showDroplist=function()
//     {
//         getList_StockRequest(0,0,100000);
//         if ($scope.search.cstmr_family.length >=3)
//         {
//              $('.vbDropList').addClass('show');
//              $('.vbDropList').removeClass('hide');
//         }
//     }
//-------------------------------------------------
//     $scope.hideDroplist=function()
//     {
//
//         if ($scope.search.cstmr_family.length <3)
//         {
//             $('.vbDropList').addClass('hide');
//             $('.vbDropList').removeClass('show');
//         }
//     }
//-------------------------------------------------
// $scope.SelectItemFromDropList=function(family)
// {
//     try {
//         $scope.search.cstmr_family =family;
//     }
//     catch (e) {
//             $('#serchInput').val(family);
//     }
//
//     $('.vbDropList').addClass('hide');
//     $('.vbDropList').removeClass('show');
// }
        //--------after show List  Show Action Buttons -----------
        $scope.showActionBTNs=function ()
        {
            $.each(listArray, function (index, value)
            {
                if (value['totalQTY'] ==value['AvailableQTY'] && value['AvailableQTY'] >0  &&  value['lockStatus'] ==0 )
                {
                    $("#Finalconfirm"+value['id']).addClass('showtoggleButton');
                }
                else if (value['totalQTY'] ==value['AvailableQTY'] && value['lockStatus']==1 )
                {
                    $('#action_print'+value['id']).addClass('showtoggleButton')
                    $('#action_pdf'+value['id']).addClass('showtoggleButton')

//hidden Edit Btn if Stockrequest commited
//          $('#row'+value['id']+' .editBtn').addClass('hideEditBTN')
                }
            });
        }
        //--------------------
        $scope.ActionBTN=function(btn_type,requerstID,AvailableQTY,totalQTY,lockStatus)
        {
            if (btn_type ==1) //Finalconfirm
            {
                $scope.EditSelected(requerstID); // show Mastre edit dimmerPage
                $scope.confirmStockRequestBTN=true;
                getList_StockRequest(0);
            }
            else if (btn_type==2) //action_print
            {
                //alert('action_print '+requerstID);
                var newFormData={mode:0,requerst_ID:requerstID};
                $http.post('/sell/stockRequest/print',newFormData).then
                (function pSuccess(response)
                {
                    console.log(response.data);
                    getList_StockRequest(0);

                }), function xError(response)
                {
                }
            }

        }
        //--------------------
        $scope.confirmStockRequest=function(StockRequestID)
        {
            var Args={
                table:'xeeZsstkREqssz',
                rowTitle:'sel_sr_lock_status',
                selectesRowId:StockRequestID,
                rowValue:1
            }
            $http.post('/Publicservices/UpdateSingleRecord',Args).then(function xSuccess(response)
            {
                getList_StockRequest(0);
                $('#Dimmer_page').dimmer('hide');
                toast_alert(Finalconfirm_message,'success');
            }), function xError(response)
            {
                toast_alert(response.data,'warning');
            }
        }
        //---------------
        $scope.insertStockRequestToDB=function()
        {
            date= jalali_to_gregorian(parseInt($scope.zyears),parseInt($scope.zMonths),parseInt($scope.zdays));
            conf_date=date[0]+"-"+date[1]+"-"+date[2];
            $scope.sr_deliveryDate=conf_date;
            $scope.sr_Org_Name=$("#sr_custommer option:selected").text();
            msg="";
            if ($scope.sr_type =='') msg=stockRequest_Type_is_required_message+"<br/>";
            if ($('#sr_custommer').val() =='') msg=Select_custommer_message+"<br/>"+msg;
            if ($scope.sr_preFaktorNum =='') msg=insert_Faktor_number_messager+"<br/>"+msg;

            if (msg !="") toast_alert(msg,'warning');
            else
            {
                var Args={
                    sr_type:$scope.sr_type,
                    sr_custommer_id:$('#sr_custommer').val(),
                    sr_preFaktorNum:$scope.sr_preFaktorNum,
                    sr_deliveryDate:conf_date
                }
                console.log(Args);

                $http.post('/services/sell/addStockRequestToDB',Args).then(function xSuccess(response)
                {
                    $scope.echo_StockRequestID=response.data;
                    stockRequestProducts=[]; //reset SubProducts Array List
                    getList_StockRequest(0); //Refresh StockRequest List ...
                    getList_PartNumbers(0);
                    /*----*/
                    $scope.newStockRequestForm=false;
                    $scope.ViewStockRequestForm =true;
                    $scope.selectProductBar=true;
                }), function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
            }
        }
        //--------------------
        function getList_AllCustommers(mode)
        {
            var Args={mode:0,}
            $http.post('/services/sell/getList_AllCustommers',Args).then(function xSuccess(response)
            {
                return  $scope.custommerList=response.data;
            }), function xError(response)
            {
                toast_alert(response.data,'warning');
            }
        }

        //--------------------
        function  setDateDropDown()
        {
            $scope.daysNum=[];
            $scope.Months=[];
            $scope.years =[];
            for (i=1;i<=31;i++){$scope.daysNum.push({'id':i});}
            for (i=1;i<=12;i++) {$scope.Months.push({'id':i});}
            for (i=1396;i<=1450;i++){$scope.years.push({'id':i});}
            var d = new Date();
            day  =d.getDate();
            month=d.getMonth();
            year = d.getFullYear();
            month=month+1;
            if (month==13) month=1;
            resDate= gregorian_to_jalali(year, month, day);
            var res = resDate.split("/");
            $scope.zdays   = res[2];
            $scope.zMonths =res[1];
            $scope.zyears  = res[0];
        }
        setDateDropDown();
        $scope.set_today_date=function () {
            setDateDropDown();
        }
        //--------------------
        function getList_PartNumbers(mode)
        {
            var Args={
                mode:0,
            }
            $http.post('/services/sell/ListOfPartNumbers',Args).then(function xSuccess(response)
            {
                console.log(response.data);
                $scope.ListOfPartNumbers=response.data;
            }), function xError(response)
            {
                toast_alert(response.data,'warning');
            }
        }
        //-----------------------------

        $("#product_partnumbers_SR").change(function(){

            j=0;
            productID=$('#product_partnumbers_SR').val();
            Marray=$scope.ListOfPartNumbers;
            for (var i=0; i<Marray.length; i++)
            {
                if (Marray[i].productID == productID)
                    j=i;
                $scope.echo_ProductTitle=Marray[j].productTitle;
                $scope.echo_Type=Marray[j].productType;
                $scope.echo_Brand=Marray[j].productBrand;
                $scope.echo_typeCat=Marray[j].typeCat;
            }

            //-----------------------
            if ($scope.sr_type==0)  // agar ghaTiii Bood
            {
                var Args={
                    product_ID:productID,
                }
                $http.post('/services/sell/countofavailableProduct',Args).then(function xSuccess(response)
                {
                    /**/
                    $scope.resultProduct=true;
                    /**/
                    $scope.totalQTY=parseInt(response.data);
                    $scope.maxQTY=parseInt(response.data);
                    //$scope.product_QTY=parseInt(response.data);
                    $scope.product_QTY=parseInt(1);
                }), function xError(response)
                {
                    console.log(response.data);
                }
            }
            else {

                var Args={
                    product_ID:productID,
                }
                $http.post('/services/sell/countofavailableProduct',Args).then(function xSuccess(response)
                {
                    /**/
                    $scope.resultProduct=true;
                    /**/
                    $scope.totalQTY="~";
                    //$scope.maxQTY=parseInt(response.data);
                    $scope.product_QTY=parseInt(1);
                }), function xError(response)
                {
                    console.log(response.data);
                }
            }

        });

        $scope.selectProduct=function(mode)
        {
            if (mode==1)
            {
                productID=$scope.product_prtNum;
                //***************
                var Args={
                    t:'xeeptprodusz',
                    mode:0,
                    key:'id',
                    value:productID
                }
                $http.post('/Publicservices/relatedDatalist',Args).then(function xSuccess(response)
                {

                    productData=response.data;
                    $scope.echo_Brand=$scope.brandsID;
                    $scope.echo_Type=$scope.TypeID;
                    $scope.echo_ProductTitle= productData[0].stkr_prodct_title;

                }), function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
                //**************
            }
            //-----------------------
            if ($scope.sr_type==0)  // agar ghaTiii Bood
            {
                var Args={
                    product_ID:productID,
                }
                $http.post('/services/sell/countofavailableProduct',Args).then(function xSuccess(response)
                {
                    /**/
                    $scope.resultProduct=true;
                    /**/
                    $scope.totalQTY=parseInt(response.data);
                    $scope.maxQTY=parseInt(response.data);
                    //$scope.product_QTY=parseInt(response.data);
                    $scope.product_QTY=parseInt(1);
                }), function xError(response)
                {
                    console.log(response.data);
                }
            }
            else {
                /**/
                $scope.resultProduct=true;
                $scope.product_QTY=parseInt(1);
                $scope.totalQTY="~";
                /**/
            }


        }
        //-----------------------------
        $scope.add_product_to_StockRequest=function(StockRequestID,sr_type)
        {
            product_QTY =$("#product_QTY").val();
            //---
            $scope.tabelContainer=true;
            $scope.resultProduct=false;
            if ($scope.selectedModeIs=='new')
                $scope.addNew_form_control=true;
            if ($scope.selectedModeIs=='edit')
                $scope.edit_form_control=true;
            //---


            i=0;result=0;falg=true;
            if ($scope.mode ==0)
                productID:$scope.product_partnumbers
            else if ( $scope.mode==1)
                productID:$scope.product_prtNum;

            var Args={
                StockRequestType:sr_type,
                StockRequestID :StockRequestID,
                product_ID:productID,
                product_QTY:$scope.product_QTY
            }
            console.log(Args);
            $http.post('/services_sell/Stockrequest/addProductToStockRequest',Args).then(
                function xSuccess(response)
                {
                    console.log(response.data);
                    $scope.EditSelected(StockRequestID);
                }), function xError(response)
            {
                alert(response.data);
            }
        }

        //-----------
        $scope.add_subchassis_to_list_by_Enter=function($event,stockRequestID,chassisID,StockRequestRowID,partID ,availQty,formType)
        {
            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13) {
                add_sub_chassis(stockRequestID,chassisID,StockRequestRowID,partID ,availQty,formType)
            }
        }
        //-0------------------------
        $scope.add_subchassis_to_list=function(stockRequestID,chassisID,StockRequestRowID,partID ,availQty,formType)
        {
            add_sub_chassis(stockRequestID,chassisID,StockRequestRowID,partID ,availQty,formType)
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        function add_sub_chassis(stockRequestID,chassisID,StockRequestRowID,partID ,availQty,formType)
        {
            QTY=$('#product_QTY'+partID).val();
            var Args={
                formType:formType,// ghaTii 0  ya TaaHoDI 1
                stockRequestID :stockRequestID ,
                chassisID:chassisID,
                StockRequestRowID:StockRequestRowID ,
                partID:partID,
                QTY:QTY,
            }
            if (formType==0) //GHatii
            {
                if (QTY !=0 &&  QTY<=availQty)
                {
                    add_sub_Chassis_handler(Args);
                }
                else
                {
                    if (QTY==0) toast_alert(message_stockRequest_Qty_not_ziro,'warning');
                    else if (QTY >availQty)  toast_alert(message_QTY_moreTHenavailQty,'warning');
                }
            }
            else    //Ta'ahodi
            {
                if (QTY !=0)
                {
                    add_sub_Chassis_handler(Args);
                }
                else
                {
                    toast_alert(message_stockRequest_Qty_not_ziro,'warning');
                }
            }


        }
///----------------
        function add_sub_Chassis_handler(Args)
        {
            $http.post('/services_sell/Stockrequest/AddSubChassisPartsToDB',Args).then(
                function xSuccess(response)
                {
                    console.log(response.data);

                    $scope.showSubchassisParts(Args['chassisID'], Args['StockRequestRowID'],Args['stockRequestID'],'','','');
                    get_saved_SubchassisParts(Args['StockRequestRowID']);
                    toast_alert( Seved_Message,'success');
                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
        }
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//-------------
        $scope.hide_subchassis=function(selectedProduct)
        {
            $("#sub_row_list"+selectedProduct).addClass("hide");
        }
        //-------------
        $scope.addNewTo_DB=function (mode)
        {
            if(stockRequestProducts.length)
            {
                var Args={
                    type:'inserNew',
                    formType:$scope.sr_type , // ghaTii 0  ya TaaHoDI 1
                    dataArray:stockRequestProducts
                }
                $http.post('/services/sell/insert_Edit_StockRequest_details_DB',Args).then(
                    function xSuccess(response)
                    {
                        console.log(response.data);

                        getList_StockRequest(0);
                        toast_alert( Seved_Message,'success');
                        $('#Dimmer_page').dimmer('hide');
                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }
            }
        }
        //-------------


        //-------------
        $scope.edit_DB=function (mode)
        {

            if(stockRequestProducts.length) //the products in stock Request Array must be not null
            {
                currentPage=($scope.pagination.page);
                var Args={
                    type:'editRow',
                    formType:$scope.sr_type , // ghaTii = 0  ya TaaHoDI = 1
                    dataArray:stockRequestProducts
                }

                console.log(Args);
                $http.post('/services/sell/insert_Edit_StockRequest_details_DB',Args).then(
                    function xSuccess(response)
                    {

                        console.log(response.data);
                        getList_StockRequest(0,currentPage);
                        toast_alert( edited_Message,'success');
                        $('#Dimmer_page').dimmer('hide');
                    }),
                    function xError(response)
                    {
                        console.log(response.data);
                    }
            }
        }
        //--------------------
        $scope.fiald_mode=function(mode)
        {
            if (mode) // 3 filter
            {
                $scope.mode=1;
                $("#mode1").addClass("positive");
                $("#mode0").removeClass("positive");
                $scope.mode1_fiald=true;
                $scope.mode0_fiald=false;
                $scope.resultProduct=false;

                $scope.brandsID=[];


                $( ".brandsID .text.ng-binding" ).empty();
                $('.brandsID .item').removeClass('.active .selected');
                load_Brands();
                //--------Clear Fields--------------
                $scope.types=[];
                $scope.TypCatIDs=[];
                $scope.ProductID=[];
                $( ".partnumbers_id  .text.ng-binding" ).empty();
                $( ".ProductID .text.ng-binding" ).empty();
                $( ".TypCatID .text.ng-binding" ).empty();
                $( ".TypeID .text.ng-binding" ).empty();


            }
            else
            {
                $scope.mode=0;
                $("#mode0").addClass("positive");
                $("#mode1").removeClass("positive");
                $scope.mode0_fiald=true;
                $scope.mode1_fiald=false;
                $scope.resultProduct=false;
                //--------Clear Fields--------------
                $(".product_prtNum   .text.ng-binding" )   .empty();
                $(".TypeID    .text.ng-binding" )          .empty();
                $(".brandsID     .text.ng-binding" )       .empty();
                $scope.product_prtNum=null;
            }
        }
        //****** SUBROW handler**********
        $scope.fiald_modeB=function(mode)
        {
            if (mode) // 3 filter
            {
                $scope.mode=1;
                $("#modeB1").addClass("positive");
                $("#modeB0").removeClass("positive");
                $scope.modeB1_fiald=true;
                $scope.modeB0_fiald=false;
                $scope.resultProduct=false;
                load_Brands();


                //--------Clear Fields--------------
                $( ".partnumbers_id  .text.ng-binding" ).empty();
            }
            else
            {
                $scope.mode=0;
                $("#modeB0").addClass("positive");
                $("#modeB1").removeClass("positive");
                $scope.modeB0_fiald=true;
                $scope.modeB1_fiald=false;
                $scope.resultProduct=false;
                //--------Clear Fields--------------
                $(".product_prtNum   .text.ng-binding" )   .empty();
                $(".TypeID    .text.ng-binding" )          .empty();
                $(".brandsID     .text.ng-binding" )       .empty();
                $scope.product_prtNum=null;
            }
        }


        $scope.selectRow =function (productID,Totalqty,StockRequestID,StockRequestRowID)
        {

            $('i.fa.fa-close').addClass('hide');
            $('.closeSubRow'+StockRequestRowID).removeClass('hide');
            $scope.showspinner_Loading=true;
            $scope.showclose=productID;
            $scope.prnt_productID =productID;
            $scope.prnt_Totalqty =Totalqty;
            $scope.prnt_StockRequestID =StockRequestID;
            $scope.prnt_StockRequestRowID=StockRequestRowID;

            $scope.choicesx = [];
            $(".divTableRowB").removeClass("selectedRow");
            $(".subrow").removeClass("subrow_Show");
            //---------------------
            $("#DivRow"+StockRequestRowID).addClass("selectedRow");
            $("#DivRow"+StockRequestRowID+" .subrow").addClass("subrow_Show");

            // $("#DivRow"+StockRequestRowID).addClass("ActiveSubchassis");
            //---------------------
            $scope.ShowSerialInput=0;
            $scope.showSerialValue =[];
            //---------------------


            var Args={
                t:"xeeptprodusz",
                mode:0,
                key:"id",
                value:productID
            }
            $http.post('/Publicservices/relatedDatalist',Args).then
            (function xSuccess(response){
                data=response.data;
                if (data[0].stkr_prodct_two_serial)
                    $scope.haveTwoSerial=true;
                else
                    $scope.haveTwoSerial=false;
                $scope.showspinner_Loading=false;
                $scope.showspinner_LoadingSerials=true;
            }),
                function xError(response)
                {
                    console.log(response.data);
                }

//------Get Added Seriall Numbers ---------------
            $scope.addedSerials=[];
            var Args=
                {
                    mode:0,
                    StockRequestID:StockRequestID,
                    productID:productID,
                    RowID  :StockRequestRowID
                }

            $http.post('/services_sell/TakeOutProducts/getSerils',Args).then(
                function xSuccess(response)
                {
                    $scope.serialList=true;
                    $scope.addedSerials=response.data;
                    $scope.showspinner_LoadingSerials=false;

                }),
                function xError(response)
                {
                    $scope.serialList=false;
                }


//------Get INPUT ---------------

            var Args=
                { t:'xeeZTk0trdcPssz' ,
                    mode:0,
                    key:'sl_top_stockrequest_id',
                    value:StockRequestID,
                    // key2:'sl_top_productid',
                    // value2:productID,
                    key2:'sl_top_StockRequestRowID',
                    value2:StockRequestRowID
                }
            $http.post('/Publicservices/relatedDatalist2Fld',Args).then(
                function xSuccess(response)
                {
                    avaleQty= response.data.length;
                    qty=Totalqty-avaleQty;
                    // alert('Totalqty:'+Totalqty+' avaleQty: '+avaleQty + ' qty: '+qty);
                    if (qty==0) $scope.save_takeOut_Btn=false; else $scope.save_takeOut_Btn=true;
                    for (i=1;i<=qty;i++)
                    {

                        //var newItemNo = $scope.choicesx.length+1;

                        $scope.choicesx.push({'id':i-1});
                    }

                }),
                function xError(response)
                {
                    console.log(response.data);
                }

            //`````````````````````````````````````
            //Get Sub Chassis Parts
            var Args=
                {
                    RowID:StockRequestRowID,
                }
            $http.post('/services_sell/TakeOutProducts/GetSubChassisParts',Args).then(
                function xSuccess(response)
                {
                    // alert(response.data[0]['ssr_d_ParentChasis']);
                    console.log(response.data);
                    $scope.subChassisParts=response.data;
                }),
                function xError(response)
                {
                    console.log(response.data);
                }
            //`````````````````````````````````````

        }

        //-------------
        $scope.checkThisSerial=function (serial ,productID ,inputIndex)
        {
            serialA_value= $("#serialA"+productID+""+inputIndex).val();
            serialB_value= $("#serialB"+productID+""+inputIndex).val();
            c=0;
            for (i=0;i<=$scope.choicesx.length;i++)
            {
                if ($scope.choicesx[i])
                {
                    if (serialA_value == $scope.choicesx[i]['SerialA']  )
                        c++;
                }
            }

            if (serial==1)
            {
                var Args={
                    type:serial,
                    product_ID:productID ,
                    serialValue:serialA_value
                }
                $http.post('/services/sell/checkserial',Args).then(
                    function xSuccess(response)
                    {

                        $("#serialIcon"+productID+""+inputIndex).removeClass("fa fa-check fa-close greenx redx");
                        if (response.data==1 && c<=1)  $("#serialIcon"+productID+""+inputIndex).addClass("fa fa-check  greenx");
                        else                   $("#serialIcon"+productID+""+inputIndex).addClass("fa fa-close  redx");
                    }),
                    function xError(response)
                    {
                        console.log(response.data);
                    }
            }
            //----------------
            if (serial==2)
            {
                var Args={
                    type:serial,
                    product_ID:productID ,
                    serialValue:serialB_value,
                    serialValueA:serialA_value
                }
                $http.post('/services/sell/checkserial',Args).then(
                    function xSuccess(response)
                    {
                        $("#serialIconB"+productID+""+inputIndex).removeClass("fa fa-check fa-close greenx redx");
                        if (response.data==1)  $("#serialIconB"+productID+""+inputIndex).addClass("fa fa-check  greenx");
                        else                   $("#serialIconB"+productID+""+inputIndex).addClass("fa fa-close  redx");
                    }),
                    function xError(response)
                    {
                        console.log(response.data);
                    }
            }

        }
        ///////////////
        $scope.takeOutSerials=function (StockRequestID,productID,StockRequestRowID)
        {
            var newFormData={
                StockRequestRowID :StockRequestRowID ,
                StockRequest_id:StockRequestID,
                product_id:productID,
                SerialNumbers:$scope.choicesx,
            }


            $http.post('/services/sell/takeOutSerials',newFormData).then
            (function pSuccess(response)
            {
                if (response.data==1)
                {
                    toast_alert(Seved_Message,'success');
                    $(".divTableRowB").removeClass("selectedRow");
                    $(".subrow").removeClass("subrow_Show");
                }
                else
                {
                    toast_alert('Error ! ','danger');
                }

            }, function xError(response)
            {
                console.log(response.data);
                //console.log(error_message,'warning');
                $(".divTableRowB").removeClass("selectedRow");
                $(".subrow").removeClass("subrow_Show");
            });

        }

        $scope.showstatus=function()
        {
            $("#status25").html("subrow_Show");
        }

//---------------

        $scope.Check =function ()
        {
            //alert($(".search").text());


            alert( $('#partnumber_list').dropdown('get value '));
        }

//---------------
        $scope.checkEnterpressdB=function ($event,id)
        {
            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {
                newid=id+1;
                if ($scope.haveTwoSerial)
                {
                    $('.B'+id).trigger("focus");
                }
                else
                {
                    $('.A'+newid).trigger("focus");
                }
            }
        }
//---------------
        $scope.checkEnterpressdBinputs=function ($event,id)
        {
            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {
                newid=id+1;
                $('.A'+newid).trigger("focus");
            }
        }

//------------------------------------------------

        $scope.selectSubChassis=function(productid)
        {
            $(".singleRow").removeClass('active');
            $(".SubChassis"+productid).addClass("active");

        }
//------------------------------------------------
        $scope.ShowSerialToSubChassis=function (stockrequerstId,productId,StockRequestRowID)
        {
            //alert(stockrequerstId+' ' +productId +' ' + StockRequestRowID)
            $scope.showspinner=true;
            $scope.stockrequerstId=stockrequerstId;
            $scope.productId=productId;
            $scope.StockRequestRowID =StockRequestRowID;
            var Args={
                stockrequerst_Id:stockrequerstId ,
                product_Id:productId,
                StockRequestRow_ID:StockRequestRowID
            }

            $http.post('/services_sell/TakeOutProducts/Get_SerialToSubChassis',Args).then
            (function pSuccess(response)
            {
                console.log(response.data);
                $data=response.data;
                $scope.ShowSerialInput =$data[0];
                $scope.towSerial =$data[1];
                $scope.showSerialValue=$data[2];
                $scope.showspinner=false;
            }, function xError(response) {
                console.log(response.data);
            });
        }
//------------------------------------------------
        $scope.removeActiveSubchassis=function (StockRequestRowID) {

            $("#DivRow"+StockRequestRowID).removeClass("ActiveSubchassis");
            $(".divTableRowB").removeClass("selectedRow");
            $(".subrow").removeClass("subrow_Show");
            $('.closeSubRow'+StockRequestRowID).addClass('hide');
        }
//------------------------------------------------
        $scope.checkSubInputEnterpressdA=function ($event,index,StockRequestRowID) {

            // $scope.stockrequerstId
            // $scope.productId
            // $scope.StockRequestRowID

            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {
                if ($scope.towSerial==1) //Tow serial
                {
                    $('.inptB'+index).trigger("focus");
                }
                else
                {
                    ID=(StockRequestRowID+''+index);
                    value=($("#inptA"+ID).val());

                    //--------------------
                    var arg={
                        serial:1,
                        serialA:value,
                        serialB:null,
                        stockrequerstId :$scope.stockrequerstId,
                        parent_chassis_StockRequestRowID :StockRequestRowID ,
                        productId :$scope.productId ,
                        this_product_StockRequestRowID :$scope.StockRequestRowID
                    }

                    SubInputEnterpressdAction(index,arg);
                    // $http.post('/services_sell/TakeOutProducts/TakeASerial',arg).then
                    // (function pSuccess(response)
                    // {
                    //     console.log(response.data);
                    //     if (response.data==1)
                    //     {
                    //         $('.serialInputRow'+index).addClass('hide');
                    //         index++;
                    //         $('.inptA'+index).trigger("focus");
                    //         $scope.selectRow ($scope.prnt_productID,$scope.prnt_Totalqty,$scope.prnt_StockRequestID,$scope.prnt_StockRequestRowID);
                    //         $scope.ShowSerialToSubChassis($scope.stockrequerstId ,$scope.productId ,$scope.StockRequestRowID);
                    //         $scope.selectSubChassis ($scope.productId)
                    //     }
                    //     else
                    //         alert('سریال نامعتبر می باشد')
                    // }, function xError(response) {
                    //     console.log(response.data);
                    // });
                    // --------------------
                }
            }
        }
//------------------------------------------------
        $scope.checkSubInputEnterpressdB=function ($event,index,StockRequestRowID)
        {

            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {
                ID=(StockRequestRowID+''+index);
                valueA=($("#inptA"+ID).val());
                valueB=($("#inptB"+ID).val());


                //----------------------------------
                var arg={
                    serial:2,
                    serialA:valueA,
                    serialB:valueB,
                    stockrequerstId :$scope.stockrequerstId,
                    parent_chassis_StockRequestRowID :StockRequestRowID ,
                    productId :$scope.productId ,
                    this_product_StockRequestRowID :$scope.StockRequestRowID
                }
                //-----------------------------
                SubInputEnterpressdAction(index,arg);
            }
        }
//..............................................................
        function SubInputEnterpressdAction(index,arg)
        {

            $http.post('/services_sell/TakeOutProducts/TakeASerial',arg).then
            (function pSuccess(response)
            {
                console.log(response.data);
                if (response.data==1)
                {
                    $('.serialInputRow'+index).addClass('hide');
                    index++;
                    $('.inptA'+index).trigger("focus");
                    $scope.selectRow ($scope.prnt_productID,$scope.prnt_Totalqty,$scope.prnt_StockRequestID,$scope.prnt_StockRequestRowID);
                    $scope.ShowSerialToSubChassis($scope.stockrequerstId ,$scope.productId ,$scope.StockRequestRowID);
                    $scope.selectSubChassis ($scope.productId)
                }
                else
                    alert('سریال نامعتبر می باشد')
            }, function xError(response) {
                console.log(response.data);
            });
            $('.serialInputRow'+index).addClass('hide');
            index++;
            $('.inptA'+index).trigger("focus");
        }
//---------------------------------------------------

        $scope.deleteSubChassisSerialFromTakeOutProducts=function( StockRequestRowID,serialnumber_id ,productid,stockrequest_id)
        {
            var arg={
                StockRequestRow_ID :StockRequestRowID ,
                serialnumber_ID :serialnumber_id ,
                product_ID :productid,
                stockrequest_ID :stockrequest_id
            }
            $http.post('/services_sell/TakeOutProducts/deleteSubChassisSerial',arg).then
            (function pSuccess(response){
                $scope.selectRow(productid,2,stockrequest_id,StockRequestRowID)
                console.log(response.data)

            }, function xError(response) {
                console.log(response.data);
            });

        }

//---------------------------------------------
        $scope.showConvertStockRequestPage=function()
        {
            $('.section_new_edit').addClass('lowOpacity');
            SelectDimmer('convert_StockRequest');
            $('#Dimmer_page').dimmer('show');
            $scope.showLoadSpiner=true;
            StockRequestid=$scope.PublicStockRequestid;
            var arg={
                StockRequestid :StockRequestid
            }
            $http.post('/services_sell/Stockrequest/showConvertStockRequest',arg).then
            (function pSuccess(response){
                $scope.showLoadSpiner=false;
                $scope.PartsList=response.data;
                console.log(response.data);

            }, function xError(response) {
                console.log(response.data);
            });
        }
//---------------------------------------------
        $scope.ConvertStockRequest=function()
        {
            /*confirm ؟ */
            access=false;var r = confirm(message_convert_stockReq);if (r == true) {access=true;} else {access=false; }
            if (access)
            {
                StockRequestid=$scope.PublicStockRequestid;
                var arg={
                    StockRequestid :StockRequestid
                }
                $http.post('/services_sell/Stockrequest/convertStockRequest',arg).then
                (function pSuccess(response)
                {
                    if (response.data=='cantConvert')
                        toast_alert(errorConvertStockRequest ,'warning');

                    switch (response.data['convertType'])
                    {
                        case 1:
                            toast_alert(response.data['can']+message_canConvert+response.data['canNot']+message_canNOTConvert  ,'info');
                            break;
                        case 3:
                            toast_alert(message_convertSuccessfully ,'success');
                            break;
                    }


                    getList_StockRequest(0); //Refresh StockRequest List ...
                    $scope.closeConvertDimmer();
                    $scope.closeDimmer();
                    console.log(response.data);

                }, function xError(response) {
                    console.log(response.data);
                });
            }
        }

//---------------------------------------------
        $scope.closeConvertDimmer=function()
        {
            $('.section_new_edit').removeClass('lowOpacity');
            $scope.section_convert_stockrequerst_in_Dimmer=false;
        }
//---------------------------------------------
        $scope.testx=function () {

            alert($("#inptA1").html());
        }
//---------------------------------------------
        $scope.edit_StockRequest_field = function (field)
        {
            switch (field)
            {
                case 'preFaktorNum' :
                    $scope.showpreFaktorNum=true;
                    $scope.showCustommerList=false;
                    $scope.showDliverDate=false;
                    $scope.showRegistrdays=false;
                    break;
                case 'custmrList' :
                    $scope.showCustommerList=true;
                    $scope.showpreFaktorNum=false;
                    $scope.showDliverDate=false;
                    $scope.showRegistrdays=false;
                    //load_custommers();
                    break;
                case 'DliverDate' :
                    $scope.showDliverDate=true;
                    $scope.showCustommerList=false;
                    $scope.showpreFaktorNum=false;
                    $scope.showCustommerList=false;
                    $scope.showRegistrdays=false;
                    break;
                case 'Registrdays' :
                    $scope.showRegistrdays=true;
                    $scope.showCustommerList=false;
                    $scope.showDliverDate=false;
                    $scope.showCustommerList=false;
                    $scope.showpreFaktorNum=false;
                    $scope.showCustommerList=false;
                    break;

            }
        }
//---------------------------------------------
        $scope.update_StockRequest_field = function (field)
        {
            switch (field)
            {
                case 'preFaktorNum' :
                    //$scope.EditSelected($scope.PublicStockRequestid)
                    $scope.showpreFaktorNum=false;
                    value=$('#preFaktorNum').val();
                    break;

                case 'custmrList' :
                    $scope.showpreFaktorNum=false;
                    value=$('#CustommerID').val();
                    break;

                case 'DliverDate' :
                    days=  parseInt($('#Dliverdays').val());
                    Months=parseInt($('#DliverMonths').val());
                    years=parseInt($('#Dliveryears').val());
                    $scope.showpreFaktorNum=false;
                    Convalue=jalali_to_gregorian(years,Months,days);
                    value=Convalue[0]+'-'+Convalue[1]+'-'+Convalue[2];
                    break;

                case 'RegistrDate' :
                    days=  parseInt($('#Registrdays').val());
                    Months=parseInt($('#RegistrMonths').val());
                    years=parseInt($('#Registryears').val());
                    $scope.showpreFaktorNum=false;
                    Convalue=jalali_to_gregorian(years,Months,days);
                    value=Convalue[0]+'-'+Convalue[1]+'-'+Convalue[2];
                    break;

            }
            //...........................................
            var arg={
                $stockrequestID:$scope.PublicStockRequestid,
                field :field,
                value :value
            }

            $http.post('/services_sell/Stockrequest/editStackrequest_info',arg).then
            (function pSuccess(response){
                console.log(response.data)
                $scope.EditSelected($scope.PublicStockRequestid)
            }, function xError(response) {
                console.log(response.data)
            });
            //...........................................

        }
//---------------------------------------------
        $scope.ReloadData=function(echo_StockRequestID)
        {
            $('.refreshBtn i.fa.fa-refresh').addClass('fa-spin');
            $scope.EditSelected($scope.PublicStockRequestid);
        }
//---------------------------------------------
        $scope.pdf_config=function (invoice_id)
        {
            $scope.invoiceIDs=invoice_id;
            $scope.FormTitle=lbl_setting;
            SelectDimmer('section_pdfSetting');
            $('#Dimmer_page').dimmer('show');
//--------RESET---------------------
            $('.pdfPreview').removeClass('Aactive')   ;
            $scope.rtl=0;
            $scope.name=0;
            $scope.header_To_InvoiceBody="";
            $scope.signature_Table_height="";
            $scope.date_To_sellerInfo="";
            $scope.seller_To_InvoiceTable="";
            $scope.InvoiceTable_To_DescriptionTable="";
            $scope.stng_mainTableFontSize="";
            $scope.stng_Desc_fontSize="";

//----------------------------------
            var settingKeys = [
                "stng_customerName",
                "stng_changeDirection",
                "stng_header_To_InvoiceBody",
                "stng_date_To_sellerInfo",
                "stng_seller_To_InvoiceTable",
                "stng_InvoiceTable_To_DescriptionTable",
                "stng_signature_Table_height",
                "stng_mainTableFontSize",
                "stng_Desc_fontSize",
            ];
            //get setting data
            var arg={
                Action:'getPDFStings',
                invoiceIDs:$scope.invoiceIDs
            }
            $http.post('/services/sell/getPDFStings',arg).then
            (function pSuccess(response)
                {
                    data=response.data;
                    for(i=0;i<=data.length-1 ;i++)
                    {
                        for(j=0;j<=settingKeys.length-1 ;j++)
                        {
                            if (data[i][settingKeys[j]])
                            {
                                switch (settingKeys[j])
                                {
                                    case 'stng_customerName':
                                        $scope.name=1;
                                        break;
                                    case 'stng_changeDirection':
                                        $scope.rtl=1;
                                        break;
                                    case 'stng_header_To_InvoiceBody':
                                        $scope.header_To_InvoiceBody=data[i][settingKeys[j]];
                                        break;

                                    case 'stng_date_To_sellerInfo':
                                        $scope.date_To_sellerInfo=data[i][settingKeys[j]];
                                        break;
                                    case 'stng_seller_To_InvoiceTable':
                                        $scope.seller_To_InvoiceTable=data[i][settingKeys[j]];
                                        break;
                                    case 'stng_InvoiceTable_To_DescriptionTable':
                                        $scope.InvoiceTable_To_DescriptionTable=data[i][settingKeys[j]];
                                        break;

                                    case 'stng_signature_Table_height':
                                        $scope.signature_Table_height=data[i][settingKeys[j]];
                                        break;

                                    case 'stng_mainTableFontSize':
                                        $scope.stng_mainTableFontSize=data[i][settingKeys[j]];
                                        break;
                                    case 'stng_Desc_fontSize':
                                        $scope.stng_Desc_fontSize=data[i][settingKeys[j]];
                                        break;



                                }
                            }
                        }
                    }

                    //  if ($scope.signature_Table_height) $scope.showLabel_signature_Table_height=true
                },
                function xError(response) {
                });

        }
//---------------------------------------------
        $scope.setActive=function(action)
        {
            $('.pdfPreview').removeClass('Aactive')   ;

            switch (action)
            {
                case 'stng_header_To_InvoiceBody':
                    $('.pdfPreview.p_1').addClass('Aactive')   ;
                    break;
                case 'stng_date_To_sellerInfo':
                    $('.pdfPreview.p_2').addClass('Aactive')   ;
                    break;
                case 'stng_seller_To_InvoiceTable':
                    $('.pdfPreview.p_3').addClass('Aactive')   ;
                    break;
                case 'stng_InvoiceTable_To_DescriptionTable':
                    $('.pdfPreview.p_4').addClass('Aactive')   ;
                    break;


            }
        }

//----------------------------------------------
        $scope.allSettingSave=function()
        {
            $scope.setPDFStingAction ('stng_header_To_InvoiceBody','value');
            $scope.setPDFStingAction ('stng_date_To_sellerInfo','value');
            $scope.setPDFStingAction ('stng_seller_To_InvoiceTable','value');
            $scope.setPDFStingAction ('stng_InvoiceTable_To_DescriptionTable','value');
            $scope.setPDFStingAction ('stng_signature_Table_height','value');
            $scope.setPDFStingAction ('stng_mainTableFontSize','value');
            $scope.setPDFStingAction ('stng_Desc_fontSize','value');
            $scope.closepdfSetting();

        }
//----------------------------------------------
        $scope.setPDFStingAction=function (action,value) {

            if (value=='value')
            {
                switch (action)
                {
                    case 'stng_header_To_InvoiceBody':
                        value=$scope.header_To_InvoiceBody;
                        break;
                    case 'stng_date_To_sellerInfo':
                        value=$scope.date_To_sellerInfo;
                        break;
                    case 'stng_seller_To_InvoiceTable':
                        value=$scope.seller_To_InvoiceTable;
                        break;
                    case 'stng_InvoiceTable_To_DescriptionTable':
                        value=$scope.InvoiceTable_To_DescriptionTable;
                        break;
                    case 'stng_signature_Table_height':
                        value=$scope.signature_Table_height;
                        break;

                    case 'stng_mainTableFontSize':
                        value=$scope.stng_mainTableFontSize;
                        break;
                    case 'stng_Desc_fontSize':
                        value=$scope.stng_Desc_fontSize;
                        break;
                }

            }
//----------------------------------------------
            var arg={
                Action:'setPDFStingAction',
                task:action ,
                value:value,
                invoiceIDs:$scope.invoiceIDs
            }
            $http.post('/services/sell/setPDFStingAction',arg).then
            (function pSuccess(response){
                console.log(response.data);
                toast_alert(Seved_Message,'success')
            }, function xError(response) {
            });

            // $scope.rtl=1;
        }

//*********************************
        $scope.closepdfSetting=function () {
            $('#Dimmer_page').dimmer('hide');
        }

//*********************************
        $scope.SearchInvoice=function () {
            SelectDimmer('section_searchInvoice');
            $('#Dimmer_page').dimmer('show');
            $scope.FormTitle="جستجوی پیشرفته در محتوای پیش فاکتورها";
        }
//*********************************
        $scope.searchInvoice=function () {
            var args= {
                Action:"SearchInvoice",
                SearchForKey:$scope.SearchFor
            };
            $http.post('/services/sell/SearchInvoice',args).then
            (function xSuccess(response) {
                if (response.data.length)
                {
                    $scope.SreachResalt=response.data;
                    $scope.Noresult=false;
                }

                else
                {
                    $scope.SreachResalt=[];
                    $scope.Noresult=true;
                }

                console.log(response.data)
            }), function xError(response)
            {}
        }
//*********************************
        $scope.StkReqPDFSetting=function (id) {
            $scope.thisSelectedStockrequestID=id;
            $scope.stng_mainTableFontSize    ="";
            $scope.stng_SerialNumberFontSize ="";
            var args= {
                StkReqID:  id
            };
            $http.post('/services_sell/Stockrequest/getPdfSettingValue',args).then
            (function xSuccess(response) {
                arrayx=response.data;
                $scope.stng_mainTableFontSize    =arrayx.mainTableFontSize;
                $scope.stng_SerialNumberFontSize =arrayx.SerialNumberFontSize;
            }), function xError(response)
            {}
            SelectDimmer('section_pdf_Setting_dimmer');
            $('#Dimmer_page').dimmer('show');
        }
//*********************************
        $scope.stackReqstPDFSettingSave =function ()
        {
            stID=($scope.thisSelectedStockrequestID);
            mainTableFontSize=$scope.stng_mainTableFontSize;
            SerialNumberFontSize=$scope.stng_SerialNumberFontSize;
            var args= {
                mainTableFontSize:$scope.stng_mainTableFontSize,
                SerialNumberFontSize:$scope.stng_SerialNumberFontSize
            };

            $http.post('/services_sell/Stockrequest/pdfSetting/'+stID,args).then
            (function xSuccess(response) {
                $('#Dimmer_page').dimmer('hide');
                toast_alert('saved','success');
            }), function xError(response)
            {}


        }

//*********************************




    }]);
