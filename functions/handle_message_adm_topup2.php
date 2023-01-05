<?php
function handle_message_adm_topup2($botdata){
    if(!empty($botdata['reply_to_message']['text'])
    and in_array($botdata["from"]["id"], f("get_config")("bot_admins",[]))
    and f("str_contains")($botdata['reply_to_message']['text'], "Proses TOP UP (2/3)")){
        $text = $botdata["text"] ?? "";
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];
        
        $textkirim = "<b>Proses TOP UP (3/3)</b>\n";
        $textkirim .= "UNDERCONST";

        f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$chat_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
        ]);

        return true;
    }
    return false;
}