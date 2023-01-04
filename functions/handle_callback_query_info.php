<?php
function handle_callback_query_info($botdata){
    if(!empty($botdata["data"]) 
    and $botdata["data"] == "info"
    and !empty($botdata["message"])
    ){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
        ]);
        $pesan_max = f("get_config")("pesan_max",15);
        $media_max = f("get_config")("media_max",0);
        $pesan_cost = f("get_config")("pesan_cost",20);
        $media_cost = f("get_config")("media_cost",100);

        $message_id = $botdata["message"]["message_id"];
        $chat_id = $botdata["message"]["chat"]["id"];
        $textkirim = "<b>Kuota Gratis Harian dan Biaya</b>\n";
        $textkirim .= "Pesan: $pesan_max ( $pesan_cost Koin )\n";
        $textkirim .= "Media: $media_max  ( $media_cost  Koin )\n";
        $textkirim .= "Jika batas kuota harian habis maka akan membutuhkan biaya koin menfess tiap pengiriman.\n";
        $textkirim .= "\n";
        $textkirim .= "<i>Aturan mungkin bisa berubah sewaktu-waktu</i>";
        f("bot_kirim_perintah")("editMessageText",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>$textkirim,
            "parse_mode"=>"HTML",
            'reply_markup'=>f("gen_inline_keyboard")([
                ['⬅️ Kembali', 'home']
            ]),
        ]);
        return true;
    }
    return false;
}