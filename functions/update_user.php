<?php
function update_user($userdata){
    $userdata = f("str_dbq")($userdata,true);
    file_put_contents("tesq4.txt",print_r($userdata,true));
    $user_id = $userdata["id"];
    $first_name = $userdata["first_name"] ?? "";
    $last_name = $userdata["last_name"] ?? "";
    $username = $userdata["username"] ?? "";
    $q = "INSERT INTO users 
        (user_id, first_name, last_name, username) VALUES 
        ($user_id, $first_name, $last_name, $username)
        ON DUPLICATE KEY UPDATE 
        first_name=$first_name, last_name=$last_name, username=$username;
    ";
    file_put_contents("tesq4q.txt",print_r($q,true));
    f("db_q")($q);
}