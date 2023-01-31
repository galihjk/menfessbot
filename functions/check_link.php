<?php
function check_link($text, $from){
    if(f("get_config")("allow_link",false)){
        $result = f("bot_kirim_perintah")("sendMessage",[
            'chat_id'=>$from,
            'text'=>$text,
        ]);
        if(!empty($result['result']['entities'])){
            foreach($result['result']['entities'] as $ent){
                if(!empty($ent['type']) and $ent['type'] == 'url'){
                    f("bot_kirim_perintah")("editMessageText",[
                        'chat_id'=>$from,
                        'message_id'=>$result['result']['message_id'],
                        'text'=>"Pesan tidak boleh mengandung link "
                            .substr($result['result']['text'],$ent['offset'],$ent['length']),
                        "parse_mode"=>"HTML",
                        "disable_web_page_preview"=>true,
                    ]);
                    return false;
                }
            }
        }
        f("bot_kirim_perintah")("deleteMessage",[
            'chat_id'=>$from,
            'message_id'=>$result['result']['message_id'],
        ]);

    }
    return true;
}