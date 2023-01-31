<?php
function check_link($text, $from){
    if(f("get_config")("allow_link",false)){
        $result = f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$from,
            'text'=>"pesan tidak boleh mengandung link: $text",
        ]);
        f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$from,
            'text'=>"ini: ".print_r($result, true),
        ]);
        return false;
    }
    return true;
}