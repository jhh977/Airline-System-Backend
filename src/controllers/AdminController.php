<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Taxi;

class AdminController
{
    private $adminModel;
    private $userModel;
    private $flightModel;
    private $hotelModel;
    private $taxiModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
        $this->userModel = new User();
        $this->flightModel = new Flight();
        $this->hotelModel = new Hotel();
        $this->taxiModel = new Taxi();
    }

    // Admin specific functions
    public function createAdmin()
    {
        // ... (existing code)
    }

    public function getAdminByEmail($email)
    {
        // ... (existing code)
    }

    public function updateAdmin($id)
    {
        // ... (existing code)
    }

    public function deleteAdmin($id)
    {
        // ... (existing code)
    }

    // User management
    public function deleteUser($id)
    {
        if ($this->userModel->deleteUser($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete user.']);
        }
    }

    // Flight management
    public function addFlight()
    {
        // ... (code from FlightController::createFlight)
    }

    public function updateFlight($id)
    {
        // ... (code from FlightController::updateFlight)
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

    // Hotel management
    public function addHotel()
    {
        // ... (code from HotelController::createHotel)
    }

    public function updateHotel($id)
    {
        // ... (code from HotelController::updateHotel)
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

    // Taxi management
    public function addTaxi()
    {
        // ... (code from TaxiController::createTaxi)
    }

    public function updateTaxi($id)
    {
        // ... (code from TaxiController::updateTaxi)
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
