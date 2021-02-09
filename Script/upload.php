<?php
ob_start();
    foreach (glob("*.pdf") as $filename) //Export all pdf files
        upload($filename, 'Exports/pdf');
    foreach (glob("*.xlsx") as $filename) //Export all excel files
        upload($filename, 'Exports/xls');
fwrite(fopen('upload.txt', 'w+'),ob_get_clean());

    function upload($file, $end_path) { //Exports files to Dropbox
        $auth = '';
        $date= getdate();
        $size = filesize($file);
        $path = $end_path.'/'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'/'.$file;
        $fp = fopen($file, 'r');
        $cheaders = array('Authorization: Bearer ' .$auth.'jMxNU5Ezc-gAAAAAAAAAAQLxvI0If8AV4wHpthpOmIRTKJr0otk_cUH7YiGw-_SU',
        'Content-Type: application/octet-stream',
        'Dropbox-API-Arg: {"path":"/'.$path.'", "mode":"add"}');

        $ch = curl_init('https://content.dropboxapi.com/2/files/upload');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, $size);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        curl_close($ch);
        fclose($fp);
    }

?>

<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <style>
            body {
                background-color: #7c1743;
                background-image: url("Images/Sonic_wait.gif");
                background-position: 50% -95%;
                background-repeat: no-repeat;
            }
        </style>
    </body>
</html>