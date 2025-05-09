<?php
// Start the session to access session variables
session_start();

// Include your connection file
include_once("../connection/connection.php");

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID from the session
$userId = $_SESSION['userid'];

// Get the selected seats and eventTitle from the URL
$selectedSeats = isset($_GET['seats']) ? explode(',', urldecode($_GET['seats'])) : [];
$eventTitle = isset($_GET['eventTitle']) ? urldecode($_GET['eventTitle']) : '';

// Calculate the total price (500 PHP per seat)
$seatPrice = 500;
$totalPrice = count($selectedSeats) * $seatPrice;

// Fetch user details (balance) from the database using the userId
$stmt = $pdo->prepare("SELECT balance FROM users WHERE userid = :userid");
$stmt->execute(['userid' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$currentBalance = $user['balance'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>GCash Payment with Seat Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-[#E6E9ED] min-h-screen flex items-start justify-center pt-10">
    <div class="w-full max-w-sm">
        <div class="bg-[#0047BB] flex justify-center py-5 rounded-t-md">
            <img alt="GCash logo white circular icon" class="h-8 w-8" height="32"
                src="https://storage.googleapis.com/a1aa/image/48a5ccef-67a2-4e5e-9f86-f45b55a88948.jpg" width="32" />
            <span class="text-white font-semibold text-lg ml-2 select-none">GCash</span>
        </div>
        <div class="bg-white rounded-b-md shadow-md p-6">
            <h2 class="text-[#0047BB] font-semibold text-center text-lg mb-6 select-none">Dragonpay</h2>
            <div class="mb-6">
                <p class="text-gray-600 font-semibold text-xs mb-1 select-none">PAY WITH</p>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-semibold text-sm select-none">GCash</span>
                    <div class="text-right">
                        <p class="text-gray-700 font-semibold text-sm select-none">PHP
                            <?php echo number_format($currentBalance, 2); ?></p>
                        <p class="text-gray-400 text-xs select-none">Available Balance</p>
                    </div>
                    <div class="ml-3">
                        <input aria-label="Select GCash payment" checked=""
                            class="w-5 h-5 text-[#0047BB] border-[#0047BB] focus:ring-[#0047BB]" type="radio" />
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-gray-600 font-semibold text-xs mb-1 select-none">SEAT SELECTED</p>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-400 text-sm select-none">Seat Code(s)</span>
                    <span class="text-gray-700 text-sm select-none"><?php echo implode(', ', $selectedSeats); ?></span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-400 text-sm select-none">Price of Ticket (per seat)</span>
                    <span class="text-gray-700 text-sm select-none">PHP 500.00</span>
                </div>
                <hr class="border-gray-300 my-3" />
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-semibold text-sm select-none">Total Amount</span>
                    <span class="text-gray-900 font-extrabold text-lg select-none">PHP
                        <?php echo number_format($totalPrice, 2); ?></span>
                </div>
            </div>

            <p class="text-center text-gray-500 text-xs mb-6 select-none">Please review to ensure that the details are
                correct before you proceed.</p>
            <button
                class="w-full bg-[#0047BB] text-white font-semibold text-sm py-3 rounded-md hover:bg-[#003a99] transition-colors"
                type="button" id="payButton">
                PAY PHP <?php echo number_format($totalPrice, 2); ?>
            </button>
        </div>
    </div>

    <script>
    document.getElementById("payButton").addEventListener("click", function() {
        const totalPrice = <?php echo $totalPrice; ?>;
        const userBalance = <?php echo $currentBalance; ?>;
        const selectedSeats = <?php echo json_encode($selectedSeats); ?>;
        const eventTitle = "<?php echo $eventTitle; ?>";

        // Debugging the values
        console.log('Total Price:', totalPrice);
        console.log('User Balance:', userBalance);
        console.log('Selected Seats:', selectedSeats);
        console.log('Event Title:', eventTitle);

        if (totalPrice > userBalance) {
            alert("Insufficient balance. Please add funds to your account.");
            return;
        }

        // Create a FormData object to send the payment details
        const formData = new FormData();
        formData.append('totalPrice', totalPrice);
        formData.append('eventTitle', eventTitle); // Add eventTitle to FormData
        formData.append('selectedSeats', selectedSeats.join(',')); // Add selected seats to FormData

        // Debugging FormData
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Send the payment request using AJAX
        fetch('../remote/processPayment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Payment Successful! New Balance: PHP " + data.newBalance.toFixed(2));
                    window.location.href = "../pages/database.php";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error processing payment:", error);
                alert("An error occurred. Please try again.");
            });
    });
    </script>
</body>

</html>