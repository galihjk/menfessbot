<?php
function cek_sudah_subscribe($userid){
    $channel = f("get_config")("channel");
    $group = f("get_config")("group");
    $chatmemberchannel = f("bot_kirim_perintah")("getChatMember",[
        'chat_id'=>$channel,
        'user_id'=>$userid,
    ]);
    if(empty($chatmemberchannel["result"]["status"])){
        file_put_contents("LAST_ERROR.txt","Error empty status1");
        die("Error empty status");
    }
    if(in_array($chatmemberchannel["result"]["status"],["restricted","left","kicked"])){
        $chatmemberchanneljoin = false;
    }
    else{
        $chatmemberchanneljoin = true;
    }
    $chatmembergroup = f("bot_kirim_perintah")("getChatMember",[
        'chat_id'=>$group,
        'user_id'=>$userid,
    ]);;
    if(empty($chatmembergroup["result"]["status"])){
        file_put_contents("LAST_ERROR.txt","Error empty status2");
        die("Error empty status2");
    }
    if(in_array($chatmembergroup["result"]["status"],["restricted","left","kicked"])){
        $chatmembergroupjoin = false;
    }
    else{
        $chatmembergroupjoin = true;
    }
    if($chatmemberchanneljoin and $chatmembergroupjoin){
        return true;
    }
    else{
        $harusjoin = [];
        if(!$chatmemberchanneljoin) $harusjoin[] = $channel;
        if(!$chatmembergroupjoin){
            $chatinfo = f("bot_kirim_perintah")("getChat",[
                "chat_id"=>$group,
            ]);
            if(!empty($chatinfo['result']['username'])){
                $harusjoin[] = "@" . $chatinfo['result']['username'];
            }
            else{
                $harusjoin[] = $chatinfo['result']['title'];
            }
            
        } 
        f("bot_kirim_perintah")("sendMessage",[
            "chat_id"=>$userid,
            "text"=>"Join ".implode(" dan ",$harusjoin)." dulu yaa! Abis itu ke sini lagi.. :D \n/start",
        ]);
        return false;
    }
}