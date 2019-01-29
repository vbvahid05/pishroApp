<?php
use app\Http\Controllers\Sell\SellController;
?>
<html>
    <head>
         @include('layouts.parts.head')
    </head>
    <header>
      <style>
          .Page {
          height: 1550px !important;
          }
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

          .MainTableContiner_Page1 {
              height: 675px;
          }
          .MainTableContiner_OtherPage {
              height: 900px;
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
.Insidetable{
    width: 100%;
}
          .Insidetable td {
              border: 1px solid;
          }
          td.title {
              border-left: 0;
          }

          td.value {
              border-right: 0;
              width: 50%;
          }

          @page {
              size: A4;
              /*margin: 30mm 0mm 0mm 30mm;*/
          }
          @media print
          {
              table th
                {
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
           .col-md-4{
               width: 33.33% !important;
               position: relative;
               min-height: 1px;
               padding-right: 15px;
               padding-left: 15px;
           }

        }



      </style>
  <header>
  <body style="background:  #fff !important;">
    <div class="container" >
      <?php
//-------------------------------
          $AllRecords= count($serialnumberData) ;
          //$AllRecords=40;
          $page1rows=20;  //  20*35px=700px MainTable size
          if ( ($AllRecords/$page1rows) <1 ) $totalPage=1;
          else if (($AllRecords/$page1rows)>=1) $totalPage= round($AllRecords/$page1rows);
//-------------------------------
        $ix=1
//          for ($ix=1;$ix<=$totalPage;$ix++)
//          {
            //#####################################################
            ?>
            <div class="Page"  >

              <table class="HeadTable" style="display: block">
                <tr>
                  <td style="width:  83%;">  <img src="/img/sr_print_logo.png" class="img-responsive" style="width:  100%;"></td>
                  <td>
                    <div  style="text-align:  center;font-size:  13px;margin-top:  50;">{{ Lang::get('labels.EhrazText') }}</div>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                      <div>
                              {{ Lang::get('labels.date') }} :

                                {{--{{$delivery_date}}--}}
                              {{--<br/>--}}
                                {{--{{ Lang::get('labels.Number') }} : ***--}}
                              {{--<br/>--}}
                              {{--پيوست : ندارد--}}
                              {{--<br/>--}}
                              {{--{{ Lang::get('labels.pageNumber') }} :   {{$ix}}--}}
                      </div>
                  </td>
                </tr>
              </table>
         @if ($ix ==1 )
                  <div class="col-md-12" style="text-align:  center;line-height: 2;font-size:  20;font-weight: bold;margin-bottom:  30px;    margin-top: -110px;">
                         {{ Lang::get('labels.NameOfGod') }}<br/>{{ Lang::get('labels.stockRequestTilte') }}
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
                       <td style="width: 140px;text-align:  center;"> {{ $registration_date}}</td>
                     </tr>
                   </tbody>
                 </table>
           @endif




        <div   class= <?php if ($ix ==1) echo '"MainTableContiner_Page1"' ;else echo '"MainTableContiner_OtherPage"';  ?>    >
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
                        <td valign="top"   style="width: 11%;font-size: 15px !important;">{{$RD->stkr_prodct_brand_title}} {{$RD->stkr_prodct_type_title}} {{$RD->stkr_prodct_title}}</td>
                        <td style="padding-top: 5px">
                                <?php
                                $serial=\App\Http\Controllers\Sell\SellController::ChassisSerialNumbers($RD->stkreqdeta_id);
                                $products= \App\Http\Controllers\Sell\SellController::subChassisPartsAndSerialNumbers($RD->stockrequestsid,$RD->stkreqdeta_id)
                                ?>
                                    <table class="Insidetable" >
                                        <tr>
                                            <td>
                                                <h5>
                                                    <table>
                                                    <?php
                                                     $igg=0;
                                                     $n=3;
                                                    foreach($serial as $sn)
                                                    {
                                                        if  ($igg%$n ==1 )
                                                        echo '<tr>';
                                                            echo '<td style="border: 0">';
                                                            $SN=explode("@",$sn->stkr_srial_serial_numbers_a);
                                                            if (count($SN) >=2 &&  ($SN[0] =='noserial' || $SN[0] =='nosrial')  )
                                                                echo '';
                                                            else
                                                                 echo $sn->stkr_srial_serial_numbers_a.'  __  '.
                                                                      $sn->stkr_srial_serial_numbers_b;
                                                            echo '<td>';
                                                        if  ($igg%$n ==1 )
                                                        echo '</tr>';

                                                        $igg++;
                                                    }

                                                    ?>
                                                    </table>
                                                </h5>
                                            </td>

                                            <td>
                                                @if ($RD->stkr_prodct_type_cat==3)
                                                    Chassis
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $prodct_title="";?>
                                        @foreach ($products as $prdcs)
                                            <tr>
                                                <td class="value">
                                                    <?php
                                                      $SN=  explode("@", $prdcs->stkr_srial_serial_numbers_a);
                                                      if (count($SN) >=2 && $SN[0] =='noserial' || $SN[0] =='nosrial' || $SN[0] =='norserial'  )
                                                        echo '';
                                                      else {
                                                          ?>
                                                        {{$prdcs->stkr_srial_serial_numbers_a}} <br/>
                                                        {{$prdcs->stkr_srial_serial_numbers_b}}
                                                        <?php
                                                          }
                                                        ?>
                                                </td>
                                                <td class="title" @if($prodct_title ==$prdcs->stkr_prodct_title) <?php  echo 'style="border: 0 !important;"'?>  @endif>

                                                    @if($prodct_title !=$prdcs->stkr_prodct_title)
                                                        {{  $prdcs->stkr_prodct_title }}
                                                        <?php $prodct_title=$prdcs->stkr_prodct_title;?>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>


                        </td>
                        <td>{{$RD->stkr_prodct_partnumber_commercial}}</td>
                        <td>{{$RD->ssr_d_qty}}</td>
                    </tr>
                @endforeach
           </table>
        </div>
















<!--  Sub Page-->
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

           <div class="col-md-12" style="display: block">
             <img src="/img/sr_print_bt_logo.png" style="width:  100%;">
           </div>



            </div>
          <?php
          //#####################################################
    //     }//End For



      ?>
    </div>
    </div>
  </body>

</html>
