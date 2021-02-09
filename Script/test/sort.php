<?php
function fuse_arrays($Products, $exclude) {
    $Final=[];
    foreach($Products as $Pages)
        foreach($Pages as $Lines) {
            $Lines["products_1000"] = (double)$Lines["products_1000"];
            //if ($Lines["products_1000"] != 0)
                array_push($Final, $Lines);
        }
    usort($Final, "my_sort_array");
    return sort_by_brand($Final);
}

function my_sort_array($a, $b) {
    if ($a["products_1000"]==$b["products_1000"]) return 0;
    return ($a["products_1000"] < $b["products_1000"])?-1:1;
}


function sort_by_brand($Final) {
    $i = 0;
    $to_sort=[];
    $sorted=[];
    $previous="";
    foreach($Final as $Product) {
        if ($previous!=$Product['brand'] && $i!=0) {
            usort($to_sort, 'my_sort_array_brand');
            foreach($to_sort as $sorting)
            array_push($sorted, $sorting);
        } else
        array_push($to_sort, $Product);
    }
    return $sorted;
}

function my_sort_array_brand($a, $b) {
    if ($a["brand"]==$b["brand"]) return 0;
    return ($a["brand"] < $b["brand"])?-1:1;
}

function sort_by_ProductName($Final) {
    $i = 0;
    $to_sort=[];
    $sorted=[];
    $previous="";
    foreach($Final as $Product) {
        if ($previous!=$Product['brand'] && $i!=0) {
            usort($to_sort, 'my_sort_array_ProductName');
            foreach($to_sort as $sorting)
                array_push($sorted, $sorting);
        } else
            array_push($to_sort, $Product);
    }
    return $sorted;
}

function my_sort_array_ProductName($a, $b) {
    if ($a["name"]==$b["name"]) return 0;
    return ($a["name"] < $b["name"])?-1:1;
}
?>