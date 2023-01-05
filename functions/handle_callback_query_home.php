<?php
function handle_callback_query_home($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "home"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $chat_id = $botdata["message"]["chat"]["id"];
        $message_id = $botdata["message"]["message_id"];
        $data_user = f("get_user")($botdata["from"]["id"]);
        $free_msg_used = $data_user['free_msg_used'] ?? 0;
        $free_media = $data_user['free_media'] ?? 0;
        $datakirim = f("pesan_utama")(
            ["chat_id"=>$chat_id, 'message_id'=>$message_id],
            ['sisa_pesan'=>$free_msg_used,'sisa_media'=>$free_media]
        );
        f("bot_kirim_perintah")("editMessageText",$datakirim);
        return true;
    }
    return false;
}