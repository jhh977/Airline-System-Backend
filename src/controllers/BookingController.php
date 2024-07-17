<?php

namespace App\Controllers;

use App\Models\Booking;

use App\Services\sendEmail;



class BookingController
{
    private $bookingModel;
    private $mailer;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->mailer = new sendEmail();

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

    public function getPendingBookingInformationByUserId()
    {
        
        //$data = json_decode(file_get_contents('php://input'), true);
        session_start();
        //$uID = $_SESSION['loggedUserID'];

        //echo "user id received: ".$uID.PHP_EOL;
        $uID=11;
        if (empty($uID)) {
            http_response_code(400);
            echo json_encode(['message' => 'user id not received from session']);
            return;
        }
        $bookingInfo = $this->bookingModel->getBookingInformationByUserId($uID);

        if (is_array($bookingInfo)) {
            http_response_code(200);
            $total_price = $bookingInfo['hotel_booking_price']+$bookingInfo['taxi_booking_price']+$bookingInfo['flight_price'];
            
            $_SESSION['total_pice']=$total_price;               // to be used in the payment checkout method
            $_SESSION['booking_id']=$bookingInfo['booking_id']; // to be used in the payment checkout method
            header('Content-Type: application/json');
            echo json_encode([
                //'message' => 'Booking retrieved successfully.',
                'response' => $bookingInfo,
                //'total_price' =>$_SESSION['total_pice'],
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'This user has no booking information']);
        }
    }

    public function saveBookingInformationInPayment()
    {
        //save booking information in payment table
        session_start();
        //$booking_id = $_SESSION['booking_id']; 
        $booking_id = 1; $total_price=400;
        //$total_price =  $_SESSION['total_pice'];
        $payment_method = 'credit card';
        $payment_date=date("Y-m-d");
        //$userEmail = $_SESSION['loggedUserEmail'];
        $userEmail = "52130448@students.liu.edu.lb";
        if ($this->bookingModel->storeBookingInformationInPayment($booking_id,$payment_date,$total_price, $payment_method )) {
            echo json_encode(['message' => 'User paid, all saved in payment table now']);
            //if saved, send an email to the user using PHPMailer
            $subject  = "Payment Details";
            $body ="Thanks for comfirming your booking! .$total_price. has been deducted from you ";
            http_response_code(201);
            if($this->mailer->sendMail($userEmail,$subject,$body)){
                echo json_encode(['email_status' => 'user received an email on payment']);
            }else{
                echo json_encode(['email_status' => 'user did not received an email on payment']);
            }
            
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to pay, try again']);
        }
    }
}
