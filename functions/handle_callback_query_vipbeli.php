<?php
function handle_callback_query_vipbeli($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "vipbeli"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $data_user = f("get_user")($botdata["from"]["id"]);

        $cost_vip = f("get_config")("cost_vip",10000);
        
        $textkirim = "Berhasil!\n\n";
        $textkirim = "Koin anda saat ini:".(f("get_user")($botdata["from"]["id"])['coin']-$cost_vip);

        $buttons = [
            ['⬅️ Kembali', 'profil'],
            ['🏠 Menu Utama', 'home'],
        ];

        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
            'reply_markup'=>f("gen_inline_keyboard")($buttons),
        ]);
        return true;
    }
    return false;
}