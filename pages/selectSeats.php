<?php
date_default_timezone_set('Asia/Manila');
include_once("../connection/session.php");

$eventTitle = isset($_GET['eventTitle']) ? urldecode($_GET['eventTitle']) : '';

// Fetch event details from the database
$eventStmt = $pdo->prepare("SELECT eventId, eventTitle, eventDate, startTime, endTime, eventPicture FROM event WHERE eventTitle = :eventTitle");
$eventStmt->execute(['eventTitle' => $eventTitle]);
$event = $eventStmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Event not found.");
}

$backgroundImagePath = '../uploads/' . $event['eventPicture'];

// Fetch reserved seats from the database
$seatStmt = $pdo->prepare("SELECT seatCode FROM seats WHERE seatEventTitle = :eventTitle");
$seatStmt->execute(params: ['eventTitle' => $eventTitle]);
$reservedSeats = $seatStmt->fetchAll(PDO::FETCH_COLUMN, 0);

// Define the seating layout
$allSeats = [
    'C' => ['C13', 'C14', 'C15', 'C16'],
    'B' => ['B7', 'B8', 'B10', 'B11', 'B12'],
    'A' => ['A1', 'A3', 'A4', 'A5', 'A6'],
    'D' => ['D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9'],
    'E' => ['E10', 'E11', 'E12', 'E13', 'E14', 'E15', 'E16', 'E17', 'E18'],
    'F' => ['F1', 'F2', 'F3', 'F4', 'F5', 'F6'],
    'G' => ['G7', 'G8', 'G9', 'G10', 'G11', 'G12'],
    'H' => ['H13', 'H14', 'H15', 'H16']
];

// Check if the event has passed
$eventEndDateTime = $event['eventDate'] . ' ' . $event['endTime'];
$currentDateTime = date('Y-m-d H:i:s');

