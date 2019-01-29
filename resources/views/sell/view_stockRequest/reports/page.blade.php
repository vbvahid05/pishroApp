

<html>
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

            table th {
                background: gray !important;
                color: #fff !important;
            }
        }
        body {
            background: #FFFFFF !important;
        }
        .row {
            margin-bottom: 10;
            margin-top: 20;
        }
        a.btn.btn-primary {
            width: 100%;
        }

        button.btn.btn-success{
            width: 100%;
        }
        table {
            width: 100%;
        }
        table th {
            text-align: right;
            background: #444444;
            color: #fff;
            padding-right: 10px;
        }
        td {
            padding-right: 10px;
        }
        td.totalQty {
            background: gray !important;
            color: white !important;
        }
    </style>
    <header>
        <body>

        <div class="container" >

            <div class="row">
                <div class="col-md-8 pull-right"> </div>
                <div class="col-md-2 pull-right no-print">
                    <button onclick="window.print()" class="btn btn-success" >
                        <i class="fa fa-print"></i>
                        {{ Lang::get('labels.print') }}
                    </button>
                </div>
                <div class="col-md-2 pull-right no-print">
                    <a href="/sell/TakeOutProducts" class="btn btn-primary" >
                        {{ Lang::get('labels.back') }}
                    </a>
                </div>
            </div>
            {{Lang::get('labels.stockRequest_Report')}}
            <?php //echo ' '.$outArray[0]['currentDate'] ?>
            <hr>
            <table border="1" class="">
                <tr>
                    <th >{{Lang::get('labels.id')}}</th>
                    <th>{{Lang::get('labels.partNumber')}}</th>
                    <th>{{Lang::get('labels.Product_title')}}</th>
                    <th>{{Lang::get('labels.QTY')}}</th>
                    <th>{{Lang::get('labels.tadbir_stock_id')}}</th>
                </tr>
                @foreach($val as $v)
                    <tr>
                        <td>{{ $v->ssr_d_product_id}}</td>
                        <td>{{ $v->stkr_prodct_partnumber_commercial }}</td>
                        <td>{{ $v->stkr_prodct_title }} </td>
                        <td>{{ $v->ssr_d_qty  }}    </td>
                        <td>{{ $v->stkr_tadbir_stock_id  }}    </td>
                    </tr>
                @endforeach

                <tr>

                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td class="totalQty"> {{ $TotalQty }} </td>
                    <td> </td>
                </tr>
            </table>
            <hr>
        </div>

        </body>
</html>

