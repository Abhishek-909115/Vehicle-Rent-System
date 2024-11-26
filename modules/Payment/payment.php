<?php
include '../../config/config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['account_email'])) {
    header("Location: login.php");
    exit;
}

// Check if reservation ID is set
if (!isset($_SESSION['reservation_id'])) {
    header("Location: /car_rental/modules/User/rent_vehicle.php");
    exit;
}

// Get reservation ID
$reservation_id = $_SESSION['reservation_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate a fake transaction ID
    $transaction_id = rand(10000, 99999); // Generates a random 5-digit number

    // Prepare to insert payment record into the database
    $query = "INSERT INTO Payment (transaction_id, bank_name, payment_type, payment_date, reservation_id) VALUES (:transaction_id, :bank_name, :payment_type, NOW(), :reservation_id)";
    $stmt = $db->prepare($query);

    // Here you can replace with actual bank name and payment_type
    $bank_name = 'Dummy Bank'; // This should be replaced with actual bank name
    $payment_type = 'Initial'; // Set to 'Initial' or 'Fine' based on your logic

    // Bind parameters and execute the query
    $stmt->bindParam(':transaction_id', $transaction_id);
    $stmt->bindParam(':bank_name', $bank_name);
    $stmt->bindParam(':payment_type', $payment_type);
    $stmt->bindParam(':reservation_id', $reservation_id);
    $stmt->execute();

    // Store transaction ID in the session and redirect to confirmation page
    $_SESSION['transaction_id'] = $transaction_id;
    header("Location: confirmation.php");
    exit; // End execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="/car_rental/modules/Payment/payment.css">
</head>
<body>
    <div class="payment-container">
        <h2>Payment for Reservation</h2>
        <p>Your reservation ID is: <span class="reservation-id"><?php echo htmlspecialchars($reservation_id); ?></span></p>
        <form method="POST" class="payment-form">
            <label for="bank_name">Bank Name:</label>
            <input type="text" name="bank_name" id="bank_name" required placeholder="Enter your bank name">
            <button type="submit" class="submit-button">Confirm Payment</button>
        </form>
    </div>
</body>
</html>
