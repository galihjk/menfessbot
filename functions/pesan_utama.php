<?php
function pesan_utama($datakirim, $datavar = []){
    $sisa_pesan = $datavar['sisa_pesan'] ?? 0;
    $pesan_max = f("get_config")("pesan_max",15);
    $sisa_media = $datavar['sisa_media'] ?? 0;
    $media_max = f("get_config")("media_max",0);
    $textkirim = "<b>Kuota Gratis Harian</b>\n"
    ."Pesan: $sisa_pesan/$pesan_max\n"
    ."Media: $sisa_media/$media_max\n"
    ."\n".f("get_config")("msg_home","");
    $datakirim['text'] = $textkirim;
    $datakirim['parse_mode'] = "HTML";
    $datakirim['reply_markup'] = f("gen_inline_keyboard")([
        ['👤 Profil','profil'],
        ['ℹ️ Informasi','info'],
    ]);
    return $datakirim;
}