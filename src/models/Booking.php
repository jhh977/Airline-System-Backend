<?php

namespace App\Models;

class Booking
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

    public function createBooking($userId, $flightId, $hotelId, $taxiId, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO bookings (user_id, flight_id, hotel_id, taxi_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $userId, $flightId, $hotelId, $taxiId, $status);
        return $stmt->execute();
    }

    public function getBookingById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateBooking($id, $userId, $flightId, $hotelId, $taxiId, $status)
    {
        $stmt = $this->db->prepare("UPDATE bookings SET user_id = ?, flight_id = ?, hotel_id = ?, taxi_id = ?, status = ? WHERE id = ?");
        $stmt->bind_param("iiissi", $userId, $flightId, $hotelId, $taxiId, $status, $id);
        return $stmt->execute();
    }

    public function deleteBooking($id)
    {
        $stmt = $this->db->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
