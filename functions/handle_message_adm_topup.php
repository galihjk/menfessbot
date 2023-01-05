<?php
function handle_message_adm_topup($botdata){
    $text = $botdata["text"] ?? "";
    if(in_array($botdata["from"]["id"], f("get_config")("bot_admins",[])) and $text == "/topup"){
        
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];
        
        $textkirim = "<b>Proses TOP UP (1/3)</b>\n";
        $textkirim .= "Balas pesan ini dengan <b>ID Pengguna</b>";

        f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$chat_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
            'reply_markup' => [
                'force_reply'=>true,
                'input_field_placeholder'=>'ID Pengguna',
            ],
        ]);

        return true;
    }
    return false;
}