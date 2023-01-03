<?php
function db_connect(){
    return new mysqli("localhost",f("get_config")("db_user"),f("get_config")("db_password"),f("get_config")("db_database"));
}