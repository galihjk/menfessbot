<?php
function handle_callback_query_vip($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "vip"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $data_user = f("get_user")($botdata["from"]["id"]);
        
        $textkirim = "<b>Fitur VIP:</b>\n";
        $textkirim .= "Unlimited bla bla bla\n";

        $buttons = [
            ['⬅️ Kembali', 'home'],
        ];
        if(empty($data_user['vip_until'])){
            $buttons[] = ['✅ Beli🎖 VIP', 'vipbeli'];
        }

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