<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require __DIR__ . '/../vendor/autoload.php';

use Bramus\Router\Router;
use App\Controllers\UserController;
use App\Controllers\FlightController;
use App\Controllers\HotelController;
use App\Controllers\TaxiController;
use App\Controllers\BookingController;
use App\Controllers\PaymentController;
use App\Controllers\AdminController;

$router = new Router();

$router->get('/test', function() {
    echo 'Test route is working!';
});

// Handle OPTIONS requests for CORS preflight
$router->options('/{routes:.+}', function() {
    // Just send a 200 response for OPTIONS requests
    header('HTTP/1.1 200 OK');
});

// User routes
$router->post('/api/register',  'App\Controllers\UserController@register'); // Correct
/* 
$router->get('/api/register', function() {
    echo 'Test route is working!';
}); // */

$router->post('/api/login', [UserController::class, 'login']);
$router->put('/api/profile', [UserController::class, 'updateProfile']);
$router->delete('/api/profile', [UserController::class, 'deleteUser']);

/* 
// Flight routes
$router->post('/api/flights', [FlightController::class, 'createFlight']);
$router->get('/api/flights', [FlightController::class, 'getAllFlights']);
$router->get('/api/flights/{id}', [FlightController::class, 'getFlightById']);
$router->put('/api/flights/{id}', [FlightController::class, 'updateFlight']);
$router->delete('/api/flights/{id}', [FlightController::class, 'deleteFlight']);

// Hotel routes
$router->post('/api/hotels', [HotelController::class, 'createHotel']);
$router->get('/api/hotels', [HotelController::class, 'getAllHotels']);
$router->get('/api/hotels/{id}', [HotelController::class, 'getHotelById']);
$router->put('/api/hotels/{id}', [HotelController::class, 'updateHotel']);
$router->delete('/api/hotels/{id}', [HotelController::class, 'deleteHotel']);

// Taxi routes
$router->post('/api/taxis', [TaxiController::class, 'createTaxi']);
$router->get('/api/taxis', [TaxiController::class, 'getAllTaxis']);
$router->get('/api/taxis/{id}', [TaxiController::class, 'getTaxiById']);
$router->put('/api/taxis/{id}', [TaxiController::class, 'updateTaxi']);
$router->delete('/api/taxis/{id}', [TaxiController::class, 'deleteTaxi']);

// Booking routes
$router->post('/api/bookings', [BookingController::class, 'createBooking']);
$router->get('/api/bookings', [BookingController::class, 'getAllBookings']);
$router->get('/api/bookings/{id}', [BookingController::class, 'getBookingById']);
$router->put('/api/bookings/{id}', [BookingController::class, 'updateBooking']);
$router->delete('/api/bookings/{id}', [BookingController::class, 'deleteBooking']);

// Payment routes
$router->post('/api/payments', [PaymentController::class, 'createPayment']);
$router->get('/api/payments', [PaymentController::class, 'getAllPayments']);
$router->get('/api/payments/{id}', [PaymentController::class, 'getPaymentById']);
$router->put('/api/payments/{id}', [PaymentController::class, 'updatePayment']);
$router->delete('/api/payments/{id}', [PaymentController::class, 'deletePayment']);

// Admin routes
$router->post('/api/admin/flights', [AdminController::class, 'createFlight']);
$router->post('/api/admin/hotels', [AdminController::class, 'createHotel']);
$router->post('/api/admin/taxis', [AdminController::class, 'createTaxi']);
$router->post('/api/admin/bookings', [AdminController::class, 'createBooking']);
$router->post('/api/admin/payments', [AdminController::class, 'createPayment']);

// Trip planning route
$router->post('/api/trip-plan', [TripPlannerService::class, 'generateTripPlan']);
*/
// Handle requests
$router->run();
