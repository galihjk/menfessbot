<?php
function handle_callback_query($botdata){
    // if(!empty($botdata["message"])){
        
    // }
    if(!empty($botdata["data"])){
        f("bot_kirim_perintah")('answerCallbackQuery',[
            'callback_query_id' => $botdata['id'],
            'text'=> "Underconstruction:" . $botdata["data"],
            'show_alert'=>true,
        ]);
    }
    
    

}