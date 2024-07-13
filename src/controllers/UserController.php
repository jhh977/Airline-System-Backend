<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Handle user registration
    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'] ;
        $email = $data['email'] ;
        $password = $data['password'] ;
        $phoneNumber = $data['phoneNumber'] ;

        if (empty($name) || empty($email) || empty($password) || empty($phoneNumber)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid email format.']);
            return;
        }

        if (strlen($password) < 6) {
            http_response_code(400);
            echo json_encode(['message' => 'Password must be at least 6 characters long.']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->userModel->createUser($name, $email, $hashedPassword, $phoneNumber)) {
            http_response_code(201);
            echo json_encode(['message' => 'User registered successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to register user.']);
        }
    }

    // Handle user login
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['message' => 'Email and password are required.']);
            return;
        }

        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Assuming you are setting a session for the logged-in user
            session_start();
            $_SESSION['user_id'] = $user['id'];
            http_response_code(200);
            echo json_encode(['message' => 'Login successful.']);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid email or password.']);
        }
    }
}