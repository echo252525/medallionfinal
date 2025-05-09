<?php
// Include connection file
include_once("../connection/connection.php");

// Start the session to access user ID and (if available) buyer name
session_start();

if (!isset($_SESSION['fullname'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not logged in'
    ]);
    exit();
}

$userId = $_SESSION['userid'];
$buyerName = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'User-' . $userId; // fallback if username is missing

// Fetch POST data
$totalPrice = isset($_POST['totalPrice']) ? $_POST['totalPrice'] : 0;
$eventTitle = isset($_POST['eventTitle']) ? $_POST['eventTitle'] : '';
$selectedSeats = isset($_POST['selectedSeats']) ? explode(',', $_POST['selectedSeats']) : [];

// Validate inputs
if ($totalPrice <= 0 || empty($eventTitle) || empty($selectedSeats)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid payment details'
    ]);
    exit();
}

// Fetch current user balance
$stmt = $pdo->prepare("SELECT balance FROM users WHERE userid = :userid");
$stmt->execute(['userid' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found'
    ]);
    exit();
}

$currentBalance = $user['balance'];

// Check if the user has enough balance
if ($totalPrice > $currentBalance) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Insufficient balance'
    ]);
    exit();
}

// Deduct the balance
$newBalance = $currentBalance - $totalPrice;
$updateStmt = $pdo->prepare("UPDATE users SET balance = :newBalance WHERE userid = :userid");
$updateStmt->execute(['newBalance' => $newBalance, 'userid' => $userId]);

// Insert selected seats into seats table
$insertSeatStmt = $pdo->prepare("INSERT INTO seats (seatCode, seatEventTitle, seatOwner) VALUES (:seatCode, :seatEventTitle, :seatOwner)");
foreach ($selectedSeats as $seatCode) {
    $insertSeatStmt->execute([
        'seatCode' => $seatCode,
        'seatEventTitle' => $eventTitle,
        'seatOwner' => $buyerName
    ]);
}

// Insert ticket record into ticket table
$seatCodesString = implode(',', $selectedSeats);
$paymentMethod = 'GCash';

$insertTicketStmt = $pdo->prepare("
    INSERT INTO ticket (buyerName, ticketEventTitle, ticketSeatCodes, totalPrice, paymentMethod)
    VALUES (:buyerName, :ticketEventTitle, :ticketSeatCodes, :totalPrice, :paymentMethod)
");
$insertTicketStmt->execute([
    'buyerName' => $buyerName,
    'ticketEventTitle' => $eventTitle,
    'ticketSeatCodes' => $seatCodesString,
    'totalPrice' => $totalPrice,
    'paymentMethod' => $paymentMethod
]);

// Return success response
echo json_encode([
    'status' => 'success',
    'newBalance' => $newBalance,
    'message' => 'Payment successful, seats and ticket recorded'
]);
exit();
?>