<?php

namespace App\Controllers;

use App\Models\Payment;

class PaymentController
{
    private $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new Payment();
    }

    public function createPayment()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $bookingId = $data['bookingId'];
        $amount = $data['amount'];
        $paymentMethod = $data['paymentMethod'];
        $status = $data['status'];

        if (empty($bookingId) || empty($amount) || empty($paymentMethod) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->paymentModel->createPayment($bookingId, $amount, $paymentMethod, $status)) {
            http_response_code(201);
            echo json_encode(['message' => 'Payment created successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create payment.']);
        }
    }

    public function getPaymentById($id)
    {
        $payment = $this->paymentModel->getPaymentById($id);

        if ($payment) {
            http_response_code(200);
            echo json_encode($payment);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Payment not found.']);
        }
    }

    public function updatePayment($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $bookingId = $data['bookingId'];
        $amount = $data['amount'];
        $paymentMethod = $data['paymentMethod'];
        $status = $data['status'];

        if (empty($bookingId) || empty($amount) || empty($paymentMethod) || empty($status)) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required.']);
            return;
        }

        if ($this->paymentModel->updatePayment($id, $bookingId, $amount, $paymentMethod, $status)) {
            http_response_code(200);
            echo json_encode(['message' => 'Payment updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update payment.']);
        }
    }

    public function deletePayment($id)
    {
        if ($this->paymentModel->deletePayment($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Payment deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete payment.']);
        }
    }
}
