<?php
function handle_message_start($botdata){
    $text = $botdata["text"] ?? "";
    if($text == "/start"){
        
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];
        $datakirim = f("pesan_utama")(["chat_id"=>$chat_id],['sisa_pesan'=>15,'sisa_media'=>0]);
        f("bot_kirim_perintah")("sendMessage",$datakirim);

        return true;
    }
    return false;
}