<?php
function handle_message_start($botdata){
    f("db_connect")();
    file_put_contents("tesq",print_r(mysqli_query("select * from users"),true));
    $channel = f("get_config")("channel");
    $channel_url = f("channel_url")();
    $botuname = f("get_config")("botuname");
    $commentgroup = f("get_config")("commentgroup");
    $chat = $botdata["chat"];
    $chat_id = $chat["id"];
    $text = $botdata["text"] ?? "";
    if($text == "/start"){
        $textkirim = "<b>Kuota Gratis Harian</b>\n"
        ."Pesan: 0/15\n"
        ."Media: 0/0\n"
        ."\n"
        ."Kirim pesan kalian disini maka akan otomatis ter post di ch $channel $channel_url\n"
        ."\n"
        ."❌ Spam\n"
        ."❌ Porn\n"
        ."\n"
        ."👇Format:👇\n"
        ."#menfess Atau #random\n"
        ."\n"
        ."(Pesan)\n"
        ."\n"
        ."Contoh:\n"
        ."<pre>#random\n\nBla bla bla...</pre>\n...";
        f("bot_kirim_perintah")("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>$textkirim,
            "parse_mode"=>"HTML",
            "reply_markup"=>f("gen_inline_keyboard")([
                ['👤 Profil','profil'],
            ]),
        ]);

        return true;
    }
    return false;
}