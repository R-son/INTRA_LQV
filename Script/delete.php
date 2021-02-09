<?php
ob_start();
    $fullPath = __DIR__ . "/";
    array_map('unlink', glob("$fullPath*.pdf")); //Delete all pdf files
    array_map('unlink', glob("$fullPath*.xlsx")); //Delete all csv files
    array_map('unlink', glob("$fullPath*.txt"));
ob_get_clean();
?>