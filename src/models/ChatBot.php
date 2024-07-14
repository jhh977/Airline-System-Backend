<?php

namespace App\Models;

class ChatBot
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }
    
    private function connect()
    {
        $config = require __DIR__ . '/../../config/config.php';
        return $mysqli;
    }
    
    public function loadChat($user_id){
    $stmt = $this->db->prepare("SELECT * FROM user_chats WHERE user_id = ? ORDER BY ID ASC;");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chatHistory = [];
    
    while ($row = $result->fetch_assoc()) {
        $chatHistory[] = $row;
    }
    return $chatHistory;
}


    public function storeChatInDb($user_id,$message,$response){
        $stmt = $this->db->prepare("INSERT INTO user_chats(user_id,user_message,chatbot_message) VALUES(?,?,?)");
        $stmt->bind_param("iss", $user_id,$message,$response);
        return $stmt->execute();
    }
}