<?php
$shop="";
$shop_footer;
$adress_shop;

class PDF extends FPDF
{


// Page footer
function Footer()
{
    global $shop_footer;
    global $date;
    //global $adress_shop;
    // Position at 1.5 cm from bottom
    $this->SetY(280);
    // Arial italic 8
    $this->SetFont('Philosopher','I',8);
    $this->Cell(0,10, $shop_footer[2],0,0,'L');
    $this->SetX($this->lMargin);
    $this->Cell(0,10,'Page '.$shop_footer[1],0,0,'C');
    $this->SetX($this->lMargin);
    $this->Cell(0,10, $shop_footer[0].' - '.$date['year'].'/'.$date['mon'].'/'.$date['mday'],0,0,'R');
}
}

function PDF_HK($Products, $Stocks, $date, $to_exclude, $shops_to_include, $address_HK) {
    $shop_list = get_shops($Stocks);
    $currency='$';
    $country='HK';

    foreach ($shop_list as $shop) {
    if (isset($shops_to_include) == TRUE)
        if(in_array($shop, $shops_to_include) == TRUE && isset($adress_HK[$shop]['address1']) == TRUE)
            pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'hkbarhkdhkd', $to_exclude, $address_HK);
        else
        pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'hkbarhkdhkd', $to_exclude, $address_HK);
    }
}

function PDF_FR($Products, $Stocks, $date, $to_exclude, $shops_to_include, $address_FR) {
    $shop_list = get_shops($Stocks);
    $currency=iconv("UTF-8", "CP1252", "€");
    $country='FR';

    foreach ($shop_list as $shop) {
    if (isset($shops_to_include) == TRUE)
        if(in_array($shop, $shops_to_include) == TRUE && isset($adress_FR[$shop]['address1']) == TRUE)
            pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'frbareurincleur', $to_exclude, $address_FR);
        else
            pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'frbareurincleur', $to_exclude, $address_FR);
    }
}

function PDF_SG($Products, $Stocks, $date, $to_exclude, $shops_to_include, $address_SG) {
    $shop_list = get_shops($Stocks);
    $currency='$';
    $country='SG';

    foreach ($shop_list as $shop) {
    if (isset($shops_to_include) == TRUE)
        if(in_array($shop, $shops_to_include) == TRUE && isset($adress_SG[$shop]['address1']) == TRUE)
            pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'sgbarsgdincsgd', $to_exclude, $address_SG);
    else
        pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, 'sgbarsgdincsgd', $to_exclude, $address_SG);

    }
}

function pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, $Price, $to_exclude, $addressshop) {
    $exclude=0;
    global $shop_footer;
    //global $address_shop;
    //$address_shop=$addressshop[$shop]['address1'];
    //print_r('KAKAROT'.$address_shop);
    //$shop_footer=$addressshop[$shop]['notes'];
    $previous_sub=$previous_subcat=$previous_cat="";
    $pdf = new PDF();
    $pdf->AddFont('Philosopher','BI', 'Philosopher-BoldItalic.php');
    $pdf->AddFont('Philosopher','B', 'Philosopher-Bold.php');
    $pdf->AddFont('Philosopher','I', 'Philosopher-Italic.php');
    $pdf->AddFont('Philosopher','', 'Philosopher-Regular.php');
    $shop_footer[0]=$addressshop[$shop]['notes'];
    $shop_footer[1]=0;
    $shop_footer[2]=$addressshop[$shop]['address1'];
    
    foreach($Products as $Product) {
        $shop_footer[1]=$pdf->PageNo();
        $tags=explode(' ', $Product['products_1002']);
        $exclude = ($Stocks[$Product['code'].' '.$shop]['available'] > 0 /*|| $Stocks[$Product['code'].' '.$shop]['available']==null*/)?1:-1;
        foreach($tags as $tag) {
            if ($exclude != -1)
                $exclude = (in_array($tag, $to_exclude)==TRUE)?-1:1;
        }
        if ($exclude == 1) {
            if ($previous_cat!=$Product['products_1005'] || $pdf->PageNo() == 0) {
                $pdf->AddPage();
                if ($pdf->PageNo() % 2 == 0/* && $pdf->PageNo()!=1*/)
                    $pdf->AddPage();
                $pdf->SetX(20);
                $pdf->SetY(20);
                $pdf->SetFont('Philosopher','B',15); /*Région*/
                $pdf->Cell(40, 5, $Product['products_1005']);
                $pdf->Ln();
                $previous_cat=$Product['products_1005'];
            } 
                if (($previous_subcat!=$Product['products_1004'] || $previous_cat!=$Product['products_1005']) && $Product['products_1004'] != "") {
                    $pdf->Ln();
                    if (($pdf->GetY() + 20) > 250) {
                        $pdf->AddPage();
                        $pdf->SetY(20);
                    }
                    $pdf->SetX(20);
                    $pdf->SetFont('Philosopher','',11); /*Sous-région*/
                    $pdf->Cell(40, 5, $Product['products_1004']);
                    $pdf->Ln();
                    $previous_subcat=$Product['products_1004'];
                }
                if ($previous_sub!=$Product['products_1003'] && $Product['products_1003'] != "") {// Cru
                    if (($pdf->GetY() + 15) > 250) {
                        $pdf->AddPage();
                        $pdf->SetY(20);
                    }
                    $pdf->Ln();
                    $pdf->SetX(25);
                    $pdf->SetFont('Philosopher','I',9);
                    $pdf->Cell(40, 5, $Product['products_1003']);
                    $pdf->Ln();
                    $previous_sub=$Product['products_1003'];
                }
                if ($pdf->GetY() > 250) {
                    $pdf->AddPage();
                    $pdf->SetY(20);
                }
                $pdf->SetX(30);
                $pdf->SetFont('Philosopher','I',8);
                $pdf->Cell(40, 5, $Product['name']);
                $pdf->SetX(186 - strlen($currency.strval($Product[$Price])));
                $pdf->SetFont('Philosopher','I',9); //Prix
                if ($currency == '$')
                    $pdf->Cell(40, 5, $currency.strval($Product[$Price]));
                else
                    $pdf->Cell(40, 5, strval($Product[$Price]).$currency);
                $pdf->Ln();
            }
            $exclude = 0;
    }
    $pdf->Output('F', str_replace("c/o ", "", ($date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$country." ".$shop.' MENU.pdf')));
    upload(str_replace("c/o ", "", ($date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$country." ".$shop.' MENU.pdf')), 'Exports/pdf');
    unlink(str_replace("c/o ", "", ($date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$country." ".$shop.' MENU.pdf')));

}

