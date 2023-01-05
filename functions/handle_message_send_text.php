<?php
function handle_message_send_text($botdata){
    $text = $botdata["text"] ?? "";
    $prefixes = f("get_config")("resend_prefixes",[]);
    foreach($prefixes as $prefix){
        if(f("str_is_diawali")($text,$prefix)){
            $chat = $botdata["chat"];
            $chat_id = $chat["id"];
            $data_user = f("get_user")($botdata["from"]["id"]);
            $free_msg = $data_user['free_msg'] ?? 0;
            if($free_msg > 0){
                $free_msg--;
                f("db_q")("update users set free_msg = $free_msg where id = '$chat_id'");
                $textkirim = "Berhasil!";
                f("bot_kirim_perintah")("sendMessage",[
                    'chat_id'=>$chat_id,
                    'text'=>$textkirim,
                    "parse_mode"=>"HTML",
                    'reply_markup'=>f("gen_inline_keyboard")([
                        ['🏠 Menu Utama', 'home'],
                    ]),
                ]);
                $botuname = f("get_config")("botuname","");
                $sender_encrypt = f("str_encrypt")("$chat_id",true);
                // $textkirim = str_replace($prefix,"<a href='https://t.me/$botuname?start=$sender_encrypt'>".$prefix."</a>",$text);
                $textkirim = $text."<a href='https://t.me/$botuname?start=$sender_encrypt'> 󠀠 </a>";
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
            return true;
        }
    }
    return false;
}