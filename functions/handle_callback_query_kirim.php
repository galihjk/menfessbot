<?php
function handle_callback_query_kirim($botdata){
    if(!empty($botdata["data"]) 
    and f("str_is_diawali")($botdata["data"], "kirim_")
    and !empty($botdata["message"]["reply_to_message"])
    ){
        $datakirim = $botdata["message"]["reply_to_message"];
        $jenis = str_replace("kirim_","",$botdata["data"]);
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
            'text' => "SIAP!",
            'show_alert' => false,
        ]);
        $chat_id = $botdata["message"]["chat"]["id"];
        $message_id = $botdata["message"]["message_id"];
        $result = f("bot_kirim_perintah")("deleteMessage",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
        ]);
        if(!empty($result['ok'])){
            if($jenis == "text"){
                return f("handle_message_send_text")($datakirim);
            }
            else{
                $explode = explode("_",$jenis);
                if(!empty($explode[1])){
                    $jenis = $explode[0];
                    $fileid = $explode[1];
                    if(empty($jenis) or empty($fileid)){
                        return false;
                    }
                    else{
                        return f("handle_message_send_media")($datakirim, $jenis, $fileid);
                    }
                }
                else{
                    return false;
                }
            }
        }
        f("data_delete")("waitingsendconfirm$chat_id",0);
        return true;
    }
    elseif(!empty($botdata["data"]) 
    and $botdata["data"] == "kirimbatal"
    ){
        $datakirim = $botdata["message"]["reply_to_message"];
        $jenis = str_replace("kirim_","",$botdata["data"]);
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
            'text' => "Dibatalkan!",
            'show_alert' => false,
        ]);
        $chat_id = $botdata["message"]["chat"]["id"];
        $message_id = $botdata["message"]["message_id"];
        $result = f("bot_kirim_perintah")("deleteMessage",[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
        ]);
        f("data_delete")("waitingsendconfirm$chat_id",0);
        return true;
    }
    return false;
}