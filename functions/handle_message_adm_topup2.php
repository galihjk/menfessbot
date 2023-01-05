<?php
function handle_message_adm_topup2($botdata){
    if(!empty($botdata['reply_to_message']['text'])
    and in_array($botdata["from"]["id"], f("get_config")("bot_admins",[]))
    and f("str_contains")($botdata['reply_to_message']['text'], "Proses TOP UP (2/3)")
    and is_numeric($text)){
        $text = $botdata["text"] ?? "";
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];

        $explode = explode("[", $botdata['reply_to_message']['text'])[1];
        $usertopupid = explode("]", $botdata['reply_to_message']['text'])[0];
        $usertopup = f("get_user")($usertopupid);
        
        $textkirim = "<b>Proses TOP UP (3/3)</b>\n";
        $textkirim .= "ID: ".$usertopupid;
        $textkirim .= "Nama: ".$usertopup["first_name"] . (empty($usertopup["first_name"]) ? '' : "(@".$usertopup["username"]." )");
        $textkirim .= "Nominal Koin: ".number_format($text);

        f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$chat_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
            'reply_markup'=>f("gen_inline_keyboard")([
                ['✅ Kirim', 'topup_'.$usertopupid.'_'.$text]
            ]),
        ]);

        return true;
    }
    return false;
}