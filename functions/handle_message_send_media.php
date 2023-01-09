<?php
function handle_message_send_media($botdata){
    $caption = $botdata["caption"] ?? "";
    if(empty($caption)) return false;
    $jenis = "";
    if(!empty($botdata['animation'])){
        $jenis = "animation";
    }
    elseif(!empty($botdata['audio'])){
        $jenis = "audio";
    }
    elseif(!empty($botdata['document'])){
        $jenis = "document";
    }
    elseif(!empty($botdata['photo'])){
        $jenis = "photo";
    }
    elseif(!empty($botdata['video'])){
        $jenis = "video";
    }
    elseif(!empty($botdata['voice'])){
        $jenis = "voice";
    }
    else{
        return false;
    }
    $fileid = "";
    if(!empty($botdata[$jenis]['file_id'])){
        $fileid = $botdata[$jenis]['file_id'];
    }
    elseif(!empty($botdata[$jenis][0]['file_id'])){
        $fileid = $botdata[$jenis][0]['file_id'];
    }
    else{
        file_put_contents("log/jenis_not_exists".date("Y-m-d-H-i").".txt", print_r($botdata,true));
    }
    $prefixes = f("get_config")("resend_prefixes",[]);
    foreach($prefixes as $prefix){
        if(f("str_is_diawali")($caption,$prefix)){
            $chat = $botdata["chat"];
            $chat_id = $chat["id"];
            $data_user = f("get_user")($botdata["from"]["id"]);

            $pesan_minchar = f("get_config")("pesan_minchar",0);
            $msgcharcount = strlen(str_replace($prefix, "", $caption));

            if($msgcharcount < $pesan_minchar){
                $textkirim = "Jumlah karakter pesan anda tidak boleh kurang dari $pesan_minchar";
                f("bot_kirim_perintah")("sendMessage",[
                    'chat_id'=>$chat_id,
                    'text'=>$textkirim,
                    "parse_mode"=>"HTML",
                ]);
                return true;
            }
            if(empty($data_user['vip_until'])){
                $pesan_maxchar = f("get_config")("pesan_maxchar",0);
                if($msgcharcount > $pesan_maxchar){
                    $textkirim = "Jumlah karakter pesan anda tidak boleh lebih dari $pesan_maxchar";
                    f("bot_kirim_perintah")("sendMessage",[
                        'chat_id'=>$chat_id,
                        'text'=>$textkirim,
                        "parse_mode"=>"HTML",
                    ]);
                    return true;
                }
                $media_max = f("get_config")("media_max",0);
            }
            else{
                //vip
                $media_max = f("get_config")("media_max_vip",0);
            }

            $free_media_used = $data_user['free_media_used'] ?? 0;

            $success_text = "";
            $sent_message_id = "";
            if($free_media_used < $media_max){
                $free_media_used++;
                f("db_q")("update users set free_media_used = $free_media_used where id = '$chat_id'");
                $channelpost = f("post_media_to_channel")($chat_id,$caption,$jenis,$fileid);
                $sent_message_id = $channelpost['result']['message_id'];
                $success_text = "<b>Berhasil!</b>\nSisa kuota gratis: ".($media_max-$free_media_used);
            }
            else{
                $biaya = f("get_config")("media_cost",0);
                $coin = $data_user['coin'] ?? 0;
                if($coin >= $biaya){
                    $coin -= $biaya;
                    f("db_q")("update users set coin=$coin where id='".$data_user['id']."'");
                    $channelpost = f("post_media_to_channel")($chat_id,$caption,$jenis,$fileid);
                    $sent_message_id = $channelpost['result']['message_id'];
                    $success_text = "<b>Berhasil!</b>\nBiaya: $biaya 🪙\nSisa: $coin 🪙";
                }
                else{
                    f("bot_kirim_perintah")("sendMessage",[
                        'chat_id'=>$chat_id,
                        'text'=>"Gagal, tidak ada jatah gratis dan koin tidak cukup.",
                        "parse_mode"=>"HTML",
                        "reply_to_message_id"=>$botdata["message"]["message_id"],
                    ]);
                }
            }
            if(!empty($success_text) and !empty($sent_message_id)){
                $channelurl = f("channel_url")("/$sent_message_id");
                f("bot_kirim_perintah")("sendMessage",[
                    'chat_id'=>$chat_id,
                    'text'=>$success_text,
                    "parse_mode"=>"HTML",
                    'reply_markup'=>f("gen_inline_keyboard")([
                        ['🔗 Lihat Pesan', $channelurl,2],
                        ["📌 PIN Pesan", 'pin_'.$sent_message_id,1],
                        ["Cek Biaya 📌PIN ", 'pin_harga',1],
                    ]),
                ]);
            }
            return true;
        }
    }
    return false;
}