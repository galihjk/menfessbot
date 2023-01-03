<?php
function update_user($userdata){
    $userdata = f("str_dbq")($userdata,true);
    $id = $userdata["id"];
    $first_name = $userdata["first_name"] ?? "''";
    $last_name = $userdata["last_name"] ?? "''";
    $username = $userdata["username"] ?? "''";
    $q = "INSERT INTO users 
        (id, first_name, last_name, username) VALUES 
        ($id, $first_name, $last_name, $username)
        ON DUPLICATE KEY UPDATE 
        first_name=$first_name, last_name=$last_name, username=$username;
    ";
    f("db_q")($q);
}