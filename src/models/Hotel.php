<?php

namespace App\Models;

class Hotel
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

    public function createHotel($name, $location, $roomsAvailable, $pricePerNight)
    {
        $stmt = $this->db->prepare("INSERT INTO hotels (name, location, rooms_available, price_per_night) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name, $location, $roomsAvailable, $pricePerNight);
        return $stmt->execute();
    }

    public function getHotelById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM hotels WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateHotel($id, $name, $location, $roomsAvailable, $pricePerNight)
    {
        $stmt = $this->db->prepare("UPDATE hotels SET name = ?, location = ?, rooms_available = ?, price_per_night = ? WHERE id = ?");
        $stmt->bind_param("ssiii", $name, $location, $roomsAvailable, $pricePerNight, $id);
        return $stmt->execute();
    }

    public function deleteHotel($id)
    {
        $stmt = $this->db->prepare("DELETE FROM hotels WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}