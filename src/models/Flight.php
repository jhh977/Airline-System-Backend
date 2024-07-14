<?php

namespace App\Models;

class Flight
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

    public function createFlight($flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $stmt = $this->db->prepare("INSERT INTO flights (flight_number, departure, arrival, departure_time, arrival_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $flightNumber, $departure, $arrival, $departureTime, $arrivalTime);
        return $stmt->execute();
    }

    public function getFlightByNumber($flightNumber)
    {
        $stmt = $this->db->prepare("SELECT * FROM flights WHERE flight_number = ?");
        $stmt->bind_param("s", $flightNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getFlightById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM flights WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateFlight($id, $flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $stmt = $this->db->prepare("UPDATE flights SET flight_number = ?, departure = ?, arrival = ?, departure_time = ?, arrival_time = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $flightNumber, $departure, $arrival, $departureTime, $arrivalTime, $id);
        return $stmt->execute();
    }

    public function deleteFlight($id)
    {
        $stmt = $this->db->prepare("DELETE FROM flights WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
