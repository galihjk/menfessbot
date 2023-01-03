<?php
include("init.php");
echo $webhook = $_SERVER['SERVER_NAME'] . "/" . basename(__DIR__) . "/" .f("get_config")("webhook");
// echo "<pre>";
// print_r(
//     f("bot_kirim_perintah")("setWebhook",[
//         'url'=>'',
//         'drop_pending_updates'=true,
//     ]);
// )