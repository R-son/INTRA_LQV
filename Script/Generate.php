<?php
    include('upload.php');
    ini_set('memory_limit', '2048M');
    require('fpdf/fpdf.php');//Required to the creation of the pdf files
    require('extract.php'); //Contains the functions that'll extract the data
    require('PDF_generator.php'); //Contains the functions that'll generate the pdf files
    define('FPDF_VERSION','1.82'); //Nécessaire aux PDF

    $j = array('SG','FR', 'HK');
    $company = array('LQVBARSGSG', 'LQVFRCAVEEU', 'LQVHKTRADEHK');//Usernames needed for extraction
    $pwd=array('62ee9d3029f3432199a3c121fec9db97', '2cab243200ff42d6a323d2934b21500a', '56ab2ada19d746a193d56be858e95863'); //Passwords needed for extraction
    $date = getdate(); //Do I really have to explain that one ?!
    $Products = dowload_products(); //Extracts Products
    $Products = fuse_arrays($Products); //Fuse all data in one array
    for ($i=0; $i < 3; $i++) { //Extracts Stocks and creates PDF files to export
        $Stocks = dowload_stocks($company[$i], $pwd[$i]);
        $All_Stocks[$j[$i]]=$Stocks;
        $address[$j[$i]]=get_branches($company[$i], $pwd[$i]);
    }
    include 'XLS_Generator.php';
    PDF_SG($Products, $All_Stocks['SG'], $date, $to_exclude[0], $shops_to_include[0], $address['SG']);
    PDF_FR($Products, $All_Stocks['FR'], $date, $to_exclude[1], $shops_to_include[1], $address['FR']);
    PDF_HK($Products, $All_Stocks['HK'], $date, $to_exclude[2], $shops_to_include[2], $address['HK']);

    //Gets all the shops of a region
    function get_shops($Stocks) {
        $shop_list = [];
        foreach ($Stocks as $Lines) {
            if (in_array($Lines['branchName'], $shop_list) != TRUE)
                array_push($shop_list, $Lines['branchName']);
        }
        return $shop_list;
    }

    function fuse_arrays(&$Products) {
        $Final=[];
        foreach($Products as $Pages)
            foreach($Pages as $Lines) {
                $Lines["products_1000"] = (double)$Lines["products_1000"];
                array_push($Final, $Lines);
            }
        usort($Final, "my_sort_array");
        return sort_by($Final);
    }

    function my_sort_array($a, $b) {
        if ($a["products_1000"]==$b["products_1000"]) return 0;
        return ($a["products_1000"] < $b["products_1000"])?-1:1;
    }

    function sort_by(&$Final) {
        uasort($Final, 'my_sort_trimenu');
        return $Final;
    }

    function my_sort_trimenu($a, $b) {
        $result = $a['products_1000'] - $b['products_1000'];
        if ($result == 0)
            return my_sort_quality($a, $b);
        return ($result < 0)?-1:1;
    }
    
    function my_sort_region($a, $b) {
        $result = strcmp($a['products_1005'], $b['products_1005']);
        if ($result == 0)
            return my_sort_subregion($a, $b);
        return $result;
    }

    function my_sort_subregion($a, $b) {
        $result = strcmp($a['products_1004'], $b['products_1004']);
        if ($result == 0)
            return my_sort_quality($a, $b);
        return $result;
    }

    function my_sort_quality($a, $b) {
        $result = strcmp($a['products_1003'], $b['products_1003']);
        if ($result == 0)
            return my_sort_brand($a, $b);
        return $result;
    }

    function my_sort_brand($a, $b) {
        $result = strcmp($a['brand'], $b['brand']);
        if ($result == 0)
            return my_sort_name($a, $b);
        return $result;
    }

    function my_sort_name($a, $b) {
        $result = strcmp($a['name'], $b['name']);
        if ($result == 0)
            return my_sort_vintage($a, $b);
        return $result;
    }

    function my_sort_vintage($a, $b) {
        $result = strcmp($a['productType'], $b['productType']);
        if ($result == 0)
            return my_sort_size($a, $b);
        return $result;
    }

    function my_sort_size($a, $b) {
        $result = strcmp($a['option2'], $b['option2']);
        if ($result == 0)
            return 0;
        return -$result;
    }
?>