// function pdf_shop($Products, $Stocks, $shop, $country, $currency, $date, $Price, $to_exclude) {
//     $turn=0;
//     $exclude=0;
//     $previous_sub=$previous_subcat=$previous_cat="";
//     $pdf = new FPDF();
//     $pdf->AddFont('Philosopher','BI', 'Philosopher-BoldItalic.php');
//     $pdf->AddFont('Philosopher','B', 'Philosopher-Bold.php');
//     $pdf->AddFont('Philosopher','I', 'Philosopher-Italic.php');
//     $pdf->AddFont('Philosopher','', 'Philosopher-Regular.php');
    
//     foreach($Products as $Product) {
//         $tags=explode(' ', $Product['products_1002']);
//         print_r($Product['products_1002'].'<br>'.implode($to_exclude).'<br><br>');
//         foreach($tags as $tag)
//             if ($exclude != -1)
//                 $exclude = (in_array($tag, $to_exclude)==TRUE)?-1:1;
//         if ($exclude == 1) {
//             if ($previous_cat!=$Product['category']) {
//                 $pdf->AddPage();
//                 if ($pdf->PageNo() % 2 == 1 && $turn!=0)
//                     $pdf->AddPage();
//                 $pdf->SetX(20);
//                 $pdf->SetY(20);
//                 $pdf->SetFont('Philosopher','B',15); /*Région*/
//                 $pdf->Cell(40, 10, $Product['category']);
//                 $pdf->Ln();
//                 $previous_cat=$Product['category'];
//             } 
//                 if ($previous_subcat!=$Product['products_1004']) {
//                     $pdf->SetX(20);
//                     $pdf->SetFont('Philosopher','',11); /*Sous-région*/
//                     $pdf->Cell(40, 10, $Product['products_1004']);
//                     $pdf->Ln();
//                     $previous_subcat=$Product['products_1004'];
//                 }
//                 if ($previous_sub!=$Product['products_1003']) {
//                     $pdf->Ln();
//                     $pdf->SetX(25);
//                     $pdf->SetFont('Philosopher','I',9);
//                     $pdf->Cell(40, 5, $Product['products_1003']);
//                     $pdf->Ln();
//                     $previous_sub=$Product['products_1003'];
//                 }
//                 $pdf->SetX(30);
//                 $pdf->SetFont('Philosopher','I',8);
//                 $pdf->Cell(40, 5, $Product['name']);
//                 $pdf->SetX(186 - strlen($currency.strval($Product[$Price])));
//                 $pdf->SetFont('Philosopher','I',9); //Prix
//                 if ($currency == '$')
//                     $pdf->Cell(40, 5, $currency.strval($Product[$Price]));
//                 else
//                     $pdf->Cell(40, 5, strval($Product[$Price]).$currency);
//                 $pdf->Ln();
//                 $turn=1;
//             }
//             $exclude = 0;
//     }
//     $pdf->Output('F', str_replace("c/o ", "", ($date['year'].'-'.$date['mon'].'-'.$date['mday'].$country." ".$shop.' MENU.pdf')));
// }

function exclusion($Products, $to_exclude) {
    foreach($Products as $Product) {
        if (in_array($Product['products_1002'], $to_exclude) == TRUE) {
            unset($Product);
        }
    }
    return $Products;
}
?>