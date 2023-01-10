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
    elseif($botdata["chat"]["id"] == f("get_config")("groupdisc")){
        // file_put_contents("log/groupdisc".date("Y-m-d-H-i").".txt", print_r($botdata,true));
        $text = $botdata["text"] ?? "";
        if($text){
            $reply_to_message = $botdata['reply_to_message'];
            if(!empty($reply_to_message["caption_entities"])){
                $entities = $reply_to_message["caption_entities"];
            }
            else{
                $entities = $reply_to_message['entities'] ?? [];
            }
            
            $reply_to_message_id = $reply_to_message['forward_from_message_id'] ?? [];
            $oleh = "";
            // file_put_contents("log/groupdiscuserentities".date("Y-m-d-H-i").".txt", print_r([$reply_to_message, $reply_to_message['entities'], $entities],true));
            foreach($entities as $entity){
                if($entity['type'] == "text_link"){
                    $botuname = f("get_config")("botuname","");
                    // file_put_contents("log/groupdiscuser".date("Y-m-d-H-i").".txt", print_r([$entity['url'],str_replace("https://t.me/$botuname?start=","",$entity['url']),f("str_decrypt")(str_replace("https://t.me/$botuname?start=","",$entity['url']),true)],true));
                    $oleh = f("str_decrypt")(str_replace("https://t.me/$botuname?start=","",$entity['url']),true);
                    break;
                }
            }
            if(!empty($botdata['from']['username']) and strtolower($botdata['from']['username']) == strtolower('GroupAnonymousBot')){
                $komentator = f("get_config")("channel");
            }
            else{
                $komentator = $botdata['from']['first_name'] . (empty($botdata['from']['username'])?'':" (@".$botdata['from']['username'].")");
            }
            $url = f("channel_url")("/$reply_to_message_id?comment=".$botdata['message_id']);
            if($oleh){
                f("bot_kirim_perintah")("sendMessage",[
                    "chat_id"=>$oleh,
                    "text"=>"$komentator memberikan <a href='$url'>komentar</a> untuk mu.",
                    "parse_mode"=>"HTML",
                ]);
            }
        }
    }
    else{
        if(!empty($chat_id)){
            f("bot_kirim_perintah")("sendMessage",[
                "chat_id"=>$chat_id,
                "text"=>"yuk, ke sini ==> ".f("get_config")("channel"),
            ]);
            f("bot_kirim_perintah")("leaveChat",[
                "chat_id"=>$chat_id,
            ]);
        }
        else{
            file_put_contents("log/unhandleMsg".date("Y-m-d-H-i").".txt", print_r($botdata,true));
        }
    }
}