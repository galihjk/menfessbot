<?php
function post_to_channel($botdata, $type, $fileid = ""){
    if($type == 'text'){
        $text = $botdata["text"];
    }
    else{
        $text = $botdata["caption"];
    }
    $text = str_replace("<","&lt;",$text);
    $chat_id = $botdata["chat"]["id"];
    if(f("check_word_filter")($text, $chat_id) and f("check_link")($text, $chat_id)){
        $resend_mode = f("get_config")("resend_mode","");
        $message_id = $botdata["message_id"];
        $last_send = f("str_dbtime")();
        f("db_q")("update users set last_send=$last_send where id='$chat_id'");
        if($resend_mode == 'forward'){
            $channel = f("get_config")("channel","");
            return f("bot_kirim_perintah")("forwardMessage",[
                'chat_id'=>$channel,
                'from_chat_id'=>$chat_id,
                'message_id'=>$message_id,
            ]);
        }
        elseif($resend_mode == 'resend'){
            if($type == "text"){
                return f("post_text_to_channel")($chat_id,$text);
            }
            else{
                return f("post_media_to_channel")($chat_id,$text,$type,$fileid);
            }
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
    return false;
}