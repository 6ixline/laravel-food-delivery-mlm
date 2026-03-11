<?php


namespace App\DTO;


class BaseResponseDTO{
  
    public array $data;
    public string $message;
    public string $status;
    
    public function __construct($status, $message, $data = []){
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }


}