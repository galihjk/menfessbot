<?php
function db_q($q){
    $db_connect = f("db_connect")();
    $data = [];
    if ($result = $db_connect -> query($q)) {
        while ($row = $result -> fetch_row()) {
            $data[] = $row;
        }
        $result -> free_result();
    }
    return $data;
}