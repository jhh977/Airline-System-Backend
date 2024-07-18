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
    
    /**
         * @param int $hotel_id
         * @param string $checkin_date
         * @param string $checkout_date
         * @param string $room_type
         * @param int $num_guests
         * @param int $price
         * @return int|bool
     */
    public function createHotelBooking($hotel_id, $checkin_date, $checkout_date, $room_type, $num_guests, $price) {
        $stmt = $this->db->prepare("INSERT INTO `hotel_booking` (`hotel_id`, `checkin_date`, `checkout_date`, `room_type`, `num_guests`, `price`)
        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssii", $hotel_id, $checkin_date, $checkout_date, $room_type, $num_guests, $price);

        if ($stmt->execute()) {
            return $this->db->insert_id; // Return the ID of the inserted record
        } else {
            return false;
        }
    }



    /**
        * filters hotel based on location
        * @param int $city
        * @return array|null
     */
    public function getHotelByLocation($city) {
        $stmt = $this->db->prepare("
            SELECT 
                h.id AS hotel_id,
                h.name AS hotel_name,
                h.rating,
                h.hotel_image_url,
                a.city,
                s.id AS service_id,
                s.service_name AS service_name,
                s.service_image
            FROM hotels h
            JOIN address a ON h.address_id = a.id
            JOIN hotel_services hs ON h.id = hs.hotel_id
            JOIN services s ON s.id = hs.service_id
            WHERE a.city =?
        ");
        $stmt->bind_param("s", $city);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $hotels = [];
    
        while ($row = $result->fetch_assoc()) {
            $hotel_id = $row['hotel_id'];
    
            if (!isset($hotels[$hotel_id])) {
                $hotels[$hotel_id] = [
                    'id' => $row['hotel_id'],
                    'name' => $row['hotel_name'],
                    'rating' => $row['rating'],
                    'hotel_image_url' => $row['hotel_image_url'],
                    'city' => $row['city'],
                    'services' => []
                ];
            }
    
            $hotels[$hotel_id]['services'][] = [
                'id' => $row['service_id'],
                'name' => $row['service_name'],
                'service_image' => $row['service_image']
            ];
        }
    
        return $hotels;
    }



}
