<?php
    //require('fpdf/fpdf.php');
    //$shop_list = get_shops();
    if ($i == 0) {
        PDF_SG($Products, $Stocks, $date, $to_exclude[$i]);
    }
    else if ($i == 1) {
        PDF_FR($Products, $Stocks, $date, $to_exclude[$i]);
    }
    else if ($i == 2) {
        PDF_HK($Products, $Stocks, $date, $to_exclude[$i]);
    }
?>