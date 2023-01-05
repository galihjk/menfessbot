<?php
function handle_message_start($botdata){
    $text = $botdata["text"] ?? "";
    if(f("str_is_diawali")($text,"/start")){
        
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];
        $data_user = f("get_user")($botdata["from"]["id"]);
        $free_msg = $data_user['free_msg'] ?? 0;
        $free_media = $data_user['free_media'] ?? 0;
        $datakirim = f("pesan_utama")(
            ["chat_id"=>$chat_id],
            ['sisa_pesan'=>$free_msg,'sisa_media'=>$free_media]
        );
        f("bot_kirim_perintah")("sendMessage",$datakirim);

        return true;
    }
    return false;
}