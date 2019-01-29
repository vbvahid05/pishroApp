<?php
/**
 * Created by PhpStorm.
 * User: v.barzegar
 * Date: 18/11/2018
 * Time: 11:45 AM
 */

namespace App\Mylibrary;


class NumberToString
{
    protected static $numString = array(
        'fa'=>array(
            'strn'=>array('0'=>'','1'=>'یک','2'=>'دو','3'=>'سه','4'=>'چهار','5'=>'پنج','6'=>'شش','7'=>'هفت','8'=>'هشت','9'=>'نه','10'=>'ده','11'=>'یازده','12'=>'دوازده','13'=>'سیزده','14'=>'چهارده','15'=>'پانزده','16'=>'شانزده','17'=>'هفده','18'=>'هیجده','19'=>'نوزده','20'=>'بیست','30'=>'سی','40'=>'چهل','50'=>'پنجاه','60'=>'شصت','70'=>'هفتاد','80'=>'هشتاد','90'=>'نود','100'=>'صد','200'=>'دویست','300'=>'سیصد','400'=>'چهارصد','500'=>'پانصد','600'=>'ششصد','700'=>'هفتصد','800'=>'هشتصد','900'=>'نهصد'),
            'index'=>array('0'=>'','and'=>'و ','neg'=>'منفی','zero'=>'صفر','3'=>'هزار','6'=>'میلیون','9'=>'میلیارد','great'=>'ما سوادمون به این عدد نمیرسه :دی')
        ),
        'en'=>array(
            'strn'=>array('0'=>'','1'=>'one','2'=>'two','3'=>'three','4'=>'four','5'=>'five','6'=>'six','7'=>'seven','8'=>'eight','9'=>'nine','10'=>'ten','11'=>'elevlen','12'=>'twelve','13'=>'thirteen','14'=>'fourteen','15'=>'fifteen','16'=>'sixteen','17'=>'seventeen','18'=>'eighteen','19'=>'nineteen','20'=>'twenty','30'=>'thirty','40'=>'fourty','50'=>'fifty','60'=>'sixty','70'=>'seventy','80'=>'eighty','90'=>'ninety','100'=>'hundred','200'=>'two hundred','300'=>'three hundred','400'=>'four hundred','500'=>'five hundred','600'=>'six hundred','700'=>'seven hundred','800'=>'eight hundred','900'=>'nine hundred'),
            'index'=>array('0'=>'','and'=>'and','neg'=>'negative','zero'=>'zero','3'=>'Thousand','6'=>'million','9'=>'billion','great'=>'Oops! really big number')
        )
    );
    private function n2s($n,$lang = 'fa')
    {
        $n = (int)$n;
        $s = '';
        if($lang == 'en')
            $and = '';
        else
            $and = self::$numString[$lang]['index']['and'];
        if(isset(self::$numString[$lang]['strn'][$n]))
            return self::$numString[$lang]['strn'][$n];
        if(($n%100)<20)
            return self::$numString[$lang]['strn'][$n-($n%100)].' '.$and.' '.self::$numString[$lang]['strn'][$n%100];
        for($i=0;$i<3;$i++)
        {
            $y = self::$numString[$lang]['strn'][($n%10)*pow(10,$i)];
            if($y != '')
                $s = "$and $y $s";
            $n = (int)($n/10);
        }

        $s = ' '.substr($s,strlen($and));
        return $s;
    }

