<?php
function handle_message($botdata){
    if(f("is_private")($botdata)){
        $chat_id = $botdata["chat"]["id"];
        if(f("cek_sudah_subscribe")($chat_id)){
            $banned = false;
            if(!empty($botdata["from"])){
                $userdata = f("get_user")($chat_id);
                if(!empty($userdata["banned"])){
                    f("bot_kirim_perintah")("sendMessage",[
                        "chat_id"=>$chat_id,
                        "text"=>"Your user account ($chat_id) is banned. Please contact administrator.",
                    ]);
                    $banned = true;
                }
                else{
                    f("update_user")($botdata["from"]);
                }
            }
            if(!$banned){
                f("handle_botdata_functions")($botdata,[
                    "handle_message_adm_fwdinfo",
                    "handle_message_start",
                    "handle_message_send_text",
                    "handle_message_send_media",
                    "handle_message_admin",
                    "handle_message_adm_topup",
                    "handle_message_adm_user",
                    "handle_message_adm_ban",
                    "handle_message_adm_broadcast",
                    "handle_message_fail",
                ]);
            }
        }
    }
    elseif($chat_id == f("get_config")("groupdisc")){
        $text = $botdata["text"] ?? "";
        if($text){
            $reply_to_message = $botdata['reply_to_message'];
            $entities = $reply_to_message['entities'];
            $oleh = "";
            foreach($entities as $entity){
                if($entity['type'] == "text_link"){
                    $botuname = f("get_config")("botuname","");
                    $oleh = f("str_decrypt")(str_replace("https://t.me/$botuname?start=","",$entity['url']),true);
                    break;
                }
            }
            $komentator = $botdata['from']['first_name'] . (empty($botdata['from']['username'])?'':" (@".$botdata['from']['username'].")");
            $url = f("channel_url")("/$reply_to_message?comment=".$botdata['message_id']);
            f("bot_kirim_perintah")("sendMessage",[
                "chat_id"=>$oleh,
                "text"=>"$komentator memberikan <a href='$url'>komentar</a> untuk mu.",
                "parse_mode"=>"HTML",
            ]);
        }
    }
    else{
        f("bot_kirim_perintah")("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>"yuk, ke sini ==> $channel",
        ]);
    }
}