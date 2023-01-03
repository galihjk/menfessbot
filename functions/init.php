<?php
function f($f){
    $filename = app_path()."/Functions/$f.php";
    if(file_exists($filename)){
        include_once($filename);
        return $f;
    }
    file_put_contents("php://stderr", "f_not_exist: $f!\n");
    return false;
}