<?php
function handle_callback_query_profil($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "profil"
    and !empty($botdata["message"])
    ){
        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $userid = f("str_dbq")($botdata["from"]["id"],true);
        $data_user = f("db_select_one")("select * from users where id = $userid");
        $textkirim = "ini".print_r($data_user, true);
        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            'reply_markup'=>f("gen_inline_keyboard")([
                ['⬅️ Kembali', 'home']
            ]),
        ]);
        // f("bot_kirim_perintah")('answerCallbackQuery',[
        //     'callback_query_id' => $botdata['id'],
        //     'text'=> "Underconstruction:" . $botdata["data"],
        //     'show_alert'=>true,
        // ]);
        return true;
    }
    return false;
}