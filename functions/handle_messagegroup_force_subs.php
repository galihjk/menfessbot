<?php
function handle_messagegroup_force_subs($botdata){
    foreach(f("get_config")("force_subs",[]) as $item){
        if(f("str_is_diawali")($item,"-")){
            $chat_id = $botdata["chat"]["id"];
            if($chat_id == $item){
                return true;
            }
        }
    }
    return false;
}