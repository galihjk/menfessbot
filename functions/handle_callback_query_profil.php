<?php
function handle_callback_query_profil($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "profil"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $data_user = f("get_user")($botdata["from"]["id"]);
        $textkirim = "ini".print_r($data_user, true);
        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            'reply_markup'=>f("gen_inline_keyboard")([
                ['⬅️ Kembali', 'home']
            ]),
        ]);
        return true;
    }
    return false;
}