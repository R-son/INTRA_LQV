<?php
function dowload_products() {
    $response = "";
    $url="https://api.cin7.com/api/v1/Products?where=(stockControl=%27FIFO%27)and(status=%27Public%27)&order=&rows=250&fields=category,productType,customfields(products_1000,products_1001,products_1002,products_1003,products_1004,products_1005,products_1006,products_1007,products_1011,products_1013,products_1014),name,styleCode,brand,productType,description,stockControl,productOptions(code,option1,option2,priceColumns(frbareurincleur,frtradeeurexcleur,frretaileurhteur,frretaileureur,hkbarhkdhkd,hkptfhkdhkd,sgbarsgdincsgd,costEUR,hkonlinehkdhkd,hkretailhkdhkd,sgptfsgdincsgd,sgtradesgdisgd,sgonlineexclsgd,sgretailsgdsgd,hkaghkdhkd,hkwholhkdhkd,hktradehkdhkd))";
    $usr="LQVFRCAVEEU";
    $pwd="2cab243200ff42d6a323d2934b21500a";
    $data = [];
    $to_sort=[];
    $status=0;
    for ($i = 1;$response !== "[]" && $status!=429; $i++) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, $usr . ":" . $pwd);
        curl_setopt($ch, CURLOPT_URL, "".$url."&page=".$i."");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        $data[$i - 1] = json_decode($response, true);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        foreach ($data[$i - 1] as $line => $key0) {
            foreach($key0 as $elements => $key1) {
                if (gettype($key1) == 'array') {
                    foreach($key1 as $element => $key2)
                        if (gettype($key2) == 'array')
                            foreach($key2 as $key3 => $key4) {
                                if (gettype($key4) == 'array')
                                    foreach($key4 as $key5 => $key)
                                        $to_sort[$key5] = $key;
                                else
                                    $to_sort[$key3] = $key4;
                            }
                        else
                            $to_sort[$element] = $key2;
                }
                else
                $to_sort[$elements] = $key1;
            }
            $data[$i - 1][$line] = $to_sort;
        }
        
    }
    sleep(1);
    return $data;
}

function dowload_stocks($company, $pwd) {
    $url = "https://api.cin7.com/api/v1/Stock?fields=code,styleCode,Name,Option1,Option2,Available,StockOnHand,BranchName,Incoming&rows=250";
    $response = "";
    $page = [];
    $status=0;

    for ($i = 1;$response != "[]" && $status!=429; $i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, $company . ":" . $pwd);
        curl_setopt($ch, CURLOPT_URL, "".$url."&page=".$i."");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        $data = json_decode($response, true);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $page[$i - 1] = $data;
        sleep (1);
    }
    return fuse_stocks($page);
}

function fuse_stocks($page) {
    $Stocks = array();
    foreach($page as $line)
        foreach ($line as $Stock)
            $Stocks[$Stock['code'].' '.$Stock['branchName']]=$Stock;
    return $Stocks;
}

function get_branches($company, $pwd) {
    $url = "https://api.cin7.com/api/v1/Branches?fields=company,address1,notes";
    $response = "";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_USERPWD, $company . ":" . $pwd);
    curl_setopt($ch, CURLOPT_URL, "".$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    sleep (2);
    $i=0;
    foreach($data as $branch) {
        $data[$branch['company']]=$branch;
        unset($data[$i]);
        $i++;
    }
    return $data;
}
?>