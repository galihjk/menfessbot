<?php
function channel_url(){
    $channel = f("get_config")("channel");
    return str_replace("@","https://t.me/",$channel);
}