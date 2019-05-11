<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 30/04/2019
 * Time: 12:02 PM
 */

namespace App\Mylibrary\Sell\Invoice;
use \App\Http\Controllers\PublicController;
use App\Mylibrary\PublicClass;
use App\Mylibrary\NumberToString;

class pdf_headerFooterDesc
{
    protected $InvoiceInfo;
    protected $productList;
    protected $invoiceTolalInfo;

    protected $stng_customerName;
    protected $stng_changeDirection;
    protected $stng_UserAddress;
    protected $stng_Price;

    protected $stng_header_To_InvoiceBody;
    protected $stng_date_To_sellerInfo;
    protected $stng_seller_To_InvoiceTable;
    protected $stng_InvoiceTable_To_DescriptionTable;
    protected $stng_signature_Table_height;
    protected $stng_mainTableFontSize;
    protected $stng_Desc_fontSize;

    protected $verified_By="";

    public function __construct($data) {
        $this->InvoiceInfo=$data[0][0];
        $this->productList=$data[1];
        $this->invoiceTolalInfo=$data[2];

        $this->space_seller_To_InvoiceTable=1;

        $invoice_Setting=json_decode($this->InvoiceInfo->si_pdf_settings,'true');
        if (count($invoice_Setting))
        {
            foreach ($invoice_Setting as $IVsetting)
            {
                foreach ($IVsetting AS $key=>$value)
                {
                    switch ($key)
                    {
                        case 'stng_customerName':
                            $this->stng_customerName=true;
                            break;
                        case 'stng_changeDirection':
                            $this->stng_changeDirection=true;
                            break;
                        case 'stng_UserAddress':
                            $this->stng_UserAddress=true;
                            break;
                        case 'stng_Price':
                             $this->stng_Price=true;
                            break;

                        case 'stng_header_To_InvoiceBody':

                            $this->stng_header_To_InvoiceBody=$value;
                            break;
                        case 'stng_date_To_sellerInfo':
                            $this->space_date_To_sellerInfo=$value;
                            break;
                        case 'stng_seller_To_InvoiceTable':
                              $this->space_seller_To_InvoiceTable=$value;
                            break;
                        case 'stng_InvoiceTable_To_DescriptionTable':
                            $this->space_InvoiceTable_To_DescriptionTable=$value;
                            break;
                        case 'stng_signature_Table_height':
                            $this->stng_signature_Table_height=$value;
                            break;
                        case 'stng_mainTableFontSize':
                            $this->stng_mainTableFontSize=$value;
                            break;
                        case 'stng_Desc_fontSize':
                            $this->stng_Desc_fontSize=$value;
                            break;
                    }
                }
            }
        }
    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        public function get_header()
        {
            $dateConvert=new PublicClass();
            $codeghtesadi=\Lang::get('labels.codeghtesadi'); $codeEghtesadiPishro= \Lang::get('labels.codeEghtesadiPishro');$date= \Lang::get('labels.date'); $Number=\Lang::get('labels.Number');$invoiceSalesExpert=\Lang::get('labels.invoiceSalesExpert');$invoice_seller=\Lang::get('labels.invoice_seller');$address2=\Lang::get('labels.address2');$Orders_row=\Lang::get('labels.Orders_row');$Product_title=\Lang::get('labels.Product_title');$QTY=\Lang::get('labels.QTY');$invoice_Unit_price=\Lang::get('labels.invoice_Unit_price');$invoice_Total_Price=\Lang::get('labels.invoice_Total_Price');$invoice_Info=\Lang::get('labels.invoice_Info');$tel=\Lang::get('labels.tel');
            $Totalsummery=\lang::get('labels.Totalsummery');$invoice_Discount= \lang::get('labels.invoice_Discount');$invoice_tax=\lang::get('labels.invoice_tax');$invoice_Total=\lang::get('labels.invoice_Total');$invoice_Description	=\Lang::get('labels.invoice_Description');$invoice_warranty	=\Lang::get('labels.invoice_warranty');$invoice_Payment 	=\Lang::get('labels.invoice_Payment');$invoice_deliveryDate 	=\Lang::get('labels.invoice_deliveryDate');$invoice_Info 		=\Lang::get('labels.invoice_Info');
            $TaxTitle=\lang::get('labels.TaxTitle');$validityDuration=\lang::get('labels.validityDuration');$invoice_delivery_Type=\Lang::get('labels.invoice_delivery_Type');
            $Jdate=$dateConvert->gregorian_to_jalali_byString($this->InvoiceInfo->si_date);

            $mainTitle=" پیش فاکتور فروش";
            $space=10;
            $Separator='<div  style="height: '.$space.'cm " > </div>';
            $pageNum= '<div style="text-align: left; margin-top: -50px">'.'   صفحه  {PAGENO}از{nb}'.'</div>';
            $Separator='<div  style="height: '.$this->stng_header_To_InvoiceBody.'cm " > </div>';

            return '<img src="img/sr_print_logo.png"> '.$pageNum .'
            <h4 style="font-family: byekan; text-align: center ;font-size: 20px"> '.$mainTitle.'</h4>   
            '.
             $Separator.
            '
          <div style="margin-top: -30px" class="row">
                    <div style="width: 60%; float: right;"> </div>
                    <div style="width: 20%; float: left;" >  
                        <div> </div>                      
                        <div> '.$date.'  : <span  class="farsiNumber">'.  $Jdate[0] .'/'. $Jdate[1] .'/'. $Jdate[2] .' </span> </div>
                        <div >'. $Number.'  :  '.$this->InvoiceInfo->si_Alias_id.' </div>                      
                    </div>                
                </div>  
        ';
        }


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  public function get_invoice_info(){
          $invoice_seller=\Lang::get('labels.invoice_seller');
          $codeghtesadi=\Lang::get('labels.codeghtesadi');
          $address2=\Lang::get('labels.address2');
          $tel=\Lang::get('labels.tel');
          $custommerName=($this->stng_customerName ?  '-'.$this->InvoiceInfo->cstmr_name.' '.$this->InvoiceInfo->cstmr_family : "");

          if (!$this->stng_UserAddress) $org_address=$this->InvoiceInfo->org_address;
          else $org_address= '';

      return  '<table class="table" style="width: 100%;font-family: vYekan">
                    <tr  style="border-bottom: 1px solid">
                        <td style="font-weight: bold">'.$invoice_seller .': </td>
                        <td>'.$this->InvoiceInfo->org_name .' '.   $custommerName .'  </td>
                        <td style="font-weight: bold">'.$codeghtesadi .' : </td>
                        <td class="farsiNumber">'.$this->InvoiceInfo->org_codeeghtesadi .'</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">'.$address2 .': </td>
                        <td>'.$org_address.' </td>    
                        <td style="font-weight: bold" >'.$tel .': </td>
                        <td class="farsiNumber">'.$this->InvoiceInfo->org_tel.'</td>
                    </tr>
                </table>';
  }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

     public function get_MainTable(){
        $rowID=1;
        $mainTable='';
        $BGcolor='#f4f4f4';
        $r='';
        $direction=($this->stng_changeDirection ? 'rtldir' : 'ltrdir');

        $codeghtesadi=\Lang::get('labels.codeghtesadi'); $codeEghtesadiPishro= \Lang::get('labels.codeEghtesadiPishro');$date= \Lang::get('labels.date'); $Number=\Lang::get('labels.Number');$invoiceSalesExpert=\Lang::get('labels.invoiceSalesExpert');$invoice_seller=\Lang::get('labels.invoice_seller');$address2=\Lang::get('labels.address2');$Orders_row=\Lang::get('labels.Orders_row');$Product_title=\Lang::get('labels.Product_title');$QTY=\Lang::get('labels.QTY');$invoice_Unit_price=\Lang::get('labels.invoice_Unit_price');$invoice_Total_Price=\Lang::get('labels.invoice_Total_Price');$invoice_Info=\Lang::get('labels.invoice_Info');$tel=\Lang::get('labels.tel');
        $Totalsummery=\lang::get('labels.Totalsummery');$invoice_Discount= \lang::get('labels.invoice_Discount');$invoice_tax=\lang::get('labels.invoice_tax');$invoice_Total=\lang::get('labels.invoice_Total');$invoice_Description	=\Lang::get('labels.invoice_Description');$invoice_warranty	=\Lang::get('labels.invoice_warranty');$invoice_Payment 	=\Lang::get('labels.invoice_Payment');$invoice_deliveryDate 	=\Lang::get('labels.invoice_deliveryDate');$invoice_Info 		=\Lang::get('labels.invoice_Info');
        $TaxTitle=\lang::get('labels.TaxTitle');$validityDuration=\lang::get('labels.validityDuration');$invoice_delivery_Type=\Lang::get('labels.invoice_delivery_Type');

        $mainTable=
            '
                    <tr style="background:lightgray;color:white !important;">
                        <th width="5%">'.$Orders_row.'</th>
                        <th width="38%">'.$Product_title.'</th>
                        <th width="5%">'.$QTY.'</th>
                        <th  width="16%"  style="text-align: center">'.$invoice_Unit_price.'('.$this->InvoiceInfo->sic_Currency.')</th>
                        <th width="19%"  style="text-align: center" >'.$invoice_Total_Price .'('.$this->InvoiceInfo->sic_Currency.')</th>
                        <th width="17%">'.$invoice_Info.'</th>
                    </tr>        
        ';

        $mainTable=$mainTable.'<tr colspan="6" style="background:black"> s</tr>';
        for ($i = 0; $i <= count($this->productList)-1; $i++)
        {
            $SubProductData=$this->productList[$i]['SubProductData'];
            $mainTable=$mainTable.'<tr colspan="6" style="background:black"> s</tr>';
            if ($BGcolor=='#f4f4f4') $BGcolor='#fff'  ;  else $BGcolor='#fff';
            $mainTable=$mainTable.'<tr class="" style="background:'.$BGcolor.'">';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$rowID++.'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre '.$direction.'">'.$this->productList[$i]['product_Title'].'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$this->productList[$i]['qty'].'</td>';

            if (!$this->stng_Price)
            {
                $unitPrice =$this->productList[$i]['Unit_price'];
                $price =$this->productList[$i]['Unit_price'] * $this->productList[$i]['qty'];
            }else
            {
                $unitPrice=0;
                $price=0;
            }


            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="border-top: 1px solid #000;  text-align: center; !important;" >'.PublicController::CurencySeprator($unitPrice).'</td>';
            $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="border-top: 1px solid #000; text-align: center; !important;">'.PublicController::CurencySeprator($price ).'</td>';

            $mainTable=$mainTable.'<td class="cellBorder fontSizre ltrdir" style="text-align: center; !important;">'.$this->productList[$i]['partNumber'].'</td>';
            $mainTable=$mainTable.'</tr>';
            if (count($SubProductData)>0 )
            {
                for ($G = 0; $G <= count($SubProductData)-1; $G++)
                {

                    $mainTable=$mainTable.'<tr style="background:'.$BGcolor.'">';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center; !important;">'.$rowID++.'</td>';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre '.$direction.'" >'.$SubProductData[$G]->product_Title.'</td>';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber"  style="text-align: center; !important;">'.$SubProductData[$G]->qty.'</td>';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center;"> 0 </td>';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre farsiNumber" style="text-align: center;"> 0 </td>';
                    $mainTable=$mainTable.'<td class="cellBorder fontSizre   ltrdir" style="text-align: center; !important;">'.$SubProductData[$G]->partNumber.'</td>';
                    $mainTable=$mainTable.'</tr>';
                }

            }
        }
        return $mainTable;

    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        public function get_desc()
        {
            $invoice_warranty	=\Lang::get('labels.invoice_warranty');
            $invoice_Payment 	=\Lang::get('labels.invoice_Payment');
            $invoice_deliveryDate 	=\Lang::get('labels.invoice_deliveryDate');
            $invoice_delivery_Type=\Lang::get('labels.invoice_delivery_Type');
            $validityDuration=\lang::get('labels.validityDuration');
            $invoice_Description	=\Lang::get('labels.invoice_Description');
            $invoice_Info 		=\Lang::get('labels.invoice_Info');
            $Totalsummery=\lang::get('labels.Totalsummery');
            $invoice_Discount= \lang::get('labels.invoice_Discount');
            $TaxTitle=\lang::get('labels.TaxTitle');
            $invoice_Total_Price=\Lang::get('labels.invoice_Total_Price');
            $invoice_Total=\lang::get('labels.invoice_Total');
            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....



            $n2s=new NumberToString();
            if ($this->InvoiceInfo->si_tax_setting_status) // Add TAX
            {
                if (!$this->stng_Price) {
                    $tax_val = ($this->invoiceTolalInfo['TotalPrice'] - $this->InvoiceInfo->si_Discount) * 0.09;
                    $totalwithtax = $this->invoiceTolalInfo['TotalPrice'] + $tax_val;
                    $TotalPrice =$this->invoiceTolalInfo['TotalPrice'];
                }else{
                    $tax_val=0;
                    $totalwithtax=0;
                    $TotalPrice =0;
                }

            }
            else
            {
                if (!$this->stng_Price){
                    $tax_val=0;
                    $totalwithtax=$this->invoiceTolalInfo['TotalPrice']-$this->InvoiceInfo->si_Discount;
                    $TotalPrice =$this->invoiceTolalInfo['TotalPrice'];
                }else {
                    $totalwithtax=0;
                    $TotalPrice =0;
                }

            }

            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.....
            if ($this->InvoiceInfo->si_warranty != NULL)
            {
                $show_invoice_warranty= $invoice_warranty.$this->InvoiceInfo->si_warranty.'<br/>';
            }

            if ($this->InvoiceInfo->si_Payment != NULL)
            {
                $show_invoice_Payment=$invoice_Payment.$this->InvoiceInfo->si_Payment.'<br/>';
            }

            if ($this->InvoiceInfo->si_deliveryDate != NULL)
            {
                $show_invoice_si_deliveryDate=$invoice_deliveryDate.$this->InvoiceInfo->si_deliveryDate.'<br/>';
            }

            if ($this->InvoiceInfo->si_delivery_type != NULL)
            {
                $show_invoice_si_delivery_type=$invoice_delivery_Type.':'.$this->InvoiceInfo->si_delivery_type.'<br/>';
            }

            if ($this->InvoiceInfo->si_validityDuration != NULL)
            {
                $show_invoice_validityDuration=$validityDuration.':'.$this->InvoiceInfo->si_validityDuration.'<br/>';
            }

            if ($this->InvoiceInfo->si_warranty != NULL ||
                $this->InvoiceInfo->si_Payment != NULL ||
                $this->InvoiceInfo->si_deliveryDate != NULL  ||
                $this->InvoiceInfo->si_delivery_type != NULL  ||
                $this->InvoiceInfo->si_validityDuration != NULL)
                $show_invoice_Description ='<span style="padding-bottom: 20px;font-weight: bold; text-decoration: underline ;">'.$invoice_Description.'</span><br/>';


           $invoice_Result='

  
     <tr>
        <td colspan="3" style="height: 3px;">  </td>
      </tr>
     <tr>
                        <td  style="vertical-align:top" colspan="3" rowspan="5">'.
                $show_invoice_Description.
                '<div style="height: 3mm !important;color: #fff;font-size: 5px">.</div>'.
                $show_invoice_warranty.
                $show_invoice_Payment.
                $show_invoice_si_deliveryDate.

                $show_invoice_validityDuration.
                '</td>
                        <td class="cellBorder">'.$Totalsummery.'</td>
                        <td class="cellBorder farsiNumber txt_center">'.PublicController::CurencySeprator($TotalPrice).' </td><td></td>
                    </tr>
                    <tr>
                        
                        <td class="cellBorder">'.$invoice_Discount.'</td>
                        <td class="cellBorder farsiNumber txt_center">'.PublicController::CurencySeprator($this->InvoiceInfo->si_Discount) .'</td><td></td>
                    </tr>
                    <tr>                        
                        <td class="cellBorder">'.$TaxTitle .'  </td>
                        <td class="cellBorder farsiNumber txt_center" >'.
                PublicController::CurencySeprator($tax_val ).

                ' </td><td></td>
                    </tr>
                    <tr>                        
                        <td class="cellBorder" style="background: black  !important;color: #fff !important;">'.$invoice_Total.' </td>
                        <td class="cellBorder farsiNumber txt_center" >'.PublicController::CurencySeprator($totalwithtax) .'</td>
                        <td></td>
                    </tr>
                     <tr>                        
                        <td colspan="4" > '.  $n2s->digit_to_persain_letters($totalwithtax).' '.$this->InvoiceInfo->sic_Currency.''.' </td>
                        
                        
                    </tr>
   </table>
    ';
            $show_Description='';
            if ($this->InvoiceInfo->si_Description !=null)
            {
                $show_Description='
                <hr/>
             <div style="font-weight: bold;width: 20% ;text-decoration: underline">'.$invoice_Info.': </div>
                <div style="width: 100% ;text-align: justify ;font-size: '.$this->stng_Desc_fontSize.'px ">'.$this->InvoiceInfo->si_Description.'</div>
            ';
            }


//            $invoice_information_Descriptions='
//                  <table  style=" width: 100%;height: 150px;">
//                 '.$show_invoice_Description.'
//                 '.$show_invoice_warranty.'
//                 '.$show_invoice_Payment.'
//                 '.$show_invoice_si_deliveryDate.'
//                 '.$show_invoice_validityDuration.'
//                  </table>
//                 '.$show_Description.'' ;

            return $invoice_Result.$show_Description;
        }


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_footer()
    {
        $officeAddress=\Lang::get('labels.officeAddress'); $webSiteURL=\Lang::get('labels.webSiteURL'); $Tel=\Lang::get('labels.Tel');
        $invoiceSeller=\Lang::get('labels.invoiceSeller');  $invoiceSalesExpert=\Lang::get('labels.invoiceSalesExpert');$invoiceVerifiedBy=\Lang::get('labels.invoiceVerifiedBy');
        if ($this->stng_signature_Table_height)
            $Table_height=$this->stng_signature_Table_height;
        else
            $Table_height=90;

        return '<table style="width: 100% ;   border: 1px solid gray;"  >
                <tr >
                    <td class="invoice_Creator_Cells" style="vertical-align:top ;border-left: 1px solid gray" height="'.$Table_height.'">'.$invoiceSalesExpert.' : '.$this->invoiceTolalInfo['CreatedBy'].'</td>
                    <td class="invoice_Creator_Cells" style="vertical-align:top;border-left: 1px solid gray" height="'.$Table_height.'">' .$invoiceVerifiedBy.':'.$this->verified_By.'</td>
                    <td class="invoice_Creator_Cells" style="vertical-align:top;border-left: 1px solid gray" height="'.$Table_height.'">' .$invoiceSeller.':</td>
                </tr>                      
               </table>                                                                     
               <img style="margin-top: 10px " src="img/footer.png">';
    }


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}