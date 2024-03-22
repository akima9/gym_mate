<?php

namespace App\Dtos;

use App\Dtos\BaseDto;

class ChatDto extends BaseDto
{
    protected $id;
    protected $chat_room_id;
    protected $send_user_id;
    protected $receive_user_id;
    protected $message;
    protected $created_at;
    protected $updated_at;

    public function __construct($request)
    {
        $this->bindToDto($request);
    }


}
