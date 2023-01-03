<?php
function handle_message_fail($botdata){
    $chat = $botdata["chat"];
    $chat_id = $chat["id"];
    $textkirim = "GAGAL";
    f("bot_kirim_perintah")("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>$textkirim,
        "parse_mode"=>"HTML",
    ]);
    return true;
}