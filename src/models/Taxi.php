<?php

namespace App\Models;

class Taxi
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    private function connect()
    {
        $config = require __DIR__ . '/../../config/config.php';
        return $mysqli;
    }

    public function createTaxi($licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO taxis (license_plate, driver_name, driver_phone_number, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $licensePlate, $driverName, $driverPhoneNumber, $status);
        return $stmt->execute();
    }

    public function getTaxiById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM taxis WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateTaxi($id, $licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $stmt = $this->db->prepare("UPDATE taxis SET license_plate = ?, driver_name = ?, driver_phone_number = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $licensePlate, $driverName, $driverPhoneNumber, $status, $id);
        return $stmt->execute();
    }

    public function deleteTaxi($id)
    {
        $stmt = $this->db->prepare("DELETE FROM taxis WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