    public function numToStr($n,$lang = 'fa')
    {
        $n=''.(float)$n;
        if((int)$n==0)
            return self::$numString[$lang]['index']['zero'];
        if(substr($n,0,1)=='-')
            return self::$numString[$lang]['index']['neg'].' '.$this->numToStr(substr($n,1),$lang);
        if(strlen($n)>12)
            return  self::$numString[$lang]['index']['great'];
        $x=array();
        $i = 0;
        do
        {
            $x []= $this->n2s(substr($n,-3),$lang).' '    ;
            $n = substr($n,0,-3);
        }while(strlen($n)>=1);
        $i=0;
        $str = '';
        $last = count($x)-1;

        while(isset($x[$i]))
        {

            if($x[$i]==' ' && isset($x[$i-1]) && $x[$i-1]!=''){
                $str .= '';
            }else {
                $y = self::$numString[$lang]['index'][($last-$i)*3];
                if($i<(count($x)-1))
                    $str .= self::$numString[$lang]['index']['and'];
                if($x[$i] !== '')
                    $str .= $x[$last-$i].' '.$y.' ';
            }
            $i++;
        }

        if(substr($str,0,2)=="و")
            $str = substr($str,strlen(self::$numString[$lang]['index']['and']));
        return $str;
    }

    public function digit_to_persain_letters($money)
    {
        $one = array(
            'صفر',
            'یک',
            'دو',
            'سه',
            'چهار',
            'پنج',
            'شش',
            'هفت',
            'هشت',
            'نه');
        $ten = array(
            '',
            'ده',
            'بیست',
            'سی',
            'چهل',
            'پنجاه',
            'شصت',
            'هفتاد',
            'هشتاد',
            'نود',
        );
        $hundred = array(
            '',
            'یکصد',
            'دویست',
            'سیصد',
            'چهارصد',
            'پانصد',
            'ششصد',
            'هفتصد',
            'هشتصد',
            'نهصد',
        );
        $categories = array(
            '',
            'هزار',
            'میلیون',
            'میلیارد',
            'بیلیون',
        );
        $exceptions = array(
            '',
            'یازده',
            'دوازده',
            'سیزده',
            'چهارده',
            'پانزده',
            'شانزده',
            'هفده',
            'هجده',
            'نوزده',
        );

//        if(strlen($money) > count($categories)){
//            return ('number is longger!');
//        }

        $letters_separator = ' و ';
        $money = (string)(double)$money;
        $money_len = strlen($money);
        $persian_letters = '';

        for($i=$money_len-1; $i>=0; $i-=3){
            $i_one = (int)isset($money[$i]) ? $money[$i] : -1;
            $i_ten = (int)isset($money[$i-1]) ? $money[$i-1] : -1;
            $i_hundred = (int)isset($money[$i-2]) ? $money[$i-2] : -1;

            $isset_one = false;
            $isset_ten = false;
            $isset_hundred = false;

            $letters = '';

            // zero
            if($i_one == 0 && $i_ten < 0 && $i_hundred < 0){
                $letters = $one[$i_one];
            }

            // one
            if(($i >= 0) && $i_one > 0 && $i_ten != 1 && isset($one[$i_one])){
                $letters = $one[$i_one];
                $isset_one = true;
            }

            // ten
            if(($i-1 >= 0) && $i_ten > 0 && isset($ten[$i_ten])){
                if($isset_one){
                    $letters = $letters_separator.$letters;
                }

                if($i_one == 0){
                    $letters = $ten[$i_ten];
                }
                elseif($i_ten == 1 && $i_one > 0){
                    $letters = $exceptions[$i_one];
                }
                else{
                    $letters = $ten[$i_ten].$letters;
                }

                $isset_ten = true;
            }

            // hundred
            if(($i-2 >= 0) && $i_hundred > 0 && isset($hundred[$i_hundred])){
                if($isset_ten || $isset_one){
                    $letters = $letters_separator.$letters;
                }

                $letters = $hundred[$i_hundred].$letters;
                $isset_hundred = true;
            }

            if($i_one < 1 && $i_ten < 1 && $i_hundred < 1){
                $letters = '';
            }
            else{
                $letters .= ' '.$categories[($money_len-$i-1)/3];
            }

            if(!empty($letters) && $i >= 3){
                $letters = $letters_separator.$letters;
            }

            $persian_letters = $letters.$persian_letters;
        }

        return $persian_letters;
    }


}



