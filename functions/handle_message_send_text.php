<?php
function handle_message_send_text($botdata){
    $text = $botdata["text"] ?? "";
    $prefixes = f("get_config")("resend_prefixes",[]);
    foreach($prefixes as $prefix){
        if(f("str_is_diawali")($text,$prefix)){
            $chat = $botdata["chat"];
            $chat_id = $chat["id"];
            $data_user = f("get_user")($botdata["from"]["id"]);

            if(!empty($data_user['vip_until'])){
                //vip
                $pesan_max = f("get_config")("pesan_max_vip",0);
            }
            else{
                $pesan_max = f("get_config")("pesan_max",0);
            }
            $free_msg_used = $data_user['free_msg_used'] ?? 0;

            if($free_msg_used < 0){
                $free_msg_used--;
                f("db_q")("update users set free_msg_used = $free_msg_used where id = '$chat_id'");
                $channelpost = f("post_text_to_channel")($chat_id,$text);
                $sent_message_id = $channelpost['result']['message_id'];
                $channelurl = f("channel_url")("/$sent_message_id");
                $textkirim = "<a href='$channelurl'>Berhasil!</a>";
                f("bot_kirim_perintah")("sendMessage",[
                    'chat_id'=>$chat_id,
                    'text'=>$textkirim,
                    "parse_mode"=>"HTML",
                ]);
            }
            else{
                $biaya = $pesan_max = f("get_config")("pesan_cost",0);
                $coin = $data_user['coin'] ?? 0;
                if($coin >= $biaya){
                    $textkirim = "under: $coin >= $biaya";
                    f("bot_kirim_perintah")("sendMessage",[
                        'chat_id'=>$chat_id,
                        'text'=>$textkirim,
                        "parse_mode"=>"HTML",
                    ]);
                }
                else{
                    f("bot_kirim_perintah")("sendMessage",[
                        'chat_id'=>$chat_id,
                        'text'=>"Gagal, jatah gratis sudah habis dan koin tidak cukup.",
                        "parse_mode"=>"HTML",
                        "reply_to_message_id"=>$botdata["message"]["message_id"],
                    ]);
                }
            }
            return true;
        }
    }
    return false;
}