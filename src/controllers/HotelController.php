<?php

namespace App\Controllers;

use App\Models\Hotel;

class HotelController
{
    private $hotelModel;

    public function __construct()
    {
        $this->hotelModel = new Hotel();
    }

    public function createHotel()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'];
        $location = $data['location'];
        $roomsAvailable = $data['roomsAvailable'];
        $pricePerNight = $data['pricePerNight'];

        if (empty($name) || empty($location) || empty($roomsAvailable) || empty($pricePerNight)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->hotelModel->createHotel($name, $location, $roomsAvailable, $pricePerNight)) {
            http_response_code(201);
            echo json_encode(['message' => 'Hotel created successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create hotel.']);
        }
    }

    public function getHotelByName() {
        $requestData = json_decode(file_get_contents('php://input'), true); 
        // $name = $_POST['name'];
        $name = $requestData['name'];
        if (!isset($name)) {
            http_response_code(400);
            echo json_encode(['error' => 'Name parameter is required']);
            return;
        }
        

        $hotel = $this->hotelModel->getHotelByName($name);
        // hotelModel->getHotelByName($name);

        if ($hotel) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($hotel);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Hotel not found.']);
            echo json_encode(['message' => 'Hotel not found']);
        }
    }
    

    public function updateHotel($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'];
        $location = $data['location'];
        $roomsAvailable = $data['roomsAvailable'];
        $pricePerNight = $data['pricePerNight'];

        if (empty($name) || empty($location) || empty($roomsAvailable) || empty($pricePerNight)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->hotelModel->updateHotel($id, $name, $location, $roomsAvailable, $pricePerNight)) {
            http_response_code(200);
            echo json_encode(['message' => 'Hotel updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update hotel.']);
        }
    }

    public function deleteHotel($id)
    {
        if ($this->hotelModel->deleteHotel($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Hotel deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete hotel.']);
        }
    }
}
