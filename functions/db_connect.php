<?php
mysqli_connect (
    "localhost",
    f("get_config")("db_user"),
    f("get_config")("db_password"),
    f("get_config")("db_database"),
);
function db_connect(){

}