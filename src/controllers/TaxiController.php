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

    public function createTaxi()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $licensePlate = $data['licensePlate'];
        $driverName = $data['driverName'];
        $driverPhoneNumber = $data['driverPhoneNumber'];
        $status = $data['status'];

        if (empty($licensePlate) || empty($driverName) || empty($driverPhoneNumber) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->taxiModel->createTaxi($licensePlate, $driverName, $driverPhoneNumber, $status)) {
            http_response_code(201);
            echo json_encode(['message' => 'Taxi created successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create taxi.']);
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
        $taxi= $this->taxiModel->getTaxiById($city);
    if ($taxi) {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($taxi);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Hotel not found.']);
     
    }
}
    public function updateTaxi($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $licensePlate = $data['licensePlate'];
        $driverName = $data['driverName'];
        $driverPhoneNumber = $data['driverPhoneNumber'];
        $status = $data['status'];

        if (empty($licensePlate) || empty($driverName) || empty($driverPhoneNumber) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->taxiModel->updateTaxi($id, $licensePlate, $driverName, $driverPhoneNumber, $status)) {
            http_response_code(200);
            echo json_encode(['message' => 'Taxi updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update taxi.']);
        }
    }

    public function deleteTaxi($id)
    {
        if ($this->taxiModel->deleteTaxi($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Taxi deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete taxi.']);
        }
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
}
