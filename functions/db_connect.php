<?php
mysqli_connect (
    "localhost",
    f("getconfig")("db_user"),
    f("getconfig")("db_password"),
    f("getconfig")("db_database"),
);
function db_connect(){
    // return mysql_connect (
    //     "localhost",
    //     f("getconfig")("db_user"),
    //     f("getconfig")("db_password")
    // );
}