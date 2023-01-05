<?php
function handle_message_adm_fwdinfo($botdata){
    if(!empty($botdata["forward_from"])
    and in_array($botdata["from"]["id"], f("get_config")("bot_admins",[]))){
        
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];
        
        $textkirim = "ini ".print_r($botdata,true);

        f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$chat_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
        ]);

        return true;
    }
    return false;
}