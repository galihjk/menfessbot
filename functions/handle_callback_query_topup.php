<?php
function handle_callback_query_topup($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "topup"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $data_user = f("get_user")($botdata["from"]["id"]);
        
        $textkirim = "Mau top up berapa koin? *jawab dengan angka\n\n/start - menu utama";

        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
            'reply_markup'=>['force_reply'=>true],
        ]);
        return true;
    }
    return false;
}