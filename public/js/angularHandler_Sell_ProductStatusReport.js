

var app = angular.module('Sell_ProductStatusReport_App', ['simplePagination' ,'psi.sortable']  );

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

/*  On Start up
   -> All_invoice_Date(0,0);
*/
/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
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
//------------
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
app.filter('pTypeCat', function() {
    return function(rypecatid) {
        return  PublicF_AppFilter_pTypeCat(rypecatid);
    };
});

/*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
app.controller('Sell_ProductStatusReport_Ctrl', ['$scope','$http','Pagination','$filter','$sce',
    function($scope, $http,Pagination,$filter,$sce )
    {
        var stockRequestProducts = [];
        var listArray=[];
        var sritems = [];
        var invoice_detilas=[];
        totalEPL=0;

//---------------###############################---------------
        //@@@ Product Status Report @@@
//---------------###############################---------------

        function get_StatusReport_list (mode)
        {
            $scope.list_mode=mode.toString();
            $(".MainLoading").addClass("show");
            // $http({
            //         method:"GET",
            //         url:"/services/sell/getAllStatusReport"
            //      })
            var args= {qmode:mode};
            $http.post('/services/sell/getAllStatusReport',args)
                .then (function getsuccess(response)
                    {
                        $scope.allRows=response.data;
                        $scope.pagination = Pagination.getNew(10000);
                        $scope.pagination.numPages = Math.ceil($scope.allRows.length/$scope.pagination.perPage);
                        $(".MainLoading").removeClass("show");
                    },function  getErorr(response)
                    {
                        if(response.data['message']=="Unauthenticated.")
                            window.location.href = "/login";
                    }
                );
        }
        get_StatusReport_list (0);
        pushtoFilters();

        //----------------
        $scope.change_list_mode=function()
        {
            mode=$scope.list_mode;
            get_StatusReport_list (mode);
        }
        //--------------------
        function pushtoFilters()
        {
            var args= {qmode:"GetBrands"};
            $http.post('/services/sell/getBrandSTypeSTitles',args).then
            (function xSuccess(response)
            {
                $scope.product_Brands=response.data;
            }), function xError(response)
            {
                toast_alert(response.data,'danger');
            }

            $scope.product_Type_Cat = [
                {id: '', name: 'همه دسته بندی کالا'},
                {id: '1', name: 'قطعه'},
                {id: '2', name: 'قطعه منفصله'},
                {id: '3', name: 'شاسی'}
            ];
        }

        $scope.getRelatedType=function( )
        {
            $scope.resultProduct=false;
            $(".TypeID").addClass("loading");
            $( ".TypeID  .text.ng-binding" ).empty();
            $( ".product_prtNum  .text.ng-binding" ).empty();
            //alert($scope.brandsID);
           // BrandName=$scope.search.prodct_Brand;
            BrandName=$scope.brandsID;
            var arg={qmode:"GetTyps",brandName:BrandName};
            $http.post('/services/sell/getBrandSTypeSTitles',arg).then
            (function xSuccess(response) {
                typesData=response.data;
                console.log(response.data)
                $scope.product_Type=typesData;
                $(".TypeID").removeClass("loading");
            }),function xError(response)
            {

            }
        }
        //----------------------
        $scope.getRelatedProducts_ByType=function (q) {
            $(".product_prtNum  .text.ng-binding" ).empty();
            $(".product_prtNum ").addClass("loading");
            $scope.products="";
            var Args={
                brandName:$scope.brandsID,
                TypeName:$scope.TypeID,
            }
            console.log(Args);
            $http.post('/services/SellController/getProductName',Args).then
            (function xSuccess(response){
                $(".product_prtNum ").removeClass("loading");
                console.log(response.data);
                data=response.data;
                $scope.products=response.data;

            }), function xError(response)
            {
                //toast_alert(response.data,'danger');
            }

        }

//---------------###############################---------------
        //@@@ INVOICE @@@
//---------------###############################---------------
        $scope.expressionx=function()
        {
            if ($scope.Unit_price!=null)
            {
                BaseValue=$scope.Unit_price;
                leftcleanedValue="";
                //-----------
                var  Value = BaseValue.split(".");
                leftVal=Value[0];
                RightVal=Value[1];
                //--------------------------
                if (Value.length>=2)
                {
                    $scope.Unit_price=leftVal+'.'+RightVal
                }
                else
                {
                    Alength=leftVal.length;
                    for(i=0;i<=Alength-1;i++)
                    {
                        if (leftVal[i] !=',')
                        {
                            leftcleanedValue=leftcleanedValue+leftVal[i];
                        }
                    }
                    //-------------
                    leftVal_len=leftcleanedValue.length-1;
                    j=0;res="";
                    for(i=leftVal_len;i>=0;i--)
                    {
                        j++;
                        if (j%3!=0)
                        {
                            res=leftcleanedValue[i]+res;
                        }
                        else
                        {
                            if (i!=0) res=","+leftcleanedValue[i]+res;
                            else res=leftcleanedValue[i]+res;
                        }
                    }
                    $scope.Unit_price=res;
                }
            }
        }

//----------------------------
        $scope.addDotToPrice=function(index)
        {

          value= $("#inputID"+index).val();
          console.log(value);
            if (value!=null)
            {
                BaseValue=value;
                leftcleanedValue="";
                //-----------
                var  Value = BaseValue.split(".");
                leftVal=Value[0];
                RightVal=Value[1];
                //--------------------------
                if (Value.length>=2)
                {
                    $scope.Unit_price=leftVal+'.'+RightVal
                }
                else
                {
                    Alength=leftVal.length;
                    for(i=0;i<=Alength-1;i++)
                    {
                        if (leftVal[i] !=',')
                        {
                            leftcleanedValue=leftcleanedValue+leftVal[i];
                        }
                    }
                    //-------------
                    leftVal_len=leftcleanedValue.length-1;
                    j=0;res="";
                    for(i=leftVal_len;i>=0;i--)
                    {
                        j++;
                        if (j%3!=0)
                        {
                            res=leftcleanedValue[i]+res;
                        }
                        else
                        {
                            if (i!=0) res=","+leftcleanedValue[i]+res;
                            else res=leftcleanedValue[i]+res;
                        }
                    }
                    $("#inputID"+index).val(res);
                }
            }
        }
//----------------------------

        function All_invoice_Date(mode,currentPage)
        {

            var args= {Action:"All_invoice" ,mode:mode};
            $http.post('/services/sell/get_all_invoice',args).then
            (function xSuccess(response)
            {
                $scope.confirmed=0;
                $scope.all_Invoice_rows=response.data;
                $scope.pagination = Pagination.getNew(30);
                $scope.pagination.numPages = Math.ceil($scope.all_Invoice_rows.length/$scope.pagination.perPage);
                if (currentPage !='') $scope.pagination.page=currentPage;

                if (mode)
                {
                    $('#ShowTrashed').addClass('active');
                    $('#ShowAll').removeClass('active');
                    $scope.SubToolBar_inTrashlist=true;
                    $scope.BtnRestoreProducts=true;
                    $scope.BtnFullDeleteProducts =true;
                    $scope.SubToolBar_inAllDatalist=false;
                    $scope.btn_move_trash =false;
                }
                else
                {
                    $('#ShowAll').addClass('active');
                    $('#ShowTrashed').removeClass('active');
                    $scope.SubToolBar_inAllDatalist=true;
                    $scope.SubToolBar_inTrashlist=false;
                    $scope.BtnRestoreProducts=false;
                    $scope.btn_move_trash =true;
                    $scope.BtnFullDeleteProducts =false;
                }
                $scope.waitForInvoiceList=true;
            }), function xError(response)
            {}
        }
        All_invoice_Date(0,0);
//------------------------------------
        $scope.closeInvoice=function ()
        {
            currentPage=($scope.pagination.page);
            $('#Dimmer_page').dimmer('hide');
            // All_invoice_Date(0,currentPage);
        }

        //!!!!!! SUB ACTION MENU !!!!!!!
        $scope.showAll=function (mode)
        {
            if (mode==1)
            {
                $('#ShowTrashed').addClass('active');
                $('#ShowAll').removeClass('active');

            }
            else
            {
                $('#ShowAll').addClass('active');
                $('#ShowTrashed').removeClass('active');

            }


            All_invoice_Date (mode);
        }
        //```````````````````````````
        $scope.RestoreFromTrash=function()
        {
            alert('RestoreFromTrash')
        }
        //```````````````````````````
        $scope.DeleteFromDataBase=function()
        {
            alert('DeleteFromDataBase');
        }


        //iiiiiiiiiiiiiiiiiii
        //......................


        $scope.add_new_invoice=function()
        {
            $scope.FormTitle=lbl_new_invoice;
            SelectDimmer('new_invoice');
            $('#Dimmer_page').dimmer('show');
            $("#mode0").addClass("positive");
            $("#mode1").removeClass("positive");
            $scope.mode0_fiald=true;
            $scope.mode1_fiald=false;
            $scope.NewinvoiceRow=true;
            $scope.edit_form_control=false;

            $scope.invoiceDetials('Set_newform','none','none');

            GenerateInvoiceAlias_ID();
            Load_curency();
            load_custommers();
            load_PartNumbers();
            load_Brands();

            //hide Rows
            $scope.NewinvoiceRow=true;
            $scope.show_invoiceRow=false;
            $scope.selectProductx=false;
            $scope.resultProduct=false;
            $scope.productTabel=false;
            sritems=[];

        }

        //................................
        function GenerateInvoiceAlias_ID()
        {
            var args= {Action:"InvoiceAliasID"};
            $http.post('/services/sell/GenerateInvoiceAliasID',args).then
            (function xSuccess(response)
            {
                $scope.invoiceAlias=response.data;
                return response.data;
            }), function xError(response)
            {}
        }

        //.................................
        function Load_curency()
        {
            var args= {Action:"All_curency"};
            $http.post('/services/sell/get_all_invoice_curency',args).then
            (function xSuccess(response)
            {
                // console.log(response.data);
                $scope.allcurrency=response.data;
            }), function xError(response)
            {}
        }
        //..................................
        function load_custommers()
        {
            var args= {Action:"All_Custommer"};
            $http.post('/services/sell/get_all_invoice_Custommers',args).then
            (function xSuccess(response)
            {
                // $scope.myHTML =$sce.trustAsHtml(response.data);
                // <p ng-bind-html="myHTML" compile-template></p>
              //  $scope.allCustommers=response.data;
            }), function xError(response)
            {}
        }

        //..................................
        function load_PartNumbers()
        {
            var args= {Action:"All_PartNumbers"};
            $http.post('/services/sell/get_all_PartNumbers',args).then
            (function xSuccess(response)
            {
                $scope.product_QTY=1;
                $scope.partnumbers=response.data;
            }), function xError(response)
            {}
        }

        //..................................
        function load_Brands()
        {
            var args= {Action:"All_Brands"};
            $http.post('/services/sell/get_all_Brands',args).then
            (function xSuccess(response)
            {
                $scope.brands=response.data;
            }), function xError(response)
            {}
        }

        //.............................
        $scope.getRelatedType_INV=function ()
        {
            $( ".TypeID  .text.ng-binding" ).empty();
            $( ".product_prtNum  .text.ng-binding" ).empty();

            $(".TypeID").addClass("loading");
            var args= {Action:"All_Product_Types",BrandID:$scope.brandsID};
            $http.post('/services/sell/all_Product_Types',args).then
            (function xSuccess(response)
            {
                $scope.Products=[];
                $( ".ProductID .text.ng-binding" ).empty();
                $( ".TypCatID .text.ng-binding" ).empty();

                $scope.types=response.data;
                $(".TypeID").removeClass("loading");
            }), function xError(response)
            {}
        }

//-------------------------------------
        $scope.invoiceDetials =function(mode,task,oldVal)
        {
            if (mode=="Set_newform")
            {
                invoice_detilas=[]; //Reset Array
                $scope.warrantyBTN=true;
                $scope.PaymentBTN =true;
                $scope.DiscountBTN=true;
                $scope.deliveryDateBTN=true;
                $scope.DescriptionBTN=true;

                $scope.warrantyValue =false;
                $scope.PaymentValue=false;
                $scope.deliveryDateValue=false;
                $scope.DescriptionValue=false;
                $scope.DiscountValue=false;

                $scope.echo_TotalQty ="";
                $scope.echo_TotalPrice="";
                $scope.echo_Total_EPL_price="";
                $scope.echo_tax_price="";
                $scope.echo_Total_factor_price="";
                $scope.echo_invoice_delivery_Type="";

            }

            if (mode=='Set_editform')
            {
                $scope.warrantyBTN=false;
                $scope.PaymentBTN =false;
                $scope.DiscountBTN=false;
                $scope.deliveryDateBTN=false;
                $scope.DescriptionBTN=false;
                $scope.warrantyValue =false;
                $scope.PaymentValue=false;
                $scope.deliveryDateValue=false;
                $scope.DescriptionValue=false;
                $scope.DiscountValue=false;
            }

            promptMessage="";
            switch (task)
            {
                case 'warranty':
                    if (mode=='editbtn')
                    {
                        $scope.warranty_show=false;
                        $scope.warranty_edit =true;
                    }
                    else if (mode=='Savebtn')
                    {
                        value=$('#warranty_val').val();
                        update_invoice_description(task,value);
                        $scope.Show_Selected_invoice($scope.echo_invoicesID);

                    }
                    break;
                //---------------
                case 'Payment':
                    if (mode=='editbtn')
                    {
                        $scope.Payment_show=false;
                        $scope.Payment_edit =true;
                    }
                    else if (mode=='Savebtn')
                    {
                        value=$('#Payment_val').val();
                        update_invoice_description(task,value);
                        $scope.Show_Selected_invoice($scope.echo_invoicesID);
                    }
                    break;
                case 'Discount':
                    promptMessage="تخفیف ";
                    //---------------
                    get_prompt_value=do_invoice_action(task,promptMessage,oldVal);
                    $scope.echo_Discount=get_prompt_value;
                    //---------------
                    if ( $scope.echo_Discount !=null &&   $scope.echo_Discount !="")
                    {
                        $scope.DiscountBTN =false;
                        $scope.DiscountValue =true;
                    }
                    //---------------
                    if (mode=="editbtn" || mode=="newbtn")
                    {if (get_prompt_value !=oldVal) update_invoice_description(task,get_prompt_value);}

                    break;


                case 'deliveryDate':
                    if (mode=='editbtn')
                    {
                        $scope.deliveryDate_show=false;
                        $scope.deliveryDate_edit =true;
                    }
                    else if (mode=='Savebtn')
                    {
                        value=$('#deliveryDate_val').val();
                        update_invoice_description(task,value);
                        $scope.Show_Selected_invoice($scope.echo_invoicesID);
                    }
                    break;


                    case 'invoice_delivery_Type':
                    if (mode=='editbtn')
                    {
                        $scope.invoice_delivery_Type_show=false;
                        $scope.invoice_delivery_Type_edit =true;
                    }
                    else if (mode=='Savebtn')
                    {
                        value=$('#invoice_delivery_Type_Val').val();
                        update_invoice_description(task,value);
                        $scope.Show_Selected_invoice($scope.echo_invoicesID);
                    }
                    break;


                case 'validityDuration':
                    if (mode=='editbtn')
                    {
                        $scope.validityDuration_show=false;
                        $scope.validityDuration_edit =true;
                    }
                    else if (mode=='Savebtn')
                    {
                        value=$('#validityDuration_Val').val();
                        update_invoice_description(task,value);
                        $scope.Show_Selected_invoice($scope.echo_invoicesID);
                    }
                    break;





                case 'Description':
                    promptMessage="توضیحات ";
                    //---------------
                    get_prompt_value=do_invoice_action(task,promptMessage,oldVal);
                    $scope.echo_Description=get_prompt_value;
                    //---------------
                    if ( $scope.echo_Description !=null &&  $scope.echo_Description !="")
                    {
                        $scope.DescriptionBTN =false;
                        $scope.DescriptionValue =true;
                    }
                    //---------------
                    if (mode=="editbtn" || mode=="newbtn")
                    {if (get_prompt_value !=oldVal) update_invoice_description(task,get_prompt_value);}
                    break;
            }
        }

//----------------------
        function update_invoice_description(task,newValue)
        {
            var Args={
                Action:"update_invoice_description",
                invoicesID:$scope.echo_invoicesID,
                task:task,
                NewValue:newValue
            }
            routelink='/services/sell/update_invoice_description';
            $http.post(routelink,Args).then(
                function xSuccess(response)
                {
                    console.log(response.data);
                    $scope.EditInvoiceLIST(1);
                    $scope.Show_Selected_invoice($scope.echo_invoicesID);

                }),
                function xError(response)
                {
                    console.log(response.data);
                }
        }

        //@@@@@@@@@@@@@@@
        function do_invoice_action (task,promptMessage,oldVal)
        {
            promptMessage='" '+promptMessage+' "' +' را وارد نمایید ';
            //...............
            if (oldVal !='')
                var recived_value = prompt(promptMessage,oldVal);
            else
                var recived_value = prompt(promptMessage,'');
            //...............
            if (recived_value != null || recived_value != "")
            {
                if ($scope.formStatus=="new")
                {
                    invoice_detilas.push({
                        key:task,
                        value :recived_value
                    });
                    return recived_value;
                }
                else if ($scope.formStatus=="edit")
                {
                    if (recived_value != null)
                    {
                        return recived_value;
                    }

                }
            }

            //...............

        }

        //..................................
        $scope.getRelated_CAT_Type=function ()
        {
            $(".TypCatID").addClass("loading");
            //Empty Fields.........
            $scope.resultProduct=false;
            $scope.Products=[];
            $( ".ProductID .text.ng-binding" ).empty();
            $( ".TypCatID .text.ng-binding" ).empty();
            //......................
            typcats=[];
            typcats.push({
                "id" :1,
                "type_cat_title" :  'قطعه',
            });
            typcats.push({
                "id" :2,
                "type_cat_title" :  'قطعه منفصله',
            });
            typcats.push({
                "id" :3,
                "type_cat_title" : 'شاسی',
            });
            $scope.TypCatIDs= typcats;
            $(".TypCatID").removeClass("loading");

        }
        //..................................
        $scope.getRelatedProducts=function ()
        {
            var args= {
                Action:"All_Related_Products",
                BrandID:$scope.brandsID ,
                TypeID:$scope.TypeID ,
                TypCatID:$scope.TypCatID
            };
            $(".ProductID").addClass("loading");
            $http.post('/services/sell/all_Related_Product',args).then
            (function xSuccess(response) {
                $scope.Products=response.data;
                $(".ProductID").removeClass("loading");
            }), function xError(response)
            {}
        }
        //..................................


        //..................................
        $scope.getProductData=function ()
        {

            var args= {
                Action:"select_product_by_partNum",
                Product_id:$scope.ProductID
            };
            $http.post('/services/sell/select_product_by_partNum',args).then
            (function xSuccess(response) {
                Rdata=response.data[0];
                $scope.echo_prodct_type_cat =Rdata['TypeCat'];
                 $scope.echo_Brand=Rdata['brand'];
                 $scope.echo_Type= Rdata['type'];
                 $scope.echo_ProductTitle= Rdata['prodct_title'];
                $scope.echo_EPLPrice=Rdata['price'];
                reset();
            }), function xError(response)
            {}

            // var args= {
            //     Action:"select_product_by_partNum",
            //     Product_id:$scope.partnumbers_id
            // };

            //
            //
            //
            //
            //
            //
            //
            //
            // $scope.echo_prodct_type_cat = $("#TypCatID option:selected").text();
            // $scope.echo_Brand=$("#brandsID option:selected").text();
            // $scope.echo_Type= $("#TypeID option:selected").text();
            // $scope.echo_ProductTitle=$("#ProductID option:selected").text();
            // reset();
        }


        // $scope.selectProductByPartNum=function ()
        // {
        //
        //     var args= {
        //         Action:"select_product_by_partNum",
        //         Product_id:$scope.partnumbers_id
        //     };
        //     $http.post('/services/sell/select_product_by_partNum',args).then
        //     (function xSuccess(response) {
        //         Rdata=response.data[0];
        //         $scope.echo_Brand=Rdata['brand'];
        //         $scope.echo_Type=Rdata['type'];
        //         $scope.echo_ProductTitle=Rdata['prodct_title'];
        //         $scope.echo_EPLPrice=Rdata['price'];
        //         //$scope.echo_prodct_type_cat=Rdata['TypeCat'];
        //         reset();
        //     }), function xError(response)
        //     {}
        // }
//--
        $("#partnumber_list").change(function() {
            partnumbers_id=$("#partnumber_list").val();
            var args= {
                        Action:"select_product_by_partNum",
                        Product_id:partnumbers_id
                    };

            $http.post('/services/sell/select_product_by_partNum',args).then
                (function xSuccess(response) {
                    Rdata=response.data[0];
                    $scope.echo_Brand=Rdata['brand'];
                    $scope.echo_Type=Rdata['type'];
                    $scope.echo_ProductTitle=Rdata['prodct_title'];
                    $scope.echo_EPLPrice=Rdata['price'];
                    //$scope.echo_prodct_type_cat=Rdata['TypeCat'];
                    reset();
                }), function xError(response)
                {}
        });



        $("#selectProductByPartNum_SubProductB").change(function () {

            selectAproduct();
        })

        $("#selectProductByPartNum_SubProduct").change(function() {

            selectAproduct();
        });

        function selectAproduct () {

            if ($scope.mode==1)
                productIDx=$("#selectProductByPartNum_SubProductB").val();
            else
                productIDx=$("#selectProductByPartNum_SubProduct").val();


            var args= {
                Action:"select_product_by_partNum",
                Product_id:productIDx
            };

            console.log(args);

            $http.post('/services/sell/select_product_by_partNum',args).then
            (function xSuccess(response) {
                $scope.product_details=true;
                Rdata=response.data[0];
                $scope.echo_Brand_B=Rdata['brand'];
                $scope.echo_Type_B=Rdata['type'];
                $scope.echo_ProductTitle_B=Rdata['prodct_title'];
                $scope.echo_EPLPrice_B=Rdata['price'];
                //$scope.echo_prodct_type_cat=Rdata['TypeCat'];
                // reset();
                console.log(response.date);
            }), function xError(response)
            {}
        }

        //-0-------------------------------

        // $scope.selectProductByPartNum_SubProduct=function ()
        // {
        //     if ($scope.mode==1)
        //         productIDx=$scope.ProductID;
        //     else
        //         productIDx=$scope.partnumbers_id;
        //
        //     var args= {
        //         Action:"select_product_by_partNum",
        //         Product_id:productIDx
        //     };
        //     $http.post('/services/sell/select_product_by_partNum',args).then
        //     (function xSuccess(response) {
        //         $scope.product_details=true;
        //         Rdata=response.data[0];
        //         $scope.echo_Brand_B=Rdata['brand'];
        //         $scope.echo_Type_B=Rdata['type'];
        //         $scope.echo_ProductTitle_B=Rdata['prodct_title'];
        //         $scope.echo_EPLPrice_B=Rdata['price'];
        //         //$scope.echo_prodct_type_cat=Rdata['TypeCat'];
        //         // reset();
        //     }), function xError(response)
        //     {}
        // }
//-0-------------------------------

        //
        function reset()
        {
            $scope.resultProduct=true;
            $scope.Unit_price=null;
            $scope.product_QTY=1;
        }
        //----------------

        $scope.add_product_to_invoice_array=function()
        {
            if($scope.Unit_price == undefined || $scope.Unit_price == null)
                toast_alert(error_price_is_requierd,'danger');
            else
            {
//!!!!!!!!!!!!!!!!Check 4 duplicat !!!!!!!!!!!!!!!!!!!

                if ($scope.mode==1) //by product filter
                    target_id=$scope.ProductID;
                else //By PartNumber
                    target_id=$('#partnumber_list').val();
                i=0;result=0;

                // sritems.forEach(doAction);
                // function doAction()
                // {
                //     console.log(sritems[i].product_id);
                //    if (sritems[i].product_id == target_id)
                //     {result++; }
                //      i++;
                //  }
                //
                // if (result >=1)
                // {
                //     falg=false;
                //     toast_alert(error_duplicated_p_message,'danger');
                // }
                // else {
                //     falg=true;
                // }

                falg=true;

//!!!!!!!!!!!!!!!!Check 4 duplicat !!!!!!!!!!!!!!!!!!!
                if (falg)
                {
                    //---------------------------------------------
                    var sritems =
                        {
                            invoice_id:$scope.echo_invoicesID,
                            product_id:target_id,
                            qty:$scope.product_QTY  ,
                            Unit_price : RemoveCama( $scope.Unit_price),
                            EPL_price :  checkEplValu($scope.echo_EPLPrice)
                        }

                    var Args= {
                        Action:"Edit_Invoice",
                        desc:$scope.Description_input,
                        ProductArray :sritems
                    };

                    $scope.waitForList=true;
                    $http.post('/services/sell/Edit_Invoice',Args).then(
                        function xSuccess(response)
                        {
                            if (response.data=='Saved')
                            {
                                $scope.Show_Selected_invoice($scope.echo_invoicesID);
                                $scope.fiald_mode(0);
                                $scope.waitForList=false;
                            }
                            else if (response.data=='duplicated')
                            {
                                toast_alert(message_duplicated,'warning');
                                $scope.waitForList=false;
                            }
                            else
                                toast_alert(error_message,'danger');
                        }),
                        function xError(response)
                        {
                            toast_alert(response.data,'warning');
                        }


                    // $http.post('/services/sell/addSubProductTo_Invoice',args).then
                    // (function xSuccess(response) {
                    //     get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);
                    //     $scope.product_details=false;
                    // }), function xError(response)
                    // {}

                    //---------------------------------------------

                    //     if ($scope.formStatus=='new')
                    //     {
                    //         $scope.new_form_control=true;
                    //         $scope.edit_form_control=false;
                    //     }
                    //
                    //     part_numb=$("#partnumber_list option:selected").text();
                    //     partNumb=part_numb.replace(/\s/g, '');
                    //     sritems.push({
                    //         "rowID" :sritems.length,
                    //         "invoice_id":$scope.echo_invoicesID,
                    //         "product_id" : target_id,
                    //         "partNumber" :partNumb ,
                    //         "product_typeCat" : $scope.echo_prodct_type_cat,
                    //         "product_brand" : $scope.echo_Brand,
                    //         "product_Type" : $scope.echo_Type,
                    //         "product_Title" : $scope.echo_ProductTitle,
                    //         "qty" : $scope.product_QTY,
                    //         "Unit_price" : RemoveCama( $scope.Unit_price),
                    //         "TotalPrice" :RemoveCama( $scope.Unit_price)*$scope.product_QTY,
                    //          "EPL_price" :  checkEplValu($scope.echo_EPLPrice),
                    //        "Total_EPL_price" : checkEplValu($scope.echo_EPLPrice)*$scope.product_QTY,
                    //         "new" :"*"
                    //     });
                    //
                    //     $scope.addedRows=  sritems;
                    //     totalEPL=totalEPL+( checkEplValu($scope.echo_EPLPrice)*$scope.product_QTY);
                    //     $scope.echo_Total_EPL_price=totalEPL;
                    //
                    //     $scope.productTabel=true;
                    //     $scope.resultProduct=false;
                    //     $( ".partnumbers_id  .text.ng-binding" ).empty();
                    //
                    //     $scope.EditInvoiceLIST(1);
                    //
                    //     if ($scope.formStatus=='new')
                    //     {
                    //         $scope.addInvoiceDetailsTo_DB(1) ;
                    //     }
                }
            }

        }
//------------------------------------------------
        $scope.setTaxStatus=function()
        {
            var args= {
                Action:"setTaxStatus",
                TaxStatus:$scope.taxStatus,
                invoicesID:$scope.echo_invoicesID
            };
            $http.post('/services/sell/setTaxStatus',args).then
            (function xSuccess(response) {
                $scope.Show_Selected_invoice($scope.echo_invoicesID);
                console.log(response.data)

                // get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);
                // $scope.product_details=false;
            }), function xError(response)
            {}

        }

//------------------------------------------------
        $scope.add_subProduct_in_Invoice=function()
        {
            if ($scope.mode==1)
                productIDx=$scope.ProductID;
            else
                productIDx=$("#selectProductByPartNum_SubProduct").val();
            //alert($scope.invoiceID+"/ "+$scope.parentProduct_id+' / '+ $scope.partnumbers_id +' / '+$scope.Subproduct_QTY);
            var args= {
                Action:"add_subProduct_in_Invoice",
                invoiceID:$scope.invoiceID,
                parentProduct_id:$scope.parentProduct_id ,
                SubproductID:productIDx,
                Qty:$scope.Subproduct_QTY ,
            };
            $http.post('/services/sell/addSubProductTo_Invoice',args).then
            (function xSuccess(response) {
                console.log(response.date);
                get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);
                $scope.product_details=false;
            }), function xError(response)
            {}
        }
//------------------------------------------------




        function checkEplValu(val)
        {
            if (val=='--')
                return 0;
            return val;
        }

        //-------------------

        $scope.addSubproduct=function(invoiceID,parentid)
        {

            $scope.invoiceID=invoiceID;
            $scope.parentProduct_id=parentid;
            // SelectDimmer('subPartToinvoice');
            $('#Dimmer_page').dimmer('show');
            $scope.section_addSubProduct_dimmer=true;
            $('.mainInvoice').addClass('backLayer');
            //----------------------
            $scope.fiald_modeB(0);
            $scope.partnumbers_id=0;
            $scope.echo_Brand_B="";
            $scope.echo_Type_B="";
            $scope.echo_ProductTitle_B="";
            get_subProduct_Data(invoiceID,parentid);
        }

        function get_subProduct_Data(invoiceID,parentid)
        {
            $scope.waitForLoading=true;
            //----------------------
            var args= {
                Action:"get_subProduct_list_invoice",
                invoiceID:invoiceID,
                parentProduct_id:parentid,
            };

            $http.post('/services/sell/get_subProduct_list_invoice',args).then
            (function xSuccess(response) {
                $scope.subProduct=response.data;
                $scope.waitForLoading=false;
            }), function xError(response)
            {}
        }

//--------------------------------------
        $scope.updateSortableList=function() {
            var args= {
                Action:"updateSortableList",
                data:$scope.subProduct,
            };
            $http.post('/services/sell/updateSortableList',args).then
            (function xSuccess(response) {
               console.log(response.data);
            }), function xError(response)
            {}
        }
//--------------------------------------
        $scope.closeSubProductDimmer =function()
        {
            $scope.Show_Selected_invoice($scope.invoiceID);
            $scope.section_addSubProduct_dimmer=false;
            $('.mainInvoice').removeClass('backLayer');

        }
//--------------------------------------
        $scope.delete_subProduct_inVoice=function(invoiceDetialsID)
        {
            var r = confirm(deleteMessage);
            if (r == true) {access=true;} else {access=false;  }
            if (access)
            {


                get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);


                var args= {
                    Action:"delete_subProduct_from_list_invoice",
                    invoiceDetialsID:invoiceDetialsID,
                };

                $http.post('/services/sell/delete_subProduct_from_list_invoice',args).then
                (function xSuccess(response) {
                    get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);
                }), function xError(response)
                {}


                // alert(invoiceDetialsID);
            }

        }
//--------------------------------------

        $scope.checkEnterpressd=function ($event)
        {
            var keyCode = $event.which || $event.keyCode;
            if (keyCode===13)
            {
                $scope.add_product_to_invoice_array();
//                $( "#add_product_to_invoice" ).trigger( "focus" );

            }
        }
//#######################################
        //--- Remove ','
        function RemoveCama(prices)
        {
            cleanedValue="";
            price= prices;
            Alength= price.length;
            for(i=0;i<=Alength-1;i++)
            {
                if ( price[i] !=',')
                {
                    cleanedValue=cleanedValue+price[i];
                }
            }
            return cleanedValue;
        }

        //######## ACTIONS ###################
        $scope.save_Invoice_Base=function()
        {
            var args= {
                Action:"SaveInvoice_Base",
                invoice_AliasID : $scope.invoiceAlias,
                invoice_date    : $("#InvoiceDate").attr("data-mdpersiandatetimepickerselecteddatetime"),
                invoice_Currency:  $("#Currency").val(),
                invoice_custommerID: $("#custommerID").val()
            };


            $http.post('/services/sell/save_Invoice_Base',args).then
            (function xSuccess(response)
            {
                console.log(response.data);
                if (response.data!=0)
                {
                    All_invoice_Date(0);
                    $scope.Show_Selected_invoice(response.data[0].invoicesID);
                }
                else
                    toast_alert(error_message,'danger');
            }), function xError(response)
            {
                console.log(response.data);
            }
        }

        //-------------
        $scope.addInvoiceDetailsTo_DB=function (mode)
        {
            var Args= {
                Action:"add_product_to_invoice_DB",
                invoicesID : $scope.invoicesID,
                productArray: sritems,
                invoice_detilas_Array :invoice_detilas
            };
            $http.post('/services/sell/add_product_to_invoice_DB',Args).then(
                function xSuccess(response)
                {
                    All_invoice_Date(0);
                    if(response.data)
                    {
                        toast_alert( Seved_Message,'success');
                        $('#Dimmer_page').dimmer('hide');
                        if (mode==1)
                        {
                            console.log(Args);
                            $scope.Show_Selected_invoice($scope.invoicesID);
                        }

                    }
                }),
                function xError(response)
                {
                    console.log(response.data);
                }

        }
        //------------------------

        $scope.Show_Selected_invoice =function(Invoice_id)
        {
            $('.mainInvoice').removeClass('backLayer');
            $scope.waitForList=true;
            //`````````````````````````
            $scope.invoiceDetials('Set_editform','none','none');
            //.........................
            $scope.NewinvoiceRow=false;
            $scope.show_invoiceRow=true;
            $scope.EditinvoiceRow=false
            $scope.selectProductx=true;
            $scope.mode0_fiald =true;
            $scope.productTabel=true;
            $scope.new_form_control =false;
            $scope.edit_form_control=true;
            load_PartNumbers();
            load_Brands();

            //`````````````````````````
            var Args= {
                Action:"Get_Selected_invoice_Data",
                invoicesID :Invoice_id,
            };
            $http.post('/services/sell/Get_Selected_invoice_Data',Args).then(
                function xSuccess(response)
                {
                    console.log(response.data)
                    $scope.fiald_mode(0);
                    // if (response.data['0']['0'].si_VerifiedBy !=null)
                    //     toast_alert('You are not able to edit this item','warning');
                    // else {
                    if (response.data['0']['0'].si_tax_setting_status == 0 || response.data['0']['0'].si_tax_setting_status == null)
                        $scope.taxStatus = false;
                    else
                        $scope.taxStatus = true;

                    SelectDimmer('edit_invoice');
                    $('#Dimmer_page').dimmer('show');
                    $(".MainLoading").addClass("show");
                    $scope.echo_invoicesID = Invoice_id;

                    // $dateis=(response.data['0']['0'].si_date).split('-');
                    // $scope.echo_date = gregorian_to_jalali(parseInt($dateis[0]),parseInt($dateis[1]),parseInt($dateis[2]));

                    $scope.echo_date=Date_Convert_gregorianToJalali(response.data['0']['0'].si_date);

                    $scope.echo_invoiceAlias = response.data['0']['0'].si_Alias_id;
                    $scope.echo_orgName = response.data['0']['0'].org_name + '(' + response.data['0']['0'].cstmr_name + ' ' + response.data['0']['0'].cstmr_family + ')';
                    $scope.echo_custommerID = response.data['0']['0'].si_custommer_id;
                    $scope.echo_Currency = response.data['0']['0'].sic_Currency;
                    $scope.echo_Currency_id = response.data['0']['0'].si_Currency;
// //``````````````````````````

                    $scope.echo_warranty = response.data['0']['0'].si_warranty;
                    if ($scope.echo_warranty != null)
                    {
                        $scope.warranty_show =true;
                        $scope.warranty_edit =false;
                    }
                    else
                    {
                        $scope.warranty_edit =true;
                        $scope.warranty_show =false;
                    }
//-----------------------------------------
                    $scope.echo_Payment = response.data['0']['0'].si_Payment;
                    if ($scope.echo_Payment != null)
                    {
                        $scope.Payment_show =true;
                        $scope.Payment_edit =false;
                    }
                    else
                    {
                        $scope.Payment_edit =true;
                        $scope.Payment_show =false;
                    }
//-----------------------------------------
                    $scope.echo_deliveryDate =response.data['0']['0'].si_deliveryDate  ;
                    if ($scope.echo_deliveryDate !=null)
                    {
                        $scope.deliveryDate_show =true;
                        $scope.deliveryDate_edit =false;
                    }
                    else
                    {
                        $scope.deliveryDate_edit =true;
                        $scope.deliveryDate_show =false;
                    }

//-----------------------------------------
                    $scope.echo_invoice_delivery_Type =response.data['0']['0'].si_delivery_type  ;
                    if ($scope.echo_invoice_delivery_Type !=null)
                    {
                        $scope.invoice_delivery_Type_show =true;
                        $scope.invoice_delivery_Type_edit =false;
                    }
                    else
                    {
                        $scope.invoice_delivery_Type_edit =true;
                        $scope.invoice_delivery_Type_show =false;
                    }

//-----------------------------------------
                    $scope.echo_validityDuration = response.data['0']['0'].si_validityDuration;
                    if ($scope.echo_validityDuration != null)
                    {
                        $scope.validityDuration_show =true;
                        $scope.validityDuration_edit =false;
                    }
                    else
                    {
                        $scope.validityDuration_edit =true;
                        $scope.validityDuration_show =false;
                    }


                    $("#warranty_val").val($scope.echo_warranty);
                    $("#Payment_val").val($scope.echo_Payment);
                    $("#deliveryDate_val").val($scope.echo_deliveryDate);
                    $("#invoice_delivery_Type_Val").val($scope.echo_invoice_delivery_Type);
                    $("#validityDuration_Val").val($scope.echo_validityDuration);


                    $scope.echo_Discount =response.data['0']['0'].si_Discount  ;
                    if ($scope.echo_Discount !=null) $scope.DiscountValue =true;
                    else
                    {
                        $scope.DiscountBTN=true;
                        $scope.echo_Discount=0;
                    }



                    if (response.data['0']['0'].si_Description !=null )
                    {$scope.invoiceDescription_view=true;$scope.invoiceDescription_edit=false;
                        $scope.Description_input =response.data['0']['0'].si_Description;
                        $scope.invoiceDescription_view=response.data['0']['0'].si_Description;
                    }
                    else
                    {$scope.invoiceDescription_view=false;$scope.invoiceDescription_edit=true;
                        $scope.Description_input =response.data['0']['0'].si_Description;
                    }


                    // if ($scope.echo_Description !=null) $scope.DescriptionValue =true;
                    // else $scope.DescriptionBTN=true;

                    // //``````````````````````````
                    Invoice_products=response.data['1'];
                    sritems=Invoice_products;

                    $scope.addedRows=  sritems;

                    // //``````````````````````````
                    $scope.ArrayCount=response.data['2'].ArrayCount;
                    $scope.echo_TotalQty=response.data['2'].TotalQty;
                    $scope.echo_TotalPrice=response.data['2'].TotalPrice;
//            $scope.echo_tax_price= response.data['2'].TotalPrice *0.09;//             Math.round( response.data['2'].TotalPrice *0.09) ;
                    if (response.data['0']['0'].si_tax_setting_status)
                        $scope.echo_tax_price=(response.data['2'].TotalPrice-$scope.echo_Discount)*0.09;
                    else
                        $scope.echo_tax_price=0;


                    $scope.echo_Total_factor_price=$scope.echo_tax_price+($scope.echo_TotalPrice-$scope.echo_Discount) ;
                    $scope.echo_Total_EPL_price=response.data['2'].Total_EPL_price;
                    totalEPL=$scope.echo_Total_EPL_price;


                    //.........................
                    var deskArray = ["توضیحات نمونه اول ",
                        "نمونه توضیحات ",
                        "توضیحات دوم ",
                        "نمونه اطلاعات اولیه",
                        "پیش فاکتور نمونه"];
                    autocomplete(document.getElementById("Description_input"), deskArray);

                    $(".MainLoading").removeClass("show");
                    //if (arryLenght>=5)
                    $("#Dimmer_page").addClass("dimmer_scroller");
                    $scope.waitForList=false;
                    //}
                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
        }
//-------------------
        $scope.edit_invoice_Desc=function()
        {
            $scope.invoiceDescription_edit=true;
            $scope.invoiceDescription_view=false;
        }
//-------------------
        $scope.save_invoice_Desc=function()
        {
            var args= {
                Action:"save_invoice_Desc",
                invoicesID :$scope.echo_invoicesID,
                Description_input:$scope.Description_input,
            };


            $http.post('/services/sell/save_invoice_Desc',args).then
            (function xSuccess(response) {

                console.log(response.data);
                $scope.Show_Selected_invoice($scope.echo_invoicesID);
                $scope.invoiceDescription_edit=false;
                $scope.invoiceDescription_view=true;

                // get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);
                // $scope.product_details=false;
            }), function xError(response)
            {}
        }
//-------------------


        $scope.cancle_invoice_Desc =function()
        {
            $scope.Show_Selected_invoice($scope.echo_invoicesID);
            $scope.invoiceDescription_edit=false;
            $scope.invoiceDescription_view=true;
        }

//-------------------

        $scope.invoiceConfirm=function(invoiceID)
        {
            access=false;
            var r = confirm(Message_Confirm_invoice);
            if (r == true) {access=true;} else {access=false;  }
            if (access)
            {
                var Args= {
                    Action:"Confirm_Invoice",
                    invoice_ID:invoiceID,
                };
                $http.post('/services/sell/Confirm_Invoice',Args).then(
                    function xSuccess(response)
                    {
                        $scope.EditInvoiceLIST(0);
                        All_invoice_Date(0);
                        $scope.closeDimmer();
                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }
            }
        }
        //---------------

        $scope.EditInvoiceLIST=function(mode)
        {
            // alert('EditInvoiceLIST');
            // if(sritems.length)
            // {
            //     var Args= {
            //         Action:"Edit_Invoice",
            //         desc:$scope.Description_input,
            //         ProductArray :sritems
            //     };
            //
            //     $http.post('/services/sell/Edit_Invoice',Args).then(
            //         function xSuccess(response)
            //         {
            //             if (response.data=='Saved')
            //             {
            //                 All_invoice_Date(0);
            //                 toast_alert(edited_Message,'success');
            //                 if (mode==0)
            //                     $('#Dimmer_page').dimmer('hide');
            //             }
            //             else
            //                 toast_alert(error_message,'danger');
            //         }),
            //         function xError(response)
            //         {
            //             toast_alert(response.data,'warning');
            //         }
            // }

        }

//-----------------------------------
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
        //------------------------------------
        $scope.GroupRestoreORMoveToTrash=function (mode)
        {

            /*confirm ؟ */
            access=false;
            var r = confirm(deleteMessage);
            if (r == true) {access=true;} else {access=false;  }
            //----------------
            if (access)
            {
                $(".MainLoading").addClass("show");
                var id_array =[];
                $(".checkbox:checked").each(function() {
                    id_array.push($(this).val());
                });

                if (id_array.length)
                {
                    var Args= {
                        Action:"delete_restore_Invoice",
                        InvoiceIDArray :id_array,
                        mode:mode
                    };
                    $http.post('/services/sell/delete_restore_Invoice_Group',Args).then(
                        function xSuccess(response)
                        {
                            All_invoice_Date(0);
                            console.log(response.data);
                            $(".MainLoading").removeClass("show");
                        }),
                        function xError(response)
                        {
                            console.log(response.data);
                        }
                }
            }


        }
        //------------------------------------]

        $scope.move_invoicetoTrash=function(id,Delmode)
        {
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if (access)
            {
                var Args= {
                    Action:"delete_selected_invoice",
                    selectesRowId :id,
                    Delete_mode :Delmode
                };
                $http.post('/services/sell/delete_selected_invoice',Args).then(
                    function xSuccess(response)
                    {
                        if(response.data)
                            $( "#row"+response.data).hide(1000);
                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }
            }

        }

//----------------------
        $scope.change_invoice_qty=function(invoiceID,producID,OldQty,roID)
        {
            var newQTY = prompt(insetNewQTY_message, OldQty);
            if (newQTY == null || newQTY == "") {
                toast_alert('empty !!?','warrning');
            } else {
                sritems[roID].qty=parseInt(newQTY) ;

                var Args= {
                    Action:"Update_invoice_qrt",
                    invoiceID :invoiceID,
                    producID :producID,
                    NewQTY: newQTY
                };
                $http.post('/services/sell/Update_invoice_qrt',Args).then(
                    function xSuccess(response)
                    {
                        if ($scope.formStatus=='edit')
                        {
                            $scope.EditInvoiceLIST(1);
                            $scope.Show_Selected_invoice(invoiceID);
                        }
                        else
                        {
                            sritems[roID].QTY=newQTY;
                            $('#TotalPrice'+producID).html( sritems[roID].qty* sritems[roID].Unit_price);
                            $scope.echo_TotalQty= (($scope.echo_TotalQty-OldQty)+parseInt(newQTY));
                            $scope.echo_Total_EPL_price="...";
                            $scope.echo_TotalPrice ="...";
                            $scope.echo_tax_price  ="...";
                        }

                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }



                // $('#TotalPrice'+producID).html( sritems[roID].qty* sritems[roID].Unit_price);
                // $scope.echo_TotalQty= (($scope.echo_TotalQty-OldQty)+parseInt(newQTY));


                //$scope.echo_TotalQty
                //sritems[roID].QTY=newQTY;
            }
            //alert(invoiceID+')'+producID+'-'+OldQty)
        }


        $scope.editUnit_price=function (index)
        {
            $("#editUnitprice"+index).removeClass('hidden');
            $("#UnitpriceLable"+index).addClass('hidden');
        }
        //----------------------
        $scope.change_invoice_unit_price=function(invoiceID,producID, OLDUnit_price,roID)
        {
        var Args=
            {
                Action:"Update_invoice_price",
                invoiceID :invoiceID,
                producID :producID,
                NewPrice:RemoveCama($('#inputID'+roID).val())
            };
        $http.post('/services/sell/Update_invoice_price',Args).then(
            function xSuccess(response)
            {
                if ($scope.formStatus=='edit') {
                    $scope.EditInvoiceLIST(1);
                    $scope.Show_Selected_invoice(invoiceID);
                    $(".editUnitpriceInput").addClass('hidden');

                }
                else
                {
                    sritems[roID].Unit_price=newprice;
                    $('#TotalPrice'+producID).html( sritems[roID].qty* sritems[roID].Unit_price);
                    // $scope.echo_TotalQty= (($scope.echo_TotalQty-OldQty)+parseInt(newQTY));
                    $scope.echo_Total_EPL_price="...";
                    $scope.echo_TotalPrice ="...";
                    $scope.echo_tax_price  ="...";
                }
            }),
            function xError(response)
            {
                toast_alert(response.data,'warning');
            }
        }
        //----------------------
        $scope.delete_itemFromInvoiceList=function(invoice_id,product_id,rowId)
        {
            access=false;var r = confirm(deleteMessage);if (r == true) {access=true;} else {access=false; }
            if (access)
            {
                console.log(sritems);
                i=0;
                sritems.forEach(doAction);
                function doAction()
                {
                    if (sritems[i].invoice_id ==invoice_id && sritems[i].product_id ==product_id )
                    {
                        totalEPL=totalEPL-(sritems[i].EPL_price* sritems[i].qty);
                    }
                    i++;
                }
                $scope.echo_Total_EPL_price=totalEPL;
                var Args= {
                    Action:"delete_item_From_Invoice_List",
                    invoiceID :invoice_id,
                    producID  :product_id,
                    ItemArray:sritems
                };
                $http.post('/services/sell/deleteItemFromInvoiceList',Args).then(
                    function xSuccess(response)
                    {
                        console.log(response.data);
                        if (response.data==1)
                        {
                            sritems.splice(rowId-1,1);
                            $( "#DivRow"+rowId ).hide(1000);
                            //$scope.Show_Selected_invoice(invoice_id);

                        }
                        else if (response.data==404)
                        {
                            sritems.splice(rowId-1,1);
                            $( "#DivRow"+rowId ).hide(1000);
                        }

                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }
            }

        }
//.............
        $scope.showUpdateInput=function(id)
        {
            $("#QtyValueLabel"+id).addClass('hide');
            $("#QtyValueInput"+id).removeClass('hide');
        }
//.............
        $scope.updateNewSubProductQty=function(pid,invoice_ID,parentProduct_id)
        {
            $newQty=$("#QtyValue"+pid).val();
            var Args= {
                Action:"update_NewSubProduct_Qty",
                invoiceID :invoice_ID,
                producID  :pid,
                parentProduct_id :parentProduct_id,
                new_Qty:$newQty
            };
            $http.post('/services/sell/update_NewSubProduct_Qty',Args).then(
                function xSuccess(response)
                {
                     console.log(response.data);
                    if (response.data==1)
                    {
                        toast_alert('Qty Updated','success');
                        $scope.addSubproduct(invoice_ID,parentProduct_id)
                        $("#QtyValueLabel"+pid).removeClass('hide');
                        $("#QtyValueInput"+pid).addClass('hide');
                    }
                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }

        }
        //.............
        $scope.copyInvoice=function (invoiceID)
        {
            access=false;var r = confirm(copyMessage);if (r == true) {access=true;} else {access=false; }

            if (access)
            {
                $(".MainLoading").addClass("show");
                var Args= {
                    Action:"Copy_Invoice",
                    invoiceTargetID : invoiceID
                };
                $http.post('/services/sell/Copy_Invoice',Args).then(
                    function xSuccess(response)
                    {
                        All_invoice_Date(0);
                        $(".MainLoading").removeClass("show");
                        console.log(response.data);
                    }),
                    function xError(response)
                    {
                        toast_alert(response.data,'warning');
                    }
            }
        }
//--------------------------------
        $scope.Edit_invoice_Row_BTN=function()
        {
            Load_curency();
           // load_custommers();
            $scope.EditinvoiceRow=true;
            $scope.selectProductx=false;
            $scope.mode0_fiald =false;
            $scope.productTabel=false;
            $scope.new_form_control =false;
            $scope.edit_form_control=false;

            $scope.invoiceAlias=$scope.echo_invoicesID;
            $scope.datesXD=$scope.echo_date;
            $scope.Currency= $scope.echo_Currency_id;
            $('.selectpicker').selectpicker('val', $scope.echo_custommerID.toString());

        }
//-----------------------------------
        $scope.edit_invoice_Base_data=function()
        {
            var Args= {
                Action:"edit_invoice_Base_data",
                invoicesID : $scope.echo_invoicesID,
                // new_date:$("#datesXD").attr("data-mdpersiandatetimepickerselecteddatetime"),
                 new_date:$("#datesXD").val(),
                new_Currency:$scope.Currency,
                new_custommerID :  $('#EditcustommerID').val()
            };



            $http.post('/services/sell/edit_invoice_Base_data',Args).then(
                function xSuccess(response)
                {
                    $scope.EditinvoiceRow=false;
                    $scope.selectProductx=true;
                    $scope.mode0_fiald =true;
                    $scope.productTabel=true;
                    $scope.new_form_control =false;
                    $scope.edit_form_control=true;
                    console.log(response.data);
                    All_invoice_Date(0);
                    $scope.EditInvoiceLIST(1);
                    $scope.Show_Selected_invoice($scope.echo_invoicesID);
                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
        }
        //-------------------
        $scope.Cancel_invoice_Base_data=function ()
        {
            $scope.EditinvoiceRow=false;
            $scope.selectProductx=true;
            $scope.mode0_fiald =true;
            $scope.productTabel=true;
            $scope.new_form_control =false;
            $scope.edit_form_control=true;

            $scope.invoiceAlias="";
            $scope.datesXD="";
            $scope.Currency="";
            $scope.custommerID="";

        }
        //-------------------
        $scope.showInvoiceInSearch =function(invoiceID) {
            $scope.Show_Selected_invoice(invoiceID);
        }

        //-------------------

        $scope.changePosition=function (doing ,recordID,value) {
            var Args= {
                Action:'changePosition',
                doing: doing,
                recordID : recordID,
                invoiceID:$scope.invoiceID,
                position:value
            };
            $http.post('/services/sell/changePosition',Args).then(
                function xSuccess(response)
                {
                    console.log(response.data);
                    get_subProduct_Data($scope.invoiceID,$scope.parentProduct_id);

                }),
                function xError(response)
                {
                    toast_alert(response.data,'warning');
                }


        }
//---------------###############################---------------
        //@@@ stock Request @@@
//---------------###############################---------------
//**************Public Functions
        function SelectDimmer(dimmer)
        {
            switch(dimmer)
            {
                case 'new':
                    $scope.selectedModeIs=  'new';
                    $scope.FormTitle=lbl_sell_AddNew_stockRequest;
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
            $scope.ShowWarrantyDiuration=false;

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
                 $scope.sr_cstmr_id=  $resp.cstmr_id;
                $scope.sr_custommer=$resp.cstmrName+' '+$resp.cstmrFamily;
                $scope.sr_type=$resp.stockRequestsType.toString();
                $scope.sr_preFaktorNum=$resp.contract_number;
                //console.log($resp.warranty_date);
                $scope.warranyDate=Date_Convert_gregorianToJalali($resp.warranty_date);
                $scope.WarrantyPriod=$resp.WarrantyPriod ;

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
        //--------------------
        $scope.changeQTY=function(productID,OldQTY,StockRequestID,sr_type,index)
        {
            alert('The Codes are Commented ');
          //  var newQTY = prompt(insetNewQTY_message, OldQTY);


            //
            //  var newQTY = prompt(insetNewQTY_message, OldQTY);
            //  if (newQTY < OldQTY && newQTY != null)
            //  {
            //      var Args={
            //          stockrequest_id:StockRequestID,
            //          productid:productID,
            //      }
            //      $http.post('/services/sell/countOftakeoutproducts',Args).then(function xSuccess(response)
            //      {
            //        toast_alert('تعداد وارد شده از تعداد قبلی کمتر است ','warning')
            //
            //      }), function xError(response) { }
            //  }
            //
            // // else if (newQTY == null || newQTY == "") {/*toast_alert('empty !!?','warning');*/ }
            //  else
            //   {
            //      if (sr_type==1) // is  Ta'ahodi
            //      {
            //          var Args={
            //              type:sr_type,
            //              stockrequerst_id:StockRequestID,
            //              product_id:productID,
            //              qty:parseInt(newQTY),
            //              oldQty:OldQTY,
            //          }
            //          $http.post('/services/sell/UpdateProductQTY',Args).then(function xSuccess(response)
            //          {
            //              stockRequestProducts[index].product_QTY= newQTY;
            //          }), function xError(response) { }
            //      }
            //      else if (sr_type==0) // is  Ghatii  sr_type=0
            //      {
            //        //Update QTY  OLdQTY+newQTY | in -> stockrequests details Table
            //        //chak if Product is Avail ->  Avail=Avail-newQTY  &  Reserve=Reserve+newQTY | in -> product_status Table
            //          var Args={
            //              type:sr_type,
            //              stockrequerst_id:StockRequestID,
            //              product_id:productID,
            //              qty:parseInt(newQTY),
            //              oldQty:OldQTY,
            //          }
            //          $http.post('/services/sell/UpdateProductQTY',Args).then(function xSuccess(response)
            //          {
            //              if (response.data==1)
            //                stockRequestProducts[index].product_QTY= newQTY;
            //              else
            //                  toast_alert(Order_QTY_error_message,'danger');
            //          }), function xError(response) { }
            //      }
            //  }
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
        function getList_StockRequest(amode,currentPage,pagin)
        {
            if (pagin) pagination=pagin
            else pagination=10;
            sPageURL =document.URL;
            var sURLVariables = sPageURL.split('/');
            locations= sURLVariables[sURLVariables.length-1]  ;
            if   (locations=="TakeOutProducts") typeVal=0; else typeVal=1;
            var newFormData={mode:amode,type:typeVal};

            $http.post('/services/sell/GetAllstockRequest',newFormData).then
            (function pSuccess(response)
            {
                listArray=response.data;
                $scope.allRowsZ=listArray;
//----------------------
                var Args={mode:0,}
                $http.post('/services/sell/getList_AllCustommers',Args).then(function xSuccess(response)
                {
                    console.log( response.data);
                    return  $scope.custommersNameOrgList=response.data;
                }), function xError(response)
                {
                    toast_alert(response.data,'warning');
                }
//---------------------
                $scope.pagination = Pagination.getNew(pagination);
                $scope.pagination.numPages = Math.ceil($scope.allRowsZ.length/$scope.pagination.perPage);
                if (currentPage !='') $scope.pagination.page=currentPage;

                //--------------
                id=22;
                var section = "dropDownSection" + "_" + id;
                $scope.section = true;
                //------------------

            }), function xError(response)
            {
            }
        }
        getList_StockRequest(0,0);

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
                    sr_deliveryDate:conf_date,
                    WarrantyPriod : $scope.WarrantyPriod
                }


                $http.post('/services/sell/addStockRequestToDB',Args).then(function xSuccess(response)
                {
                   console.log(response.data);
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
                    if (productData.length)
                    {
                        $scope.echo_Brand=$scope.brandsID;
                        $scope.echo_Type=$scope.TypeID;
                        console.log(productData);
                        $scope.echo_ProductTitle= productData[0].stkr_prodct_title;
                    }
                    else
                    {
                        $scope.echo_Brand='کالایی انتخاب نشده است ';
                        $scope.echo_Type='';
                        $scope.echo_ProductTitle=' ';
                    }


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
    $scope.editWarrantyDiuration=function (value)
    {
       $scope.WarrantyPriod_val =value;
       $scope.ShowWarrantyDiuration=true;
    }
//*********************************
    $scope.UpdateWarrantyDiuration=function (StockRequestID ) {
            var arg={
                StockRequestID :StockRequestID ,
                WarrantyDiurationValue:$scope.WarrantyPriod_val
            }
        $http.post('/services_sell/Stockrequest/UpdateWarrantyDiuration',arg).then
        (function xSuccess(response) {
            console.log(response.data);
            $scope.ShowWarrantyDiuration=false;
            $scope.EditSelected(StockRequestID);
        }), function xError(response)
        {}

    }


    }]);
