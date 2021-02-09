<?php
define('FPDF_VERSION','1.82'); //Nécessaire aux PDF
require('../fpdf/fpdf.php');
$Products=array('test', 'test2');
$Stocks=[];
$shop='';
$country='FR';
$currency='';
$date='';
$Price='';
$to_exclude='';
$addressshop='';
include('../PDF_generator.php');
pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, $Price, $to_exclude, $addressshop)
?>
