<?php

namespace App\Controllers;

use App\Models\Taxi;

class TaxiController
{
    private $taxiModel;

    public function __construct()
    {
        $this->taxiModel = new Taxi();
    }

    

    public function handleCreateTaxiBooking(){
        $data = json_decode(file_get_contents('php://input'), true);
        $taxi_id = $data['taxi_id'];
        $pickup_location = $data['pickup_location'];
        $dropoff_location = $data['dropoff_location'];
        $pickup_time = $data['pickup_time'];
        $dropoff_time = $data['dropoff_time'];
        $price = $data['price'];
        $insertedId = $this->taxiModel->createTaxiBooking($taxi_id, $pickup_location, $dropoff_location, $pickup_time, $dropoff_time, $price);
        if (is_numeric($insertedId)) {
            $_SESSION['taxi_booking_id'] = $insertedId;
            $_SESSION['taxi_booking_price']= $price;
            echo json_encode(['message' => 'Taxi booked!']);
        } else {
            echo json_encode(['message' => 'Failed to insert taxi booking.']);
        }
    }

    public function getTaxiByName()
        {
            $requestCity=json_decode(file_get_contents('php://input'),true);
            // $city=$_POST['name'];
            $city=$requestCity['name'];
            if(!isset($city)){
                http_response_code(400);
                echo json_encode(['error' => 'Name parameter is required']);
                return;
            }
            $taxi= $this->taxiModel->getTaxiByLocation($city);
        if ($taxi) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($taxi);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Hotel not found.']);
        
        }
    }
}