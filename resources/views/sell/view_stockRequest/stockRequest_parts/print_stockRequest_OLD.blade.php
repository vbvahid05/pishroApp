<html>
    <head>
         @include('layouts.parts.head')
    </head>
    <header>
      <style>
            table.StockReq_top_Table
             {
               border: #05017d;
            }
            table.StockReq_top_Table tr td
            {
              padding-right: 10px;
              padding-top: 5px;
              padding-bottom: 5px;
            }

            table th
            {
              background: #05017d;
              color: #fff;
              text-align: center;
              padding-top: 5px;
              padding-bottom: 5px;
          }

          table.StockReq_Main_Table td
          {
            text-align: center;
            font-size: 11px;
            color: #000;
          }

          table.StockReq_Main_Table tr td hr {
    margin-top: 5px !important;
    margin-bottom: 5px !important;
}

          @media print
          {
          table th {
              background-color: #1a4567 !important;
              -webkit-print-color-adjust: exact;
            }
            table th
              {
                color: white !important;
              }

           .no-print, .no-print *
              {
              display: none !important;
              }


        }



      </style>
    <header>
    <body style="background:  #fff !important;">

      <?php
      //print_r($serialnumberData);
      ?>


      <div class="container" >

        <table class="HeadTable">
          <tr>
            <td style="width:  83%;">  <img src="/img/sr_print_logo.png" class="img-responsive" style="width:  100%;"></td>
            <td>
              <div  style="text-align:  center;font-size:  13px;margin-top:  50;">

                   {{ Lang::get('labels.EhrazText') }}
              </div>
            </td>
          </tr>
          <tr>
            <td> </td>
            <td>
                <div>
                        {{ Lang::get('labels.date') }} :
                        {{$RequestData[0]->sel_sr_delivery_date}}
                        <br/>
                          {{ Lang::get('labels.Number') }} : ***
                        <br/>
                        پيوست : ندارد
                        <br/>
                        {{ Lang::get('labels.pageNumber') }} :  ***
                </div>
            </td>
          </tr>
        </table>



      <div class="col-md-12" style="text-align:  center;line-height: 2;font-size:  20;font-weight: bold;margin-bottom:  30px;">
            بسمه تعالي
        <br/>
            صورتجلسه تحويل دستگاه
      </div>

      <table class="StockReq_top_Table" style="width: 100%;" border="">
         <tbody><tr>
             <td style="width:  150px;">فروشنده / مجري :</td>
             <td style="border-left:  0;">{{ Lang::get('labels.pdsco') }} </td>
             <td style="border-right: 0;border-left:  0;">  </td>
             <td style="border-right:  0px;">  </td>
         </tr>
         <tr>
           <td>خريدار / كارفرما :</td>
           <td style="border-left:  0;">
             @if ($RequestData[0]->cstmr_organization ==1)
                   {{ $RequestData[0]->cstmr_name}}   {{ $RequestData[0]->cstmr_family}}
             @else {{ $RequestData[0]->org_name}} @endif
             </td>
           <td style="border-right:  0;border-left:  0;">  </td>
           <td style="border-right:  0;">  </td>
         </tr>
         <tr>
           <td>شماره قرارداد / فاكتور</td>
           <td>{{ $RequestData[0]->sel_sr_pre_contract_number}}</td>
           <td style="width: 140px;text-align: center;">تاريخ :</td>
           <td style="width: 140px;text-align:  center;"> {{ $RequestData[0]->sel_sr_registration_date}}</td>
         </tr>
       </tbody>
   </table>

  <table class="StockReq_Main_Table" style="width: 100%;" border="">
    <tr>
        <th>رديف</th>
        <th>شرح</th>
        <th>شماره سريال</th>
        <th>Part Number</th>
        <th>تعداد</th>
    </tr>
    <?php $i=1; ?>
    @foreach ($RequestData as $RD)
     <tr>
         <td>{{$i++}}</td>
         <td>{{$RD->stkr_prodct_brand_title}} {{$RD->stkr_prodct_type_title}} {{$RD->stkr_prodct_title}}</td>
      <td style="padding-top: 5px;">
          @foreach ($serialnumberData as $SND)
             @if ($RD->ssr_d_product_id == $SND->sl_top_productid)
              {{$SND->stkr_srial_serial_numbers_a}} <br/> {{$SND->stkr_srial_serial_numbers_b}}
               <hr/>
            @endif
          @endforeach
        </td>
         <td>{{$RD->stkr_prodct_partnumber_commercial}}</td>
         <td>{{$RD->ssr_d_qty}}</td>
     </tr>
    @endforeach


  </table>



  <div class="col-md-12" style="margin-top:  80px;">
      <div class="col-md-6 pull-right" >
        نماينده خريدار با امضاي ذيل اين برگه دريافت اقلام فوق را تاييد مينمايد.
        <br/>
        نام و نام خانوادگي : ----------
        <br/>
        واحد فن آوري اطلاعات و انفورماتيك
      </div>
      <div class="col-md-6" style="text-align:  center;">
        سيستمهاي اطلاعاتي پيشرو
        <br/>
        کارشناس فنی                   کارشناس فروش
      </div>
   </div>


  <div class="col-md-12" >
    <img src="/img/sr_print_bt_logo.png" style="width:  100%;margin-top:  45%;">
  </div>


















      </div>
    </body>
</html>
