<?php
function update_user($userdata){
    $userdata = f("str_dbq")($userdata,true);
    $id = $userdata["id"];
    $first_name = $userdata["first_name"] ?? "''";
    $last_name = $userdata["last_name"] ?? "''";
    $username = $userdata["username"] ?? "''";
    $max_free_msg = f("get_config")("pesan_max",15);
    $q = "INSERT INTO users 
        (id, first_name, last_name, username, free_msg) VALUES 
        ($id, $first_name, $last_name, $username, $max_free_msg)
        ON DUPLICATE KEY UPDATE 
        first_name=$first_name, last_name=$last_name, username=$username;
    ";
    f("db_q")($q);
}