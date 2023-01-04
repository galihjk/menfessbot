<?php
function pesan_utama($datakirim, $datavar = []){
    $sisa_pesan = $datavar['sisa_pesan'] ?? 0;
    $pesan_max = f("get_config")("pesan_max",15);
    $sisa_media = $datavar['sisa_media'] ?? 0;
    $media_max = f("get_config")("media_max",0);
    $channel = f("get_config")("channel");
    $textkirim = "<b>Kuota Gratis Harian</b>\n"
    ."Pesan: $sisa_pesan/$sisa_pesan_max\n"
    ."Media: $sisa_media/$sisa_media_max\n"
    ."\n"
    ."Kirim pesan kalian disini maka akan otomatis ter post di ch $channel\n"
    ."\n"
    ."❌ Spam\n"
    ."❌ Porn\n"
    ."\n"
    ."👇Format:👇\n"
    ."(#menfess Atau #random)(enter)\n"
    ."(enter)\n"
    ."(Pesan)\n"
    ."\n"
    ."Contoh (bisa dicopy):\n===============\n"
    ."<pre>#random\n\nBlablabla...</pre>\n===============";
    $datakirim['text'] = $textkirim;
    $datakirim['parse_mode'] = "HTML";
    $datakirim['reply_markup'] = f("gen_inline_keyboard")([
        ['👤 Profil','profil'],
    ]);
    return $datakirim;
}