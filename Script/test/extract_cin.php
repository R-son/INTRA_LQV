<?php
    include 'delete.php';
    $status = 200;
    $path = 'ProductsExtraction.csv';
    $file = pathinfo($path)['basename'];
    $fp = fopen($file, 'w+');
    $company = array('LQVBARSGSG', 'LQVFRCAVEEU', 'LQVHKTRADEHK');
    $status=dowload_products($fp);
    fclose($fp);
    $pwd=array('62ee9d3029f3432199a3c121fec9db97', '2cab243200ff42d6a323d2934b21500a', '56ab2ada19d746a193d56be858e95863');
    for ($i=0; $i < 3; $i++)
        dowload_stocks($company[$i], $pwd[$i]);
    
    function dowload_products($fp) {
        $data = $response = "";
        //$url="https://api.cin7.com/api/v1/Products?where=(stockControl='FIFO')and(status='Public')&order=category&rows=250";
        $url="https://api.cin7.com/api/v1/Products?where=(stockControl=%27FIFO%27)and(status=%27Public%27)&order=category&rows=250&fields=category,customfields(products_1003,products_1004),name,styleCode,brand,productType,description,stockControl,productOptions(code,option1,option2,retailPrice)";
        //https://api.cin7.com/api/v1/Products?where=(stockControl='FIFO'&fields=customFields)and(status='Public')&order=category&fields=category,name&rows=250
        $usr="LQVFRCAVEEU";
        $pwd="2cab243200ff42d6a323d2934b21500a";
        for ($i = 1;$response !== "[]"; $i++) {
            $headers = [];
            $output = [];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERPWD, $usr . ":" . $pwd);
            curl_setopt($ch, CURLOPT_URL, "".$url."&page=".$i."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $response = curl_exec($ch);
            $data = json_decode($response, true);
            $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            //print_r($data);

            foreach ($data as $line => $item) {
                $output[$line] = [];
                
                foreach ($item as $key => $row) {
                    if (gettype($item[$key]) == 'array') {
                        foreach($item as $head) {
                            if (gettype($head) == 'array') {
                                $keys = array_keys($head);
                                $a = 0;
                                foreach($head as $h) {
                                    if(gettype($h) == 'array') {
                                        $k = array_keys($h);
                                        $b=0;
                                        foreach($h as $h1) {
                                            if (!isset($headers[$h1])) {
                                                $headers[$k[$b]] = $k[$b];
                                                $b++;
                                            }
                                        }
                                    }
                                    else if (!isset($headers[$h])) {
                                        $headers[$keys[$a]] = $keys[$a];
                                        $a++;
                                    }
                                }
                            }
                            $a=0;
                            $output[$line][$key] = $row;
                        }
                    }
                    else {
                        if (!isset($headers[$key])) {
                            $headers[$key] = $key;
                        }
                        $output[$line][$key] = $row;
                    }
                }
            }
            $outputString = [];
            foreach ($headers as $header) {
                $outputString .= $header . ',';
            }
            $outputString = rtrim($outputString, ',');
            $outputString .= "\r\n";
            foreach ($output as $row) {
                print_r('<br>OUTPUT<br>');
                var_dump($output);
                print_r('<br>ROW<br>');
                var_dump($row);
                foreach ($headers as $header) {
                    if (gettype($row[$header]) == 'array')
                        print_r('TEST');
                    $outputString .= '"'.$row[$header].'",';
                }
                $outputString = rtrim($outputString, ',');
                $outputString .= "\r\n";
            }
            $outputString = str_replace('ArraystyleCode', 'styleCode', $outputString);
            if ($i != 1)
                $outputString = substr($outputString, strpos($outputString, "\n") + 1);
            fwrite($fp, $outputString);
            print_r($outputString);
        }
        return $status;
    }

    function dowload_stocks($company, $pwd) {
        $url = "https://api.cin7.com/api/v1/Stock?fields=styleCode,Name,Option1,Option2,Available,StockOnHand,BranchName,Incoming&rows=250";
        $response = "";

        $fp = fopen('StocksExtraction - '.$company.'.csv', 'w+');
        for ($i = 1;$response !== "[]"; $i++) {
            $headers = [];
            $output = [];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERPWD, $company . ":" . $pwd);
            curl_setopt($ch, CURLOPT_URL, "".$url."&page=".$i."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $response = curl_exec($ch);
            $data = json_decode($response, true);
            $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

            foreach ($data as $line => $item) {
                $output[$line] = [];
                foreach ($item as $key => $row) {
                    if (!isset($headers[$key])) {
                        $headers[$key] = $key;
                    }
                    if (gettype($row) == 'array')
                    $output[$line][$key]= implode("", $row);
                    else
                    $output[$line][$key] = $row;
                    
                }
            }
            $outputString = [];
            foreach ($headers as $header) {
                $outputString .= $header . ',';
            }
                
            $outputString = rtrim($outputString, ',');
            $outputString .= "\r\n";
            foreach ($output as $row) {
                foreach ($headers as $header) {
                        $outputString .= '"'.$row[$header].'",';
                }
                $outputString = rtrim($outputString, ',');
                $outputString .= "\r\n";
            }
            $outputString = str_replace('ArraystyleCode', 'styleCode', $outputString);
            if ($i != 1)
                $outputString = substr($outputString, strpos($outputString, "\n") + 1);
            fwrite($fp, $outputString);
            print_r(gettype($outputString));
            
            //print_r($outputString);
        }
        return $status;
    }
?>