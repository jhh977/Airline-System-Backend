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

    public function handleCreateHotelBooking() {
            // Decode JSON input
            $data = json_decode(file_get_contents('php://input'), true);
            $hotel_id = $data['hotel_id'];
            $checkin_date = $data['checkin_date'];
            $checkout_date = $data['checkout_date'];
            $room_type = $data['room_type'];
            $num_guests = $data['num_guests'];
            $price = $data['price'];
        
            // Call the model method to create the booking
            $insertedId = $this->hotelModel->createHotelBooking($hotel_id, $checkin_date, $checkout_date, $room_type, $num_guests, $price);
        
            // Check if the booking was successfully created
            if (is_numeric($insertedId)) {
                $_SESSION['hotel_booking_id'] = $insertedId;
                $_SESSION['hotel_booking_price']=$price;
                echo json_encode(['message' => 'Hotel booked!', 'hotel_booking_id' => $insertedId]);
            } else {
                echo json_encode(['message' => 'Failed to insert hotel booking.']);
            }
        }
    public function getHotelByName() {
        $requestData = json_decode(file_get_contents('php://input'), true); 
        $name = $requestData['name'];
        
        if (!isset($name)) {
            http_response_code(400);
            echo json_encode(['error' => 'Name parameter is required']);
            return;
        }
        

        $hotel = $this->hotelModel->getHotelByLocation($name);
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


    
    
}
