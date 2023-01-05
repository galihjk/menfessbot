<?php 
function handle_update_sesuai_jenis($jenis){
    $update = json_decode(file_get_contents("php://input"), TRUE);
    foreach($jenis as $item_jenis){
        if(!empty($update[$item_jenis])){
            f("handle_$item_jenis")($update[$item_jenis]);
            return true;
        }
    }
    file_put_contents("log/unhandled_".date("Y-m-d-H-i").".txt", file_get_contents("php://input"));
    return false;
}
/*
{
  "update_id": 732119727,
  "my_chat_member": {
    "chat": {
      "id": 2063236800,
      "first_name": "Jaya2nti",
      "username": "Jaya2nti",
      "type": "private"
    },
    "from": {
      "id": 2063236800,
      "is_bot": false,
      "first_name": "Jaya2nti",
      "username": "Jaya2nti",
      "language_code": "id"
    },
    "date": 1672908506,
    "old_chat_member": {
      "user": {
        "id": 5687994870,
        "is_bot": true,
        "first_name": "fwxy",
        "username": "fwxyzbot"
      },
      "status": "member"
    },
    "new_chat_member": {
      "user": {
        "id": 5687994870,
        "is_bot": true,
        "first_name": "fwxy",
        "username": "fwxyzbot"
      },
      "status": "kicked",
      "until_date": 0
    }
  }
}
*/