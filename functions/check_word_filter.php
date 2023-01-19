<?php
function check_word_filter($word, $from){
    $wordfilter = strtolower(f("get_config")("wordfilter",""));
    $wordfilterarr = explode(",",$wordfilter);
    $word1 = " ".strtolower(preg_replace('/[^a-zA-Z]/', " ", $word))." ";
    foreach($wordfilterarr as $item){
        if(f("str_contains")($word1, " $item ")
        or f("str_contains")(" $word ", " $item ")
        ){
            f("bot_kirim_perintah")("sendMessage",[
                'chat_id'=>$from,
                'text'=>"Gagal, pesan tidak boleh mengandung kata '$item'.",
                "parse_mode"=>"HTML",
            ]);
            return false;
        }
    }
    return true;
}