$eventHasPassed = strtotime($eventEndDateTime) < strtotime($currentDateTime);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Seat - <?php echo htmlspecialchars($event['eventTitle']); ?></title>
    <style>
    body {
        position: relative;
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 20px;
        z-index: 1;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('<?php echo $backgroundImagePath; ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: rgba(255, 255, 255, 0.8);
        background-blend-mode: soft-light;
        z-index: -1;
    }

    h2 {
        margin-bottom: 5px;
    }

    h4 {
        margin: 2px 0;
        font-weight: normal;
    }

    .legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .legend div {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .legend-box {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .available {
        background-color: #2ecc71;
    }

    .reserved {
        background-color: #e74c3c;
    }

    .selected {
        background-color: #95a5a6;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        border-radius: 6px;
        line-height: 40px;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s, background-color 0.2s;
    }

    .seat.available {
        background-color: #2ecc71;
        color: #000;
    }

    .seat.reserved {
        background-color: #e74c3c;
        color: #fff;
        cursor: not-allowed;
    }

    .seat.selected {
        background-color: #95a5a6 !important;
        color: #000;
        transform: scale(1.1);
    }

    .seating-layout {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .seat-column {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .seat-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .stage {
        background: #ecf0f1;
        color: #000;
        width: 300px;
        height: 60px;
        margin: 30px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border-radius: 10px;
        font-size: 18px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .btn {
        padding: 12px 24px;
        background-color: #f1c40f;
        color: #000;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #d4ac0d;
    }

    .selected-seats-display {
        margin: 15px 0;
        font-size: 14px;
    }

    .btn.disabled {
        background-color: #bdc3c7;
        cursor: not-allowed;
    }
    </style>
</head>

<body>
    <h2><?php echo htmlspecialchars($event['eventTitle']); ?></h2>
    <h4>Date: <?php echo date('F j, Y', strtotime($event['eventDate'])); ?></h4>
    <h4>Time:
        <?php echo date('g:i A', strtotime($event['startTime'])) . " - " . date('g:i A', strtotime($event['endTime'])); ?>
    </h4>

    <div class="legend">
        <div>
            <div class="legend-box available"></div> Available
        </div>
        <div>
            <div class="legend-box reserved"></div> Reserved
        </div>
        <div>
            <div class="legend-box selected"></div> Selected
        </div>
    </div>

    <div class="seating-layout">
        <!-- Left Section: C, B, A -->
        <div class="seat-column">
            <?php foreach (['C', 'B', 'A'] as $section) { ?>
            <div class="seat-row">
                <?php foreach ($allSeats[$section] as $seatCode) {
                        $class = in_array($seatCode, $reservedSeats) ? 'reserved' : 'available';
                        echo '<div class="seat ' . $class . '" data-seat-code="' . $seatCode . '">' . $seatCode . '</div>';
                    } ?>
            </div>
            <?php } ?>
        </div>

        <!-- Center Section: Stage + D, E -->
        <div class="seat-column">
            <div class="stage">STAGE</div>
            <?php foreach (['D', 'E'] as $section) { ?>
            <div class="seat-row">
                <?php foreach ($allSeats[$section] as $seatCode) {
                        $class = in_array($seatCode, $reservedSeats) ? 'reserved' : 'available';
                        echo '<div class="seat ' . $class . '" data-seat-code="' . $seatCode . '">' . $seatCode . '</div>';
                    } ?>
            </div>
            <?php } ?>
        </div>

        <!-- Right Section: F, G, H -->
        <div class="seat-column">
            <?php foreach (['F', 'G', 'H'] as $section) { ?>
            <div class="seat-row">
                <?php foreach ($allSeats[$section] as $seatCode) {
                        $class = in_array($seatCode, $reservedSeats) ? 'reserved' : 'available';
                        echo '<div class="seat ' . $class . '" data-seat-code="' . $seatCode . '">' . $seatCode . '</div>';
                    } ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="selected-seats-display">
        Selected Seat(s): <span id="selectedSeats">None</span>
    </div>

    <button class="btn" id="proceedBtn" <?php echo $eventHasPassed ? 'disabled' : ''; ?>>
        <?php echo $eventHasPassed ? 'For View Only' : 'Proceed to payment'; ?>
    </button>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const availableSeats = document.querySelectorAll(".seat.available");
        const reservedSeats = document.querySelectorAll(".seat.reserved");
        const selectedSeatsDisplay = document.getElementById("selectedSeats");
        const eventTitle = "<?php echo urlencode($event['eventTitle']); ?>"; // Add eventTitle to JavaScript

        function updateSelectedSeatsDisplay() {
            const selectedSeats = document.querySelectorAll(".seat.selected");
            const seatCodes = Array.from(selectedSeats).map(seat => seat.getAttribute("data-seat-code"));
            selectedSeatsDisplay.textContent = seatCodes.length > 0 ? seatCodes.join(", ") : "None";
        }

        availableSeats.forEach(seat => {
            seat.addEventListener("click", function() {
                if (!seat.classList.contains("reserved")) {
                    seat.classList.toggle("selected");
                    updateSelectedSeatsDisplay();
                }
            });
        });

        reservedSeats.forEach(seat => {
            seat.addEventListener("click", function() {
                alert("Seat " + seat.getAttribute("data-seat-code") + " is already reserved.");
            });
        });

        document.getElementById("proceedBtn").addEventListener("click", function() {
            if (this.disabled) {
                alert("The event has ended. Please view the event details.");
                return;
            }

            const selectedSeats = document.querySelectorAll(".seat.selected");
            if (selectedSeats.length === 0) {
                alert("Please select at least one seat.");
                return;
            }

            const seatCodes = Array.from(selectedSeats).map(seat => seat.getAttribute(
                "data-seat-code"));
            window.location.href = "payment.php?seats=" + encodeURIComponent(seatCodes.join(",")) +
                "&eventTitle=" + encodeURIComponent(eventTitle);
        });
    });
    </script>
</body>

</html>