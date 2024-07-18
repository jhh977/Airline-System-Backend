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


    public function handleCreateBooking() {
        session_start();
    
        if (!isset($_SESSION['user_id'], $_SESSION['hotel_booking_id'], $_SESSION['taxi_booking_id'], $_SESSION['flight_booking_id'])) {
            echo json_encode(['message' => 'Required session data is missing.']);
            return;
        }
    
        // Decode JSON input
        $data = json_decode(file_get_contents('php://input'), true);
        $flight_booking_id = $_SESSION['flight_booking_id'];
        $user_id = $_SESSION['user_id'];
        $hotel_booking_id = $_SESSION['hotel_booking_id'];
        $taxi_booking_id = $_SESSION['taxi_booking_id'];
        $booking_date = date("Y-m-d"); // Set booking date to today
        $total_price = $_SESSION['$flight_booking_price']+$_SESSION['$taxi_booking_price']+$_SESSION['$hotel_booking_price'];
        $status = 'pending'; // Initial status
    
        // Call the model method to create the booking
        $insertedId = $this->bookingModel->createBooking($flight_booking_id, $user_id, $hotel_booking_id, $taxi_booking_id, $booking_date, $total_price, $status);
    
        // Check if the booking was successfully created
        if (is_numeric($insertedId)) {
            $_SESSION['booking_id'] = $insertedId;
            echo json_encode(['message' => 'Booking created!', 'booking_id' => $insertedId]);
        } else {
            echo json_encode(['message' => 'Failed to create booking.']);
        }
    }

    public function getPendingBookingInformationByUserId()
    {
        
        session_start();
        //echo "hello";
        //$data = json_decode(file_get_contents('php://input'), true);
        $uID = $_SESSION['loggedUserID'];

        //echo "user id received: ".$uID.PHP_EOL;
        //$uID=2;
        if (empty($uID)) {
            http_response_code(400);
            echo json_encode(['message' => 'user id not received from session']);
            return;
        }
        $bookingInfo = $this->bookingModel->getBookingInformationByUserId($uID);

        if (is_array($bookingInfo)) {
            http_response_code(200);
            $total_price = $bookingInfo['hotel_booking_price']+$bookingInfo['taxi_booking_price']+$bookingInfo['flight_booking_price'];
            
            $_SESSION['total_pice']=$total_price;               // to be used in the payment checkout method
            $_SESSION['booking_id']=$bookingInfo['booking_id']; // to be used in the payment checkout method
            header('Content-Type: application/json');
            echo json_encode([
                //'message' => 'Booking retrieved successfully.',
                'response' => $bookingInfo,
                'total_price' =>$_SESSION['total_pice'],
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'This user has no booking information']);
        }
    }

    public function saveBookingInformationInPayment()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        //save booking information in payment table
        session_start();
        $booking_id = $_SESSION['booking_id']; 
        $total_price =  $_SESSION['total_pice'];
        $userEmail = $_SESSION['loggedUserEmail'];

        $payment_method = 'credit card';
        $payment_date=date("Y-m-d");
        //$userEmail = "52130448@students.liu.edu.lb";
        if ($this->bookingModel->storeBookingInformationInPayment($booking_id,$payment_date,$total_price, $payment_method )) {
            echo json_encode(['message' => 'User paid, all saved in payment table now']);
            //if saved, send an email to the user using PHPMailer
            $subject  = "Payment Details";
            $body ="Thanks for comfirming your booking! $$total_price has been deducted from you ";
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
