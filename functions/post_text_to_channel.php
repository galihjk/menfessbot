<?php
function post_text_to_channel($from, $text){
    $botuname = f("get_config")("botuname","");
    $channel = f("get_config")("channel","");
    $sender_encrypt = f("str_encrypt")("$from",true);
    $textkirim = $text."<a href='https://t.me/$botuname?start=$sender_encrypt'> 󠀠 </a>";
    $last_send = f("str_dbtime")();
    f("db_q")("update users set last_send=$last_send where id='$from'");
    return f("bot_kirim_perintah")("sendMessage",[
        'chat_id'=>$channel,
        'text'=>$textkirim,
        "parse_mode"=>"HTML",
        "disable_web_page_preview"=>true,
    ]);
}