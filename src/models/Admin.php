<?php

namespace App\Models;

use PDO;

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createAdmin($name, $email, $password)
    {
        // ... (existing code)
    }

    public function getAdminByEmail($email)
    {
        // ... (existing code)
    }

    public function updateAdmin($id, $name, $email, $password)
    {
        // ... (existing code)
    }

    public function deleteAdmin($id)
    {
        // ... (existing code)
    }

    // Admin specific management functions
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createFlight($flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $sql = "INSERT INTO flights (flight_number, departure, arrival, departure_time, arrival_time) 
                VALUES (:flightNumber, :departure, :arrival, :departureTime, :arrivalTime)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':flightNumber', $flightNumber);
        $stmt->bindParam(':departure', $departure);
        $stmt->bindParam(':arrival', $arrival);
        $stmt->bindParam(':departureTime', $departureTime);
        $stmt->bindParam(':arrivalTime', $arrivalTime);
        return $stmt->execute();
    }

    public function updateFlight($id, $flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $sql = "UPDATE flights SET flight_number = :flightNumber, departure = :departure, arrival = :arrival, 
                departure_time = :departureTime, arrival_time = :arrivalTime WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':flightNumber', $flightNumber);
        $stmt->bindParam(':departure', $departure);
        $stmt->bindParam(':arrival', $arrival);
        $stmt->bindParam(':departureTime', $departureTime);
        $stmt->bindParam(':arrivalTime', $arrivalTime);
        return $stmt->execute();
    }

    public function deleteFlight($id)
    {
        $sql = "DELETE FROM flights WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createHotel($name, $location, $roomsAvailable, $pricePerNight)
    {
        $sql = "INSERT INTO hotels (name, location, rooms_available, price_per_night) 
                VALUES (:name, :location, :roomsAvailable, :pricePerNight)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':roomsAvailable', $roomsAvailable);
        $stmt->bindParam(':pricePerNight', $pricePerNight);
        return $stmt->execute();
    }

    public function updateHotel($id, $name, $location, $roomsAvailable, $pricePerNight)
    {
        $sql = "UPDATE hotels SET name = :name, location = :location, rooms_available = :roomsAvailable, 
                price_per_night = :pricePerNight WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':roomsAvailable', $roomsAvailable);
        $stmt->bindParam(':pricePerNight', $pricePerNight);
        return $stmt->execute();
    }

    public function deleteHotel($id)
    {
        $sql = "DELETE FROM hotels WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createTaxi($licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $sql = "INSERT INTO taxis (license_plate, driver_name, driver_phone_number, status) 
                VALUES (:licensePlate, :driverName, :driverPhoneNumber, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':licensePlate', $licensePlate);
        $stmt->bindParam(':driverName', $driverName);
        $stmt->bindParam(':driverPhoneNumber', $driverPhoneNumber);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function updateTaxi($id, $licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $sql = "UPDATE taxis SET license_plate = :licensePlate, driver_name = :driverName, 
                driver_phone_number = :driverPhoneNumber, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':licensePlate', $licensePlate);
        $stmt->bindParam(':driverName', $driverName);
        $stmt->bindParam(':driverPhoneNumber', $driverPhoneNumber);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deleteTaxi($id)
    {
        $sql = "DELETE FROM taxis WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
