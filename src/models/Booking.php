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

    /**
     * get all information about a pending booking for the checkout page
     *
     * @param int $user_id
     * @return array|null
     */

     public function getBookingInformationByUserId($user_id)
{
    $stmt = $this->db->prepare("SELECT 
                                b.id AS booking_id,
                                b.booking_date,
                                b.status,
                                f.flight_date,
                                f.departure_time,
                                f.arrival_time,
                                f.departure_location,
                                f.arrival_location,
                                fb.flight_price AS flight_booking_price,
                                hb.checkin_date,
                                hb.checkout_date,
                                hb.room_type,
                                hb.num_guests,
                                hb.price AS hotel_booking_price,
                                tb.pickup_location,
                                tb.dropoff_location,
                                tb.pickup_time,
                                tb.dropoff_time,
                                tb.price AS taxi_booking_price,
                                t.name AS taxi_name,
                                h.name AS hotel_name
                            FROM 
                                bookings b
                            JOIN flight_booking fb ON b.flight_id = fb.id
                            JOIN hotel_booking hb ON b.hotel_id = hb.id
                            JOIN taxi_booking tb ON b.taxi_id = tb.id
                            JOIN flights f ON fb.flight_id = f.id
                            JOIN taxis t ON tb.taxi_id = t.id
                            JOIN hotels h ON hb.hotel_id = h.id
                            WHERE 
                                b.user_id = ?
                            AND
                                status='pending';
");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

 /**
     * save payment information after user checkout
     *
     * @param int $booking_id
     * @param string $payment_date
     * @param int $total_price
     * @param string $payment_method
     * @return array|null
     */

     public function storeBookingInformationInPayment($booking_id,$payment_date,$total_price,$paymnt_method){
        //this should read booking_id, total_price from session
        //after user presses on checkout button ==> fetch an API in bookingController that calls this method
        $stmt = $this->db->prepare("INSERT INTO `payments`(`booking_id`, `payment_date`, `total_price`, `payment_method`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $booking_id, $payment_date, $total_price, $paymnt_method);
        return $stmt->execute();
     }
}
