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
}
