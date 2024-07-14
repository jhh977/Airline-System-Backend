<?php

namespace App\Models;

class Payment
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

    public function createPayment($bookingId, $amount, $paymentMethod, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO payments (booking_id, amount, payment_method, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $bookingId, $amount, $paymentMethod, $status);
        return $stmt->execute();
    }

    public function getPaymentById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updatePayment($id, $bookingId, $amount, $paymentMethod, $status)
    {
        $stmt = $this->db->prepare("UPDATE payments SET booking_id = ?, amount = ?, payment_method = ?, status = ? WHERE id = ?");
        $stmt->bind_param("idssi", $bookingId, $amount, $paymentMethod, $status, $id);
        return $stmt->execute();
    }

    public function deletePayment($id)
    {
        $stmt = $this->db->prepare("DELETE FROM payments WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
