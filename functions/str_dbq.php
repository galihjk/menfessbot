<?php
function str_dbq($str, $wrap){
    if(is_array($str)){
        foreach($str as $k=>$v){
            if(is_string($v)){
                $str[$k] = str_replace("'", "''", $v);
                if($wrap) $str[$k] = "'".$str[$k]."'";
            }
        }
        return $str;
    }
    if(!is_string($str)) return false;
    $str = str_replace("'", "''", $str);
    if($wrap) $str = "'".$str."'";
    return $str;
}