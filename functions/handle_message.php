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
    elseif($chat_id == $commentgroup){
        $text = $botdata["text"] ?? "";
        if($text){
            $reply_to_message = $botdata['reply_to_message'];
            $entities = $reply_to_message['entities'];
            foreach($entities as $entity){
                if(!empty($entity['url'])
                and f("str_is_diawali")($entity['url'], "http://t.me/curcolanonimbot?start=lapor_")
                ){
                    $kode = str_replace("http://t.me/curcolanonimbot?start=lapor_","",$entity['url']);
                    $explode = explode("_",$kode);
                    $msgid_curhat = (int)$explode[1]-999;
                    $curhater = strrev($explode[0].$explode[2]);
                    $url = str_replace("@","https://t.me/",$channel)."/$msgid_curhat?comment=".$botdata['message_id'];
                    f("bot_kirim_perintah")("sendMessage",[
                        "chat_id"=>$curhater,
                        "text"=>"Ada <a href='$url'>komentar</a> untuk mu. \n<i>*Balas di sini untuk mengirim pesan secara anonim</i>.\n~".$botdata['message_thread_id'],
                        "parse_mode"=>"HTML",
                        "reply_markup"=>['force_reply' => true,],
                    ]);
                }
            }
        }
    }
    else{
        f("bot_kirim_perintah")("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>"yuk, ke sini ==> $channel",
        ]);
    }
}