<?php

namespace App\Controllers;

use App\Models\Booking;

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }

    public function createBooking()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['userId'];
        $flightId = $data['flightId'];
        $hotelId = $data['hotelId'];
        $taxiId = $data['taxiId'];
        $status = $data['status'];

        if (empty($userId) || empty($flightId) || empty($hotelId) || empty($taxiId) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->bookingModel->createBooking($userId, $flightId, $hotelId, $taxiId, $status)) {
            http_response_code(201);
            echo json_encode(['message' => 'Booking created successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create booking.']);
        }
    }

    public function getBookingById($id)
    {
        $booking = $this->bookingModel->getBookingById($id);

        if ($booking) {
            http_response_code(200);
            echo json_encode($booking);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Booking not found.']);
        }
    }

    public function updateBooking($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['userId'];
        $flightId = $data['flightId'];
        $hotelId = $data['hotelId'];
        $taxiId = $data['taxiId'];
        $status = $data['status'];

        if (empty($userId) || empty($flightId) || empty($hotelId) || empty($taxiId) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->bookingModel->updateBooking($id, $userId, $flightId, $hotelId, $taxiId, $status)) {
            http_response_code(200);
            echo json_encode(['message' => 'Booking updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update booking.']);
        }
    }

    public function deleteBooking($id)
    {
        if ($this->bookingModel->deleteBooking($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Booking deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete booking.']);
        }
    }
}
