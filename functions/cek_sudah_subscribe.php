<?php
function cek_sudah_subscribe($userid){
    $channel = f("get_config")("channel");
    $force_sub = f("get_config")("force_sub");
    $user = f("get_user")($userid);
    if(empty($user['bot_active']) or
    (!empty($user['bot_active']) and date("YmdH") != date("YmdH",strtotime($user['bot_active'])))
    ){
        $harusjoin = [];
        foreach($force_sub as $forcesubid){
            $getChatMember = f("bot_kirim_perintah")("getChatMember",[
                'chat_id'=>$forcesubid,
                'user_id'=>$userid,
            ]);
            if(empty($getChatMember["result"]["status"])){
                file_put_contents("Last Error empty status1.txt",print_r([$getChatMember, $userid, $user],true));
                die("Error empty status");
            }
            if(in_array($chatmemberchannel["result"]["status"],["restricted","left","kicked"])){
                $chatinfo = f("bot_kirim_perintah")("getChat",[
                    "chat_id"=>$forcesubid,
                ]);
                if(!empty($chatinfo['result']['username'])){
                    $harusjoin[] = "@" . $chatinfo['result']['username'];
                }
                elseif(!empty($chatinfo['result']['title'])){
                    $harusjoin[] = $chatinfo['result']['title'];
                }
                else{
                    f("bot_kirim_perintah")("sendMessage",[
                        "chat_id"=>$userid,
                        "text"=>"Maaf, error! \n".print_r($chatinfo,true),
                    ]);
                    return false;
                }
            }
        }
        if(empty($harusjoin)){
            return true;
        }
        else{
            $textkirim = "Join ke sini dulu yaa:\n";
            foreach($harusjoin as $item){
                $textkirim .= "- $item\n";
            }
            $textkirim .= "\nAbis itu ke sini lagi.. :D \n/start";
            f("bot_kirim_perintah")("sendMessage",[
                "chat_id"=>$userid,
                "text"=>$textkirim,
            ]);
            return false;
        }
    }
}