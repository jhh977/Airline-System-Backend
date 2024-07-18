<?php
use App\Services\ChatBotService;


//server configuration for CORS security
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Send a 200 OK response for preflight requests
    http_response_code(200);
    exit();
}


require __DIR__ . '/../vendor/autoload.php';

use Bramus\Router\Router;


$router = new Router();

$router->get('/test', function() {
    echo 'Test route is working!';
});


// User routes
$router->post('/api/register',  'App\Controllers\UserController@register'); 
$router->post('/api/login', 'App\Controllers\UserController@login');;


// Flight routes
$router->post('/api/flight/booking',  'App\Controllers\FlightController@handleCreateFlightBooking'); 

// Hotel routes
$router->post('/api/hotels','App\Controllers\HotelController@getHotelByName');
$router->post('/api/hotel/booking',  'App\Controllers\HotelController@handleCreateHotelBooking'); 

// Taxi routes
$router->post('/api/taxis', 'App\Controllers\TaxiController@getTaxiByName');
$router->get('/api/taxis', "App\Controllers\TaxiController@getTaxiByName");
$router->post('/api/taxi/booking',  'App\Controllers\TaxiController@handleCreateTaxiBooking');

// Booking routes
$router->get('/api/bookings/details','App\Controllers\BookingController@getPendingBookingInformationByUserId');
$router->post('/api/bookings/checkout','App\Controllers\BookingController@saveBookingInformationInPayment');
$router->post('/api/booking/create',  'App\Controllers\BookingController@handleCreateBooking'); 



//Chatbot routes
$router->post('/api/chat/response','App\Services\ChatBotService@getBotResponse');
$router->post('/api/chat/history','App\Services\ChatBotService@getChatHistory');
// Handle requests
$router->run();
