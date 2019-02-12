<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 20/10/2018
 * Time: 01:03 PM
 */

namespace App\Mylibrary\Sell\Stock_Request;

use App\Http\Controllers\Sell\SellController;
class makePdf
{
    function  ContentType_C($RequestData,$Pdfsetting)
    {
     ($Pdfsetting->mainTableFontSize !=null)? $mainTable_FontSize='font-size:'.$Pdfsetting->mainTableFontSize.'px':$mainTable_FontSize='font-size: 12px';
     ($Pdfsetting->SerialNumberFontSize !=null)? $SN_FontSize='font-size:'.$Pdfsetting->SerialNumberFontSize.'px':$SN_FontSize='font-size: 12px';

        $counter=0; $content="";

        foreach ($RequestData AS $RD)
        {
            $counter++;
            $serial=new SellController();
            $serial = $serial->ChassisSerialNumbers($RD->stkreqdeta_id);

            $products=new SellController();
            $products = $products->subChassisPartsAndSerialNumbers($RD->stockrequestsid, $RD->stkreqdeta_id);
            $content= $content.'<br/>';
            $content = $content .'<div style="border: 2px solid gray">';
            $content= $content.'<table style="width:100%;display: block;">';
            $content= $content.'<tr style="background:lightgrey;">';
            $content= $content. '<th> ردیف'  .'</th>';
            $content= $content. '<th> شرح'.'</th>';
            $content= $content. '<th>پارتنامبر' .'</th>';
            $content= $content. '<th> تعداد'.'</th>';
            $content= $content.'</tr>';

            $content= $content.'<tr>';
            $content= $content.
                '<td class="farsiNumber" style="text-align: center ; font-weight: bold;'.$mainTable_FontSize.'"> '. $counter .'</td>'.
                '<td style="text-align: left;'.$mainTable_FontSize.'">'.$RD->stkr_prodct_brand_title.' '.
                $RD->stkr_prodct_type_title.' '.
                $RD->stkr_prodct_title.'</td>'.
                '<td style="text-align: center;'.$mainTable_FontSize.'">'.$RD->stkr_prodct_partnumber_commercial.'</td>' .
                '<td class="farsiNumber" style="text-align: center;'.$mainTable_FontSize.'"> '.$RD->ssr_d_qty.'</td>';
            $content= $content.'</tr>';
            $content= $content.'</table>';
            $content= $content.'<hr/>';
            $content= $content.'<br/>';


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

            $oldProductTitle='';
            $countRows=0;

            $content = $content . '<table border="0"  style="width: 100%">';
            $content = $content . '<tr style="border-bottom: 1px solid gray">';
            if ($RD->stkr_prodct_type_cat == 3) $title='شرح ' ; else $title='';
                $content = $content . '<td style="width: 50%; text-align: left;border-bottom: 1px dotted gray">'.$title.'</td>';
                $content = $content . '<td  style="border-bottom: 1px dotted gray"> سریال نامبر</td>';
                $content = $content . '<td></td>';
            $content = $content . '</tr>';
            $SN1="";
            foreach($serial as $sn)
            {
                $countRows++;
                if ($RD->stkr_prodct_title != $oldProductTitle) {
                    $ptitle = $RD->stkr_prodct_title;
                    $oldProductTitle = $RD->stkr_prodct_title;
                } else $ptitle = '';
               if ($SN1 !='--')
               {
                   $content = $content .
                       '<tr>';
                   if ($RD->stkr_prodct_type_cat == 3) $catType = 'Chassis  '; else $catType = '';
                   $content = $content .
                       '<td style="text-align:left ;">' . $catType . '</td>';
                   $SN = explode("@", $sn->stkr_srial_serial_numbers_a);
                   if (count($SN) >= 2 && $SN[0] == 'noserial' || $SN[0] == 'nosrial' || $SN[0] == 'norserial')
                   {
                       $SN1 = '--';
                   }
                   else
                       $SN1 = $sn->stkr_srial_serial_numbers_a ;
                   //.........
                   if ($sn->stkr_srial_serial_numbers_b != null)
                       $SN2 = ' / '.$sn->stkr_srial_serial_numbers_b;
                   else
                       $SN2 = ' ';

                       $content = $content .
                           '<td style="'.$SN_FontSize.'">' . $SN1  . $SN2 .'</td>';

                   $content = $content .
                       '</tr>';
               }

            }

            $content = $content . '</table>';

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

            if (count($products)>0) {
                $content = $content .
        '<table border="1px"  style="width: 100%">';
            }
            $oldTitle="";
            $i=0;
            foreach ($products as $prdcs)
            {

                if ($i%2==0) $backColor="#f4f4f4";else $backColor="#fff";
                $content= $content.
               '<tr  style="background: '.$backColor.'  ">';
                  $i++;
                if ($oldTitle !=$prdcs->productsID)
                {
                    $partnumber= $prdcs->stkr_prodct_partnumber_commercial;
                    $prodct_title=$prdcs->stkr_prodct_title;
                    $oldTitle =$prdcs->productsID;
                }
                else
                {
                    $partnumber='';
                    $prodct_title='';
                }

                $content= $content.'<td style="width: 25%; font-size: 12px; text-align: center;"> '.$partnumber.' </td>';
                $content= $content.'<td style="width: 25%; font-size: 10px; text-align: left">'.$prodct_title.' </td>';
                //............
                $SN = explode("@", $prdcs->stkr_srial_serial_numbers_a);
                if (count($SN) >= 2 && $SN[0] == 'noserial' || $SN[0] == 'nosrial' || $SN[0] == 'norserial')
                    $sn = '';
                else
                    $sn = $prdcs->stkr_srial_serial_numbers_a . '<br/>' . $prdcs->stkr_srial_serial_numbers_b;
                //............
                $content = $content . '<td style="'.$SN_FontSize.'">' . $sn . '</td>';
                $content= $content.'<td></td>';

                //---------------------

//                  if (count($SN) >=2 && $SN[0] =='noserial' || $SN[0] =='nosrial' || $SN[0] =='norserial'  )
//                    $content= $content.'<td style="width: 60%"></td>';
//                  else
//                    $content= $content.'<td style="width: 60%;text-align: left">'.$prdcs->stkr_srial_serial_numbers_a .'<br/>'.$prdcs->stkr_srial_serial_numbers_b.'</td>';
//                //---------------------
//                  if ($oldTitle !=$prdcs->stkr_prodct_title)
//                    $content= $content.'<td style="width: 40% ;text-align: left ;padding-right: 20px">'.
//                        $prdcs->stkr_prodct_title.'__'.$prdcs->stkr_prodct_partnumber_commercial.' </td>';
//                  else
//                    $content= $content.'<td style="width: 40%"></td>';
//                //---------------------
//                  $content= $content.
//                '</tr>';
//


            }
            $content= $content.
           '</table>';
            $content = $content .'</div>';
            //------------------------------------
//            $content= $content.'<hr/>';
        }
        return $content;
    }



////////////////////////////////////////////////////////////
    function  ContentType_A($RequestData)
    {
        $content_Table= '<div> <table style="width: 170% ;" >';
        $i=0;$reS=""; $SN="";$SubSN="" ;$line=0;
        foreach ($RequestData AS $RD)
        {
            $serial=new SellController();
            $serial = $serial->ChassisSerialNumbers($RD->stkreqdeta_id);

            $products=new SellController();
            $products = $products->subChassisPartsAndSerialNumbers($RD->stockrequestsid, $RD->stkreqdeta_id);

            if($RD->stkr_prodct_type_cat==3) $PartCatType='Chassis'; else $PartCatType='';

            $SN=$SN.
                '<tr style="background:yellow;font-size: 20cm !important; ">';
            $SN=$SN.'<td class="value">';


            foreach ($serial as $sn)
            {

                $SN=$SN.$sn->stkr_srial_serial_numbers_a . '  -  ' . $sn->stkr_srial_serial_numbers_b;
            }
            $SN=$SN.'</td>';
            $SN=$SN.'<td class="title">';
            $SN=$SN.$PartCatType;
            $SN=$SN.'</td>';
            $SN=$SN.
                '</tr>';

            foreach ($products as $prdcs)
            {
                $SubSN=
                    '<tr>';
                $SubSN=$SubSN.'<td class="value">';
                $SubSN=$SubSN.$prdcs->stkr_srial_serial_numbers_a.'<br/>'.$prdcs->stkr_srial_serial_numbers_b;
                $SubSN=$SubSN.'</td>';
                $SubSN=$SubSN.'<td class="title">';
                $SubSN=$SubSN.$prdcs->stkr_prodct_title;
                $SubSN=$SubSN.'</td>';
                $SubSN=$SubSN.
                    '</tr>';
            }


            $reS=$reS.'<tr>';
            $reS=$reS.'<td width="1cm"  valign="top"  style="border-bottom: 1px solid #b0b0b0;text-align: center">'.++$i.'</td>';
            $reS=$reS.'<td width="3cm" valign="top"  style="border-bottom: 1px solid #b0b0b0;text-align: center">'.
                $RD->stkr_prodct_brand_title.' '.$RD->stkr_prodct_type_title.' '.$RD->stkr_prodct_title.'</td>';
            $reS=$reS.'<td width="30%" valign="top"  style="border-bottom: 1px solid #b0b0b0;text-align: center">'.

                '<table style="font-size: 14px!important;" class="Insidetable"> <tr> <td>'.$SN.'</td> <td>'.$SubSN.'</td></tr>'.
//                         $SN.
//                         $SubSN.
                '</table>'.

                '</td>';

            $reS=$reS.'<td width="20%" valign="top" style="border-bottom: 1px solid #b0b0b0;text-align: center">'.
                $RD->stkr_prodct_partnumber_commercial.'</td>';
            $reS=$reS.'<td width="1cm"  valign="top"  style="border-bottom: 1px solid #b0b0b0;text-align: center">'.
                $RD->ssr_d_qty.'</td>';
            $reS=$reS.'</tr>';
            $SN="";
        }
        return $content_Table=$content_Table.$reS.'</table></div>';
    }
//////////////////////////////
//-----------------------------------------
    function  ContentType_B($RequestData)
    {
        $ic=1;$content_Table2="";
        foreach ($RequestData AS $RD)
        {
            $SN="<td>";$SubSN="";

            $serial=new SellController();
            $serial = $serial->ChassisSerialNumbers($RD->stkreqdeta_id);

            $products=new SellController();
            $products = $products->subChassisPartsAndSerialNumbers($RD->stockrequestsid, $RD->stkreqdeta_id);

            if ($RD->stkr_prodct_type_cat == 3) $PartCatType = 'Chassis'; else $PartCatType = '';
//---------------------------------------
            $SN1="<td>";$SN2="<td>";$SN3="<td>";$SN4="<td>";$SN5="<td>";$SN6="<td>";

            if (count($serial) <=49)
            {
                foreach ($serial as $sn)
                {
                    $jc=1;
                    $separate="/";
                    $SN=$SN.'&nbsp;&nbsp;&nbsp;['.$sn->stkr_srial_serial_numbers_a .'&nbsp;'.$separate.' &nbsp;'.$sn->stkr_srial_serial_numbers_b.']&nbsp;&nbsp;&nbsp; <br/>' ; //. '  ' . .'/ '
                    if ($jc==2)
                    {
                        $SN=$SN.'<br/>';
                        $jc=1;
                    }
                    else
                        $jc++;
                }
            }
            else
            {
                $baseCount=50;
                $cnt=count($serial)/$baseCount;
                for ($xc=1 ;$xc<=$cnt ; $xc++)
                {
                    $topValue= $baseCount*$xc;
                    $jc=1;
                    for( $icn=$topValue-$baseCount ; $icn<=$topValue; $icn++)
                    {
                        switch ($xc)
                        {
                            case 1:
                                $SN1=$SN1.' [  CNT:'.$cnt .'$xc'.$xc.'$topValue'.$topValue .'$icn'.$icn.  $serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] <br/>' ;
                                break;
                            case 2:
                                $SN2=$SN2.' [ '.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] <br/>' ;
                                break;
                            case 3:
                                $SN3=$SN3.' [ '.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] ' ;
                                break;
                            case 4:
                                $SN4=$SN4.' [ '.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] ' ;
                                break;
                            case 5:
                                $SN5=$SN5.' [ '.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] ' ;
                                break;
                            case 6:
                                $SN6=$SN6.' [ '.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.' ] ' ;
                                break;
                        }

