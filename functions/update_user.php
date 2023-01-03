<?php
function update_user($userdata){
    $mysqli = f("db_connect")();
    $userdata = f("str_dbq")($userdata,true);
    $user_id = $userdata["id"];
    $first_name = $userdata["first_name"] ?? "";
    $last_name = $userdata["last_name"] ?? "";
    $username = $userdata["username"] ?? "";
    f("db_q")("INSERT INTO users 
        (user_id, first_name, last_name, username) VALUES 
        ($user_id, $first_name, $last_name, $username)
        ON DUPLICATE KEY UPDATE 
        first_name=$first_name, last_name=$last_name, username=$username;
    ");
}