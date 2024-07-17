<?php

namespace App\Services;

use App\Models\ChatBot;
//use Dotenv\Dotenv;

//$dotenv = Dotenv::createImmutable(__DIR__);
//$dotenv->load();


class ChatBotService
{
    private $apiKey;
    private $endpoint;
    private $headers;
    private $model;
    private $chatBotModel;

    public function __construct()
    {
        session_start();
        //$this->apiKey = $_ENV['OPENAI_API_KEY'];;
        $this->apiKey="sk-proj-Aipe7uZ3TkOh1sVA72IqT3BlbkFJA5f1uFownfs7cO1SxM0G";
        $this->endpoint = 'https://api.openai.com/v1/chat/completions';
        $this->model = 'gpt-3.5-turbo'; 
        $this->chatBotModel = new ChatBot();

        // Set the headers
        $this->headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        );
    }

    public function getBotResponse() {
        header('Content-Type: application/json');  
    
        // Retrieve and decode the JSON request body
        $userData = json_decode(file_get_contents('php://input'), true);
        //$userData=$_POST;
        //$userData['content']='hello';
        // Check if the message is provided in the request
        if (!isset($userData['msg'])) {
            echo json_encode(['error' => 'No message provided']);
            return;
        }
    
        // Extract the user message
        $msg = $userData['msg'];
        //echo $msg;
        //$msg="hi";
        // Construct the data payload for the API request
        $data = array(
            'model' => $this->model,  // Set the OpenAI model
            'messages' => array(  // Construct the messages array
                array(
                    'role' => 'user',  // User's role
                    'content' => $msg   // Content of the user message
                )
            )
        );
    
        // Convert the data to JSON
        $jsonData = json_encode($data);
    
        // Initialize cURL session
        $ch = curl_init();
    
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            echo json_encode(['error' => $error]);
            return;
        }
    
        // Close the cURL session
        curl_close($ch);
    
        // Decode the API response
        $result = json_decode($response, true);
    
        if (isset($result['choices'])) {
            // Access the generated message
            $reply = $result['choices'][0]['message']['content'];
    
            // Attempt to store the chat history in the database
            //if ($this->chatBotModel->storeChatInDb($_SESSION['loggedUserID'], $msg, $reply)) {
            if ($this->chatBotModel->storeChatInDb('1', $msg, $reply)) {
                // Return the bot response as JSON
                echo json_encode(['response' => $reply]);
            } else {
                // Return a message indicating failure to store chat history
                echo json_encode(['error' => 'Could not store message and response in the database']);
            }
        } else {
            // Return the entire API response for debugging
            echo json_encode(['error' => 'Invalid response from API', 'response' => $result]);
        }
    }     

    public function getChatHistory(){
        $chatHistory = $this->chatBotModel->loadChat('1');
        if ($chatHistory) {
            // Return the chat history as JSON
            echo json_encode($chatHistory);
        } else {
            // Return a message indicating no history as JSON
            echo json_encode(['message' => 'This user has no chat history']);
        }
    }

}
?>