                        if ($jc==2)
                        {
                            //$tempSN=$tempSN.'<hr/>';
                            $jc=1;
                        }
                        else
                            $jc++;
                    }
                    if ($SN1 !="")  $SN1=$SN1.'#################</td>';
                    if ($SN2 !="")  $SN2=$SN2.'$$$$$$$$$$$$$$$$$$</td>';
                    if ($SN3 !="")  $SN3=$SN3.'</td>';
                    if ($SN4 !="")  $SN4=$SN4.'</td>';
                    if ($SN5 !="")  $SN5=$SN5.'</td>';
                    if ($SN6 !="")  $SN6=$SN6.'</td>';
                }


            }
            $SN1=$SN1.$SN2;

//
//    $jc=0;
//     if (count($serial) <=40)
//    {
//        foreach ($serial as $sn)
//        {
//            $jc=1;
//            $separate="/";
//            $SN=$SN.'&nbsp;&nbsp;&nbsp;['.$sn->stkr_srial_serial_numbers_a .'&nbsp; '.$separate.' &nbsp;'.$sn->stkr_srial_serial_numbers_b.']&nbsp;&nbsp;&nbsp;' ; //. '  ' . .'/ '
//            if ($jc==2)
//            {
//                $SN=$SN.'<br/>';
//                $jc=1;
//            }
//            else
//                $jc++;
//        }
//    }
//
//    else
//    {
//        $jc=1;
//        $SN=$SN.'<br/>';
//        for( $icn=0 ; $icn<=50; $icn++)
//        {
//            $SN=$SN.'['.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.']&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
//            if ($jc==2)
//            {
//                $SN=$SN.'<hr/>';
//                $jc=1;
//            }
//            else
//                $jc++;
//        }
//
//        $SN2="";
//        $SN2=$SN2.'<br/>';
//        for( $icn=0 ; $icn<=50; $icn++)
//        {
//            $SN2=$SN2.'['.$serial[$icn]->stkr_srial_serial_numbers_a .'&nbsp; / &nbsp;'.$serial[$icn]->stkr_srial_serial_numbers_b.']&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
//            if ($jc==2)
//            {
//                $SN2=$SN2.'<hr/>';
//                $jc=1;
//            }
//            else
//                $jc++;
//        }
//    }

            $SN=$SN.'</td>';
            $SN=$SN.'<td class="title">';
            $SN=$SN.$PartCatType;
            $SN=$SN.'</td>';
            ;

            foreach ($products as $prdcs)
            {
                $SubSN=
                    '<tr>';
                $SubSN=$SubSN.'<td class="value">';
                $SubSN=$SubSN.$prdcs->stkr_srial_serial_numbers_a.'<br/>'.$prdcs->stkr_srial_serial_numbers_b;
                $SubSN=$SubSN.'</td>';
                $SubSN=$SubSN.'<td class="title">';
                $SubSN=$SubSN.$prdcs->stkr_prodct_title;
                $SubSN=$SubSN.'</td>';
                $SubSN=$SubSN.
                    '</tr>';

            }
//---------------------------------------
            $content =
                '<table border="1" style="width:100%">
            <tr>
                <td>رديف : '.$ic++.'</td>
                <td> شرح :'.$RD->stkr_prodct_brand_title.' '.$RD->stkr_prodct_type_title.' '.$RD->stkr_prodct_title.'</td>
                <td> پارت نامبر :'.$RD->stkr_prodct_partnumber_commercial.'</td>
                <td>تعداد '.$RD->ssr_d_qty.' </td>
            </tr>
            <tr>
                <td colspan="4">
                  <table style="font-size: 14px!important;" class="Insidetable">
                      <tr>
                          '.$SN .$SN1.$SN2.$SN3.$SN4.$SN5.$SN6.'
                          <td>'.$SubSN.'</td>
                      </tr>
                  </table>
                </td>
            </tr>
        </table> <br/>';
            $content_Table2= $content_Table2. $content;
        }
        return $content_Table2;
    }





//////////////////////////////
}
