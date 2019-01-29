<?php
    use \App\Http\Controllers\PublicController;
    $InvoiceInfo=$result[0][0];
    $productList=$result[1];
    $invoiceTolalInfo=$result[2];


?>
<html lang="fa">
    <head>
        @include('layouts.parts.head')
    </head>
    <header>
        <style>
            @media print
            {
                .no-print, .no-print *
                {
                    display: none !important;
                }
                .invoice-Desc
                {
                    margin-top: 150px;
                }
                .page-body {

                }
                .page-header img
                {
                    width: 100%;
                    position: fixed;
                    top: 0px;
                }
                .page-footer
                {
                    width: 100%;
                    position: fixed;
                    bottom: 0px;
                }

            }
        /*////////////*/
            body{
                background: #fff !important;
                }

            .table tr th {
                background: gray !important;
                color: #fff !important;
              }

            .page-header
            {
                width: 100%;
                padding-bottom: 1px !important;
                border-bottom: 0px !important;
            }

            .page-header img
            {
                width: 100%;
            }
            .invoice-Desc
            {

            }

            .page-body
            {

            }

            .page-footer
            {
                width: 100%;
            }
            .page-footer img
            {
                width: 100%;
            }

            .invoice_Info div {
                margin-bottom: 10px;
            }

            .invoice_Info {
                margin-top: -220px;
                margin-bottom: 130px;
                background: #f4f4f4 !important;
                padding-top: 10;
                border-radius: 5px;
            }



        </style>
    </header>
    <body>
        <div class="container">
            <div class="page-header">
                <img src="/img/sr_print_logo.png"  >
            </div>

            {{--<a href="/sell/invoice" class="btn btn-danger no-print" style="float: left">{{Lang::get('labels.back')}} </a>--}}
            {{--<button onclick="window.print()" class="btn btn-success no-print" style="float: left; margin-left: 5px">--}}
                {{--{{Lang::get('labels.print')}}--}}
                {{--<i class="fa fa-print"></i>--}}
            {{--</button>--}}

            <div class="invoice-Desc" >
                <div class="Page1_header"><h2>{{Lang::get('labels.Sell_invoice')}} </h2></div>
                <div class="col-md-12">
                    <div class="col-md-9 pull-right"></div>
                    <div class="col-md-3 pull-left invoice_Info" >
                        <div>{{Lang::get('labels.codeghtesadi')}}  :  {{Lang::get('labels.codeEghtesadiPishro')}} </div>
                        <div>{{Lang::get('labels.date')}}  :     {{$InvoiceInfo->si_date}} </div>
                        <div>{{Lang::get('labels.Number')}}  :   {{$InvoiceInfo->si_Alias_id}} </div>
                        <div>{{Lang::get('labels.invoiceSalesExpert')}} : {{$invoiceTolalInfo['CreatedBy']}}</div>
                    </div>
                </div>
            </div>

            {{--------------------------------------------------}}
            <div class="page-body">
                <table class="table" >
                    <tr  style="border-bottom: 1px solid">
                        <td>{{Lang::get('labels.invoice_seller')}} </td>
                        <td>{{$InvoiceInfo->org_name }} -{{$InvoiceInfo->cstmr_name }} {{$InvoiceInfo->cstmr_family }}  </td>
                        <td>{{Lang::get('labels.codeghtesadi')}}</td>
                        <td>{{$InvoiceInfo->org_codeeghtesadi}} </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('labels.address2')}}</td>
                        <td>{{$InvoiceInfo->org_address }}</td>
                        <td>{{Lang::get('labels.tel')}}</td>
                        <td>{{$InvoiceInfo->org_tel }}</td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>{{Lang::get('labels.Orders_row')}}</th>
                        <th>{{Lang::get('labels.Product_title')}}</th>
                        <th>{{Lang::get('labels.QTY')}}</th>
                        <th>{{Lang::get('labels.invoice_Unit_price')}} ({{$InvoiceInfo->sic_Currency}})</th>
                        <th>{{Lang::get('labels.invoice_Total_Price')}} ({{$InvoiceInfo->sic_Currency}})</th>
                        <th>{{Lang::get('labels.invoice_Info')}}</th>
                    </tr>
                    <?php $isFirstPage=true;
                        $total=count($productList);
                    ?>
                    @for ($i = 0; $i <= count($productList)-1; $i++)
                        <?php
                        if ($i>=15 && $total >=15  && $isFirstPage)
