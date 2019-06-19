<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 30/04/2019
 * Time: 11:32 AM
 */

namespace App\Mylibrary\Sell\Invoice;


class pdf_Style
{
        public function pdf_Css_Style($stng_mainTableFontSize)
        {
                return '<style>
                body {
                direction: rtl;                
                font-family: byekan !important;            
                } 
                .font12
                {
                 font-size: 12px !important;
                }
                
                .fontSizre
                {
                font-size: '.$stng_mainTableFontSize.' px !important;
                }
                
                .font13
                {
                font-size: 13px !important;
                }
                .farsiNumber
                {
                font-family: Koodak !important;
                }
                
                .ltrdir
                {
                    direction: ltr !important;
                    padding-left:5px;
                }
                .rtldir
                {
                    direction: rtl !important;
                    padding-left:5px;
                    text-align: right!important;
                } 
                
                .officeAddress
                {
                    font-size: 13.5px;
                    text-align: center;
                    padding-top: 5px;
                    padding-bottom: 5px;                    
                }
                .invoice_Creator
                {
                
                    display: block;
                    margin:auto;
                    font-size: 13px;
                    font-weight: bold;  
                    text-align: right;
                    border-top: 1px dotted lightgrey;
                    border-bottom: 1px dotted lightgrey;
                    padding-top: 10px;
                    padding-bottom: 10px;    
                    color: gray;
                }
                .invoice_Creator_Cells{
                    width:33.33% !important;
                    font-size: 13px;
                    font-weight: bold;  
                    color: gray;
                }
                
                table {
                border-collapse: collapse;
                }
                
                .trMain {
                border: 1px solid black !important;
                }
                
                .cellBorder
                {
                 border: 1px solid black ;
                }
                .sepratBordr
                {
                    border: 1px solid red;
                    left: 0; 
                    position: absolute;
                    display: block;
                }    
                .txt_center
                {
                text-align: center;
                }   
                </style>';
        }
}