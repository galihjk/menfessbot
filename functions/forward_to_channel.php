<?php
function forward_to_channel($from, $text, $msgid){
    if(f("check_word_filter")($text, $from)){
        $botuname = f("get_config")("botuname","");
        $channel = f("get_config")("channel","");
        $last_send = f("str_dbtime")();
        f("db_q")("update users set last_send=$last_send where id='$from'");

        $resend_mode = f("get_config")("resend_mode","");

        if($resend_mode == 'forward'){
            return f("bot_kirim_perintah")("forwardMessage",[
                'chat_id'=>$channel,
                'from_chat_id'=>$from,
                'message_id'=>$textkirim,
            ]);
        }
        elseif($resend_mode == 'resend'){
            $sender_encrypt = f("str_encrypt")("$from",true);
            $textkirim = $text."<a href='https://t.me/$botuname?start=$sender_encrypt'> 󠀠 </a>";
            return f("bot_kirim_perintah")("sendMessage",[
                'chat_id'=>$channel,
                'text'=>$textkirim,
                "parse_mode"=>"HTML",
                "disable_web_page_preview"=>true,
            ]);
        }
        else{
            foreach(f("get_config")("bot_admins",[]) as $chatidadmin){
                f("bot_kirim_perintah")("sendMessage",[
                    'chat_id'=>$chatidadmin,
                    'text'=>"Invalid resend_mode = '$resend_mode'",
                ]);
            };
        }

    }
    else{
        return false;
    }
}