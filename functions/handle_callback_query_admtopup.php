<?php
function handle_callback_query_topup($botdata){
    if(!empty($botdata["data"]) 
    and f("str_is_diawali")($botdata["data"], "topup_")
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);

        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        
        $textkirim = "Underconst!";

        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
        ]);
        return true;
    }
    return false;
}