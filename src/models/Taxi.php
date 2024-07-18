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

    public function getTaxiById($city)
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
