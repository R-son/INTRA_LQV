<?php
require_once(__DIR__ . '/phpSpreadSheet/vendor/autoload.php');

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$spreadsheet->getProperties();
$sheet = $spreadsheet->getActiveSheet();
LQV_World_Stock($sheet, $Products, $All_Stocks);
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save($date['year'].'-'.$date['mon'].'-'.$date['mday'].' LQV WORLD Stock.xlsx');
upload($date['year'].'-'.$date['mon'].'-'.$date['mday'].' LQV WORLD Stock.xlsx', 'Exports/xls');
unlink($date['year'].'-'.$date['mon'].'-'.$date['mday'].' LQV WORLD Stock.xlsx');
//$writer->;

function LQV_World_Stock($sheet, $Products, $All_Stocks) {
    $column = 'A';
    $row = 2;
    $euro='#,##0.00_-"€"';
    $labels = array('CODE','Category','REGION','Sous Region','APPELLATION','BRAND','DESCRIPTION','CUVEE','VINTAGE','SIZE','COLOUR',
    "Cost HT€",'TRADE HT€','PU HT € RETAIL','PU TTC € RETAIL','COST HK$','HK$ AG','HK$ Wholesale','HK$ TRADE','HK$  ONLINE','HK$ SHOP','SG$ COST Excl.','SG$ TRADE Excl.','SG$ ONLINE Excl.','SG$ SHOP Incl.','ALL FR','Available Casanova','Available Wine Sitting','Available Wine Sitting Ageing','On Hand Wine Sitting','Incoming Wine Sitting','Incoming Casanova','Incoming Stock FR','Sold Paris','ALL AVAILABLE HK','Bar Gage','Bar Swatow','Caine','La Cremerie','STAN','KEL','TRADE HOLD','ALL ARRIVING NEXT SHIP. HK','ALL AVAILABLE NEXT SHIP. HK','COMING LATER THIS YEAR HK','ALL Qty sold HK','All SG','ALL ARRIVING NEXT SHIP. SG','ALL AVAILABLE NEXT SHIPMENT SG','Sold SG',
    'No Trade ?','WooCo','Natural','Farming','AG','Tri Menu');
    foreach ($labels as $label) {
        $sheet->setCellValue($column.'1', $label);
        $sheet->getColumnDimension($column)->setWidth(30);
        $sheet->getStyle($column.'1')->getFont()->setBold(true);
        $sheet->getStyle($column.'1')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension($column)->setAutoSize(true);
        $column++;
    }
    $sheet->getColumnDimension($column)->setAutoSize(true);
    foreach($Products as $Product) {
        $column='A';
        $Product_labels= array($Product['code'], $Product['products_1006'], $Product['category'], $Product['products_1004'], $Product['products_1003'], $Product['brand'], $Product['name'], $Product['products_1011'], $Product['productType'], $Product['option2'], $Product['option1']);
        foreach($Product_labels as $Product_label) {
            if (is_numeric($Product_label)== TRUE)
                round($Product_label, 2);
            $sheet->setCellValue($column.$row, $Product_label);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }
        $Product_labels= array(strval($Product['costEUR']),strval($Product['frtradeeurexcleur']),strval($Product['frretaileurhteur']),/*P*/strval($Product['frretaileureur']),strval($Product['hkptfhkdhkd']), strval($Product['hkaghkdhkd']), strval($Product['hkwholhkdhkd']), strval($Product['hktradehkdhkd']), strval($Product['hkonlinehkdhkd']), strval($Product['hkretailhkdhkd']), strval($Product['sgptfsgdincsgd']), strval($Product['sgtradesgdisgd']), strval($Product['sgonlineexclsgd']), strval($Product['sgretailsgdsgd']));
        foreach($Product_labels as $Product_label) {
            if (is_numeric($Product_label)== TRUE)
                round($Product_label, 2);
            $sheet->setCellValue($column.$row, $Product_label);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            if ('P' <= $column && $column <= 'Y')
                $sheet->getStyle($column)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $column++;
        }
        $column='Z';
        $Product_labels=array('=SUM(AA'.$row.':AC'.$row.')', (isset($All_Stocks['FR'][$Product['code'].' Casanova']['available'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' Casanova']['available']):0, 
        (isset($All_Stocks['FR'][$Product['code'].' WineSitting']['available'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' WineSitting']['available']):0,
        (isset($All_Stocks['FR'][$Product['code'].' WineSitting Ageing']['available'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' WineSitting Ageing']['available']):0,
        (isset($All_Stocks['FR'][$Product['code'].' WineSitting']['stockOnHand'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' WineSitting']['stockOnHand']):0,
        (isset($All_Stocks['FR'][$Product['code'].' WineSitting']['incoming'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' WineSitting']['incoming']):0,
        (isset($All_Stocks['FR'][$Product['code'].' Casanova']['incoming'])==TRUE)?strval($All_Stocks['FR'][$Product['code'].' Casanova']['incoming']):0,
        '=SUM(AE'.$row.':AF'.$row.')', '=AD'.$row.'-AB'.$row.'+AA'.$row, '=SUM(AJ'.$row.':AP'.$row.')',
        (isset($All_Stocks['HK'][$Product['code'].' IML']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' IML']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' NRL']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' NRL']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' KIN']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' KIN']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' BAL']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' BAL']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' STAN Shop']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' KEL']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' KEL']['available']):0,
        (isset($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['available'])==TRUE)?strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['available']):0,
        '='.((strval($All_Stocks['HK'][$Product['code'].' KEL']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' NRL']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' IML']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' BAL']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' KIN']['stockOnHand'])+
        strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['stockOnHand']))+strval($All_Stocks['HK'][$Product['code'].' In Sea']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' KEL']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' NRL']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' IML']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' BAL']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' KIN']['incoming'])+
        strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['incoming'])),
        ($Product['products_1006']=='Wine')?((strval($All_Stocks['HK'][$Product['code'].' IML']['available'])+strval($All_Stocks['HK'][$Product['code'].' KEL']['available'])+strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['available'])+strval($All_Stocks['HK'][$Product['code'].' NRL']['available'])+strval($All_Stocks['HK'][$Product['code'].' BAL']['available'])+strval($All_Stocks['HK'][$Product['code'].' KIN']['available'])+strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['available'])<0)?$sheet->getCell('AR'.$row)->getValue()+strval($All_Stocks['HK'][$Product['code'].' IML']['available'])+strval($All_Stocks['HK'][$Product['code'].' KEL']['available'])+strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['available'])+strval($All_Stocks['HK'][$Product['code'].' NRL']['available'])+strval($All_Stocks['HK'][$Product['code'].' BAL']['available'])+strval($All_Stocks['HK'][$Product['code'].' KIN']['available'])+strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['available']):$sheet->getCell('AR'.$row)->getValue()):strval($All_Stocks['HK'][$Product['code'].' KEL']['incoming'])+strval($All_Stocks['HK'][$Product['code'].' Incoming Later']['incoming'])+strval($All_Stocks['HK'][$Product['code'].' Stan Shop']['incoming'])+strval($All_Stocks['HK'][$Product['code'].' BAL']['incoming']),
        strval($All_Stocks['HK'][$Product['code'].' Incoming Later']['incoming'])+strval($All_Stocks['HK'][$Product['code'].' Incoming Later']['available']),
        '='.(strval($All_Stocks['HK'][$Product['code'].' IML']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' NRL']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' KIN']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' Incoming Later']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' STAN Shop']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' KEL']['stockOnHand'])+strval($All_Stocks['HK'][$Product['code'].' TRADE HOLD']['stockOnHand']))-($sheet->getCell('AI'.$row)->getValue()),
        /*All SG*/(isset($All_Stocks['SG'][$Product['code'].' Wine n Dine SG Pte Ltd']['available'])==TRUE)?strval($All_Stocks['SG'][$Product['code'].' Wine n Dine SG Pte Ltd']['available']):0,
        /*ALL ARRIVING NEXT SHIP. SG*/(isset($All_Stocks['SG'][$Product['code'].' ALL ARRIVING NEXT SHIP. SG']['incoming'])==TRUE)?strval($All_Stocks['SG'][$Product['code'].' ALL ARRIVING NEXT SHIP. SG']['incoming']):0,
        /*'ALL AVAILABLE NEXT SHIPMENT SG'*/(isset($All_Stocks['HK'][$Product['code'].' Wine n Dine SG Pte Ltd ']['available'])==TRUE)?((strval($All_Stocks['HK'][$Product['code'].' Wine n Dine SG Pte Ltd ']['available']) < 0)?$sheet->getCell('AV'.$row)->getValue()+strval($All_Stocks['HK'][$Product['code'].' Wine n Dine SG Pte Ltd ']['available']):$sheet->getCell('AV'.$row)->getValue()):0,
        strval($All_Stocks['SG'][$Product['code'].' Wine n Dine SG Pte Ltd']['stockOnHand'])-strval($All_Stocks['SG'][$Product['code'].' Wine n Dine SG Pte Ltd']['available']));
        foreach($Product_labels as $Product_label) {
            if (is_numeric($Product_label)== TRUE)
                round($Product_label, 2);
            $sheet->setCellValue($column.$row, $Product_label);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }
        $column='AY';
        $Product_labels= array($Product['products_1002'], $Product['products_1007'],$Product['products_1013'],$Product['products_1014'],$Product['products_1001'],$Product['products_1000']);
        foreach($Product_labels as $Product_label) {
            $sheet->setCellValue($column.$row, $Product_label);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }
        $sheet->getColumnDimension($column)->setAutoSize(true);
        if ($sheet->getCell('Z'.$row)->getValue() != 0 || $sheet->getCell('AI'.$row)->getValue() != 0 || $sheet->getCell('AU'.$row)->getValue() != 0)
            $row++;
    }
}
?>