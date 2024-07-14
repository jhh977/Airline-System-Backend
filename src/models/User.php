<?php

namespace App\Models;

class User
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

    /**
     * Create a new user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $phoneNumber
     * @param string $user_type 
     * @return bool
     */

    public function createUser($name, $email, $password, $phoneNumber)
    {
        $user_type="user";
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, phone_number,user_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password, $phoneNumber,$user_type);
        return $stmt->execute();
    }

    /**
     * Get a user by email
     *
     * @param string $email
     * @return array|null
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get a user by ID
     *
     * @param int $id
     * @return array|null
     */
}