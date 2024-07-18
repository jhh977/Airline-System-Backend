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
     /**
     * create a flight_booking
     * @param int $flight_id
     * @param int $flight_price
     * @return int
     */

     public function createFlightBooking($flight_id, $flight_price) {
        $stmt = $this->db->prepare("INSERT INTO flight_booking (flight_id, flight_price) VALUES (?, ?)");
        $stmt->bind_param("ii", $flight_id, $flight_price);
        
        if ($stmt->execute()) {
            return $this->db->insert_id; // Return the ID of the inserted record
        } else {
            return false; // Handle the error case
        }
    }
    

}
