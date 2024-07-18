<?php

namespace App\Controllers;

use App\Models\Flight;

class FlightController
{
    private $flightModel;

    public function __construct()
    {
        $this->flightModel = new Flight();
    }

    public function handleCreateFlightBooking(){
        $data = json_decode(file_get_contents('php://input'), true);
        $flight_id = $data['flight_id'];
        $flight_price = $data['flight_price'];

        $insertedId = $this->flightModel->createFlightBooking($flight_id, $flight_price);
        if (is_numeric($insertedId)) {
            $_SESSION['flight_booking_id']=$insertedId;
            $_SESSION['flight_booking_price']=$flight_price;//to be used when inserting into booking
            echo json_encode(['message'=>'Flight booked !']) ;
        } else {
            echo json_encode(['message'=>'Failed to insert flight booking.']) ;
        }

    }
}
