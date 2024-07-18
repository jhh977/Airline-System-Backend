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



    /**
         * get the taxi based on its location 
         * @param int $city
         * @return array|null
    */
    public function getTaxiByLocation($city)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM taxis t
            JOIN address a ON t.address_id = a.id
            WHERE city = ?
        ");
        $stmt->bind_param("s", $city); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        // return $result->fetch_assoc();
        $taxi = [];
        while ($row = $result->fetch_assoc()) {
            $taxi[] = $row;
        }
        return $taxi;
    }

/**
 * @param int $taxi_id
 * @param string $pickup_location
 * @param string $dropoff_location
 * @param string $pickup_time
 * @param string $dropoff_time
 * @param int $price
 * @return int
 */
public function createTaxiBooking($taxi_id, $pickup_location, $dropoff_location, $pickup_time, $dropoff_time, $price) {
    $stmt = $this->db->prepare("INSERT INTO `taxi_booking` (`taxi_id`, `pickup_location`, `dropoff_location`, `pickup_time`, `dropoff_time`, `price`)
     VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $taxi_id, $pickup_location, $dropoff_location, $pickup_time, $dropoff_time, $price);

    // Execute the statement
    if ($stmt->execute()) {
        return $this->db->insert_id; // Return the ID of the inserted record
    } else {
        return false; // Handle the error case
    }
}

}
