<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 30/04/2019
 * Time: 12:20 PM
 */

namespace App\Mylibrary\Sell\Invoice;


class pdf_setting
{
    protected $mainData;
    public function __construct($data) {
        $InvoiceInfo=$data[0][0];
        $this->mainData =json_decode($InvoiceInfo->si_pdf_settings,'true');
    }

    public function sting_custommerName( )
        {
            if (count($this->mainData)) {
                foreach ($this->mainData as $IVsetting) {
                    foreach ($IVsetting AS $key => $value) {
                        if ($key == 'stng_customerName') {
                            return true;
                        }
                    }
                }
            }
        }

        public function stng_changeDirection( )
        {
            if (count($this->mainData)) {
                foreach ($this->mainData as $IVsetting) {
                    foreach ($IVsetting AS $key => $value) {
                        if ($key == 'stng_changeDirection') {
                            return true;
                        }
                    }
                }
            }
        }


      public function stng_UserAddress( )
        {
            if (count($this->mainData)) {
                foreach ($this->mainData as $IVsetting) {
                    foreach ($IVsetting AS $key => $value) {
                        if ($key == 'stng_UserAddress') {
                            return true;
                        }
                    }
                }
            }
        }

     public function stng_Price( )
            {
                if (count($this->mainData)) {
                    foreach ($this->mainData as $IVsetting) {
                        foreach ($IVsetting AS $key => $value) {
                            if ($key == 'stng_Price') {
                                return true;
                            }
                        }
                    }
                }
            }






    public function stng_mainTableFontSize( )
    {
        if (count($this->mainData)) {
            foreach ($this->mainData as $IVsetting) {
                foreach ($IVsetting AS $key => $value) {
                    if ($key == 'stng_mainTableFontSize') {
                        return $value;
                    }

                }
            }
        }
    }

    public function stng_Desc_fontSize( )
    {
        if (count($this->mainData)) {
            foreach ($this->mainData as $IVsetting) {
                foreach ($IVsetting AS $key => $value) {
                    if ($key == 'stng_Desc_fontSize') {
                        return $value;
                    }

                }
            }
        }
    }



    public function space_date_To_sellerInfo( )
        {
            if (count($this->mainData)) {
                foreach ($this->mainData as $IVsetting) {
                    foreach ($IVsetting AS $key => $value) {
                        if ($key == 'space_date_To_sellerInfo') {
                            return $value;
                        }else
                            return 1;
                    }
                }
            }
        }

         public function space_seller_To_InvoiceTable( )
        {
            if (count($this->mainData)) {
                foreach ($this->mainData as $IVsetting) {
                    foreach ($IVsetting AS $key => $value) {
                        if ($key == 'space_seller_To_InvoiceTable') {
                            return $value;
                        }else
                            return 1;

                    }
                }
            }
        }


    public function space_InvoiceTable_To_DescriptionTable( )
    {
        if (count($this->mainData)) {
            foreach ($this->mainData as $IVsetting) {
                foreach ($IVsetting AS $key => $value) {
                    if ($key == 'space_InvoiceTable_To_DescriptionTable') {
                        return $value;
                    }else
                        return 1;
                }
            }
        }
    }






}
