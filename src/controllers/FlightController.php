<?php

namespace App\Controllers;

use App\Models\Flight;

class FlightController
{
    private $flightModel;

    public function __construct()
    {
        $this->flightModel = new Flight();
    }

    public function createFlight()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $flightNumber = $data['flightNumber'];
        $departure = $data['departure'];
        $arrival = $data['arrival'];
        $departureTime = $data['departureTime'];
        $arrivalTime = $data['arrivalTime'];

        if (empty($flightNumber) || empty($departure) || empty($arrival) || empty($departureTime) || empty($arrivalTime)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->flightModel->createFlight($flightNumber, $departure, $arrival, $departureTime, $arrivalTime)) {
            http_response_code(201);
            echo json_encode(['message' => 'Flight created successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create flight.']);
        }
    }

    public function getFlightById($id)
    {
        $flight = $this->flightModel->getFlightById($id);

        if ($flight) {
            http_response_code(200);
            echo json_encode($flight);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Flight not found.']);
        }
    }

    public function updateFlight($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $flightNumber = $data['flightNumber'];
        $departure = $data['departure'];
        $arrival = $data['arrival'];
        $departureTime = $data['departureTime'];
        $arrivalTime = $data['arrivalTime'];

        if (empty($flightNumber) || empty($departure) || empty($arrival) || empty($departureTime) || empty($arrivalTime)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->flightModel->updateFlight($id, $flightNumber, $departure, $arrival, $departureTime, $arrivalTime)) {
            http_response_code(200);
            echo json_encode(['message' => 'Flight updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update flight.']);
        }
    }

    public function deleteFlight($id)
    {
        if ($this->flightModel->deleteFlight($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Flight deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete flight.']);
        }
    }
}