//                        if ($i==20  && $isFirstPage ==true )
                            {
                                echo '<tr style="height:100mm  ; background: red !important;"> </tr>'.$i;
                                $isFirstPage=false;
                        ?>
                        <tr>
                            <th>{{Lang::get('labels.Orders_row')}}</th>
                            <th>{{Lang::get('labels.Product_title')}}</th>
                            <th>{{Lang::get('labels.QTY')}}</th>
                            <th>{{Lang::get('labels.invoice_Unit_price')}}</th>
                            <th>{{Lang::get('labels.invoice_Total_Price')}}</th>
                            <th>{{Lang::get('labels.invoice_Info')}}</th>
                        </tr>
                        <?php
                            }

                           else  if ($i==20  && $isFirstPage ==false )
                               {
                                echo '<tr style="height:250px  ;"> </tr>'.$i;
                                ?>
                                    <tr>
                                        <th>{{Lang::get('labels.Orders_row')}}</th>
                                        <th>{{Lang::get('labels.Product_title')}}</th>
                                        <th>{{Lang::get('labels.QTY')}}</th>
                                        <th>{{Lang::get('labels.invoice_Unit_price')}}</th>
                                        <th>{{Lang::get('labels.invoice_Total_Price')}}</th>
                                        <th>{{Lang::get('labels.invoice_Info')}}</th>
                                    </tr>
                               <?php
                            }
                        else if ($i%45==0 && $i!=0 && !$isFirstPage )
                            {
                            echo '<tr style="height:250px  ;"> </tr>'.$i;
                            ?>
                            <tr>
                                <th>{{Lang::get('labels.Orders_row')}}</th>
                                <th>{{Lang::get('labels.Product_title')}}</th>
                                <th>{{Lang::get('labels.QTY')}}</th>
                                <th>{{Lang::get('labels.invoice_Unit_price') }} </th>
                                <th>{{Lang::get('labels.invoice_Total_Price')}}</th>
                                <th>{{Lang::get('labels.invoice_Info')}}</th>
                            </tr>
                            <?php
                            }
                        ?>
                            <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$productList[$i]['product_Title']}}</td>
                            <td>{{$productList[$i]['qty']}}</td>
                            <td>{{ PublicController::CurencySeprator($productList[$i]['Unit_price'])}}</td>
                            <td>{{ PublicController::CurencySeprator($productList[$i]['Unit_price'] * $productList[$i]['qty'] )}}</td>
                            <td>{{$productList[$i]['partNumber']}}</td>
                            </tr>
                    @endfor

                    <tr>
                        <td></td><td></td><td></td>
                        <td>{{lang::get('labels.Totalsummery')}} </td>
                        <td>{{PublicController::CurencySeprator($invoiceTolalInfo['TotalPrice'])}} </td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td>
                        <td>{{lang::get('labels.invoice_Discount')}} </td>
                        <td>{{PublicController::CurencySeprator($InvoiceInfo->si_Discount)}} </td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td>
                        <td>{{lang::get('labels.invoice_tax')}} </td>
                        <td>{{PublicController::CurencySeprator($tax=($invoiceTolalInfo['TotalPrice']-$InvoiceInfo->si_Discount)*0.09 )}} </td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td>
                        <td style="background: gray  !important;color: #fff!important;">{{lang::get('labels.invoice_Total')}} </td>
                        <td>{{PublicController::CurencySeprator($invoiceTolalInfo['TotalPrice']+$tax) }} ({{$InvoiceInfo->sic_Currency}})</td>
                        <td></td>
                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td class="col-md-2" style="text-decoration: underline">{{Lang::get('labels.invoice_Description')}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="col-md-2">{{Lang::get('labels.invoice_warranty')}}</td>
                        <td>{{$InvoiceInfo->si_warranty}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">{{Lang::get('labels.invoice_Payment')}}</td>
                        <td>{{$InvoiceInfo->si_Payment}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">{{Lang::get('labels.invoice_deliveryDate')}}</td>
                        <td>{{$InvoiceInfo->si_deliveryDate }}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">{{Lang::get('labels.invoice_Info')}}</td>
                        <td>{{$InvoiceInfo->si_Description }}</td>
                    </tr>
                </table>
            </div>
            {{--------------------------------------------------}}
            <div class="page-footer" style="width: 100%;">
                <img  src="/img/sr_print_bt_logo.png" class="footerimage page-header-img">
            </div>
        </div>
    </body>
</html>