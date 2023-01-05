<?php
function handle_message_adm_topup1($botdata){
    if(!empty($botdata['reply_to_message']['text'])
    and in_array($botdata["from"]["id"], f("get_config")("bot_admins",[]))
    and f("str_contains")($botdata['reply_to_message']['text'], "Proses TOP UP (1/3)")){
        $text = $botdata["text"] ?? "";
        $chat = $botdata["chat"];
        $chat_id = $chat["id"];

        $usertopup = f("get_user")($text);

        if(empty($usertopup["first_name"])){
            $textkirim = "<b>Proses TOP UP (1/3)</b>\n";
            $textkirim .= "Pengguna dengan ID [$text] tidak ditemukan, silakan coba lagi.";
            f("bot_kirim_perintah")("sendMessage",[
                'chat_id'=>$chat_id,
                'text'=>$textkirim,
                "parse_mode"=>"HTML",
                'reply_markup' => [
                    'force_reply'=>true,
                    'input_field_placeholder'=>'ID Pengguna',
                ],
            ]);
        }
        else{
            $nama = $usertopup["first_name"] . (empty($usertopup["first_name"]) ? '' : "(@".$usertopup["username"]." )");
            $textkirim = "<b>Proses TOP UP (2/3)</b>\n";
            $textkirim .= "Balas pesan ini dengan <b>nominal</b> 🪙Koin yang akan ditambahkan untuk pengguna dengan \n";
            $textkirim .= "ID: [$text]\nNama: $nama \n<i>*Balas dengan angka saja</i>";
            f("bot_kirim_perintah")("sendMessage",[
                'chat_id'=>$chat_id,
                'text'=>$textkirim,
                "parse_mode"=>"HTML",
                'reply_markup' => [
                    'force_reply'=>true,
                    'input_field_placeholder'=>'Jumlah Koin',
                ],
            ]);
        }
        return true;
    }
    return false;
}