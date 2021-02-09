<?php
    include 'delete';
    $All_Stocks=array();
    $All_Stocks['FR']=array();
    $All_Stocks['HK']=array();
    $All_Stocks['SG']=array();

    $address=array();
    $address['FR']=array();
    $address['HK']=array();
    $address['SG']=array();

    $to_exclude = array($excludefr=explode(', ', $_POST['to_exclude_FR']), //List of criterias to exclude (products_1002) for each country
                    $excludehk=explode(', ', $_POST['to_exclude_HK']),
                    $excludesg=explode(', ', $_POST['to_exclude_SG']));
    $shops_to_include = array($includefr=explode(', ', $_POST['shops_to_include_FR']),
                            $includehk=explode(', ', $_POST['shops_to_include_HK']),
                            $includehk=explode(', ', $_POST['shops_to_include_SG']));

    include 'Generate.php'; //Extracts all data
    //include 'upload.php'; //Exports all files that need to be exported to Dropbox
    //include 'delete.php'; //Delete all generated files after export
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Script</title>
        <link rel="icon" href="../Images/LQV_login.png" />
    </head>
    <body>
        <style>
            body {
                background-color: #7c1743;
                background-image: url("../Images/Sonic_wait.gif");
                background-position: 50% -95%;
                background-repeat: no-repeat;
            }
        </style>
    </body>
</html>