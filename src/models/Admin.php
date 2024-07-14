<?php

namespace App\Models;

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    private function connect()
    {
        require __DIR__ . '/../../config/config.php';
        return $mysqli;  // Using $mysqli from the config file
    }

    public function createAdmin($name, $email, $password)
    {
        $sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        return $stmt->execute();
    }

    public function getAdminByEmail($email)
    {
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateAdmin($id, $name, $email, $password)
    {
        $sql = "UPDATE admins SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
        return $stmt->execute();
    }

    public function deleteAdmin($id)
    {
        $sql = "DELETE FROM admins WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Admin specific management functions
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createFlight($flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $sql = "INSERT INTO flights (flight_number, departure, arrival, departure_time, arrival_time) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", $flightNumber, $departure, $arrival, $departureTime, $arrivalTime);
        return $stmt->execute();
    }

    public function updateFlight($id, $flightNumber, $departure, $arrival, $departureTime, $arrivalTime)
    {
        $sql = "UPDATE flights SET flight_number = ?, departure = ?, arrival = ?, 
                departure_time = ?, arrival_time = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssi", $flightNumber, $departure, $arrival, $departureTime, $arrivalTime, $id);
        return $stmt->execute();
    }

    public function deleteFlight($id)
    {
        $sql = "DELETE FROM flights WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createHotel($name, $location, $roomsAvailable, $pricePerNight)
    {
        $sql = "INSERT INTO hotels (name, location, rooms_available, price_per_night) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssis", $name, $location, $roomsAvailable, $pricePerNight);
        return $stmt->execute();
    }

    public function updateHotel($id, $name, $location, $roomsAvailable, $pricePerNight)
    {
        $sql = "UPDATE hotels SET name = ?, location = ?, rooms_available = ?, 
                price_per_night = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssisi", $name, $location, $roomsAvailable, $pricePerNight, $id);
        return $stmt->execute();
    }

    public function deleteHotel($id)
    {
        $sql = "DELETE FROM hotels WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createTaxi($licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $sql = "INSERT INTO taxis (license_plate, driver_name, driver_phone_number, status) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssis", $licensePlate, $driverName, $driverPhoneNumber, $status);
        return $stmt->execute();
    }

    public function updateTaxi($id, $licensePlate, $driverName, $driverPhoneNumber, $status)
    {
        $sql = "UPDATE taxis SET license_plate = ?, driver_name = ?, 
                driver_phone_number = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssisi", $licensePlate, $driverName, $driverPhoneNumber, $status, $id);
        return $stmt->execute();
    }

    public function deleteTaxi($id)
    {
        $sql = "DELETE FROM taxis WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createBooking($userId, $flightId, $hotelId, $taxiId, $bookingDate, $status)
    {
        $sql = "INSERT INTO bookings (user_id, flight_id, hotel_id, taxi_id, booking_date, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiisss", $userId, $flightId, $hotelId, $taxiId, $bookingDate, $status);
        return $stmt->execute();
    }

    public function updateBooking($id, $userId, $flightId, $hotelId, $taxiId, $bookingDate, $status)
    {
        $sql = "UPDATE bookings SET user_id = ?, flight_id = ?, hotel_id = ?, taxi_id = ?, 
                booking_date = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiisssi", $userId, $flightId, $hotelId, $taxiId, $bookingDate, $status, $id);
        return $stmt->execute();
    }

    public function deleteBooking($id)
    {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createPayment($userId, $amount, $paymentDate, $status)
    {
        $sql = "INSERT INTO payments (user_id, amount, payment_date, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("idss", $userId, $amount, $paymentDate, $status);
        return $stmt->execute();
    }

    public function updatePayment($id, $userId, $amount, $paymentDate, $status)
    {
        $sql = "UPDATE payments SET user_id = ?, amount = ?, payment_date = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("idssi", $userId, $amount, $paymentDate, $status, $id);
        return $stmt->execute();
    }

    public function deletePayment($id)
    {
        $sql = "DELETE FROM payments WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
