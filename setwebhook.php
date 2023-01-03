<?php
echo "<pre>";
$config = include('/config.php');
print_r($config);
$config = include('config.php');
print_r($config);
$config = scandir(".");
print_r($config);