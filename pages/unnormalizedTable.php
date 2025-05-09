<?php 
include_once ("../connection/session.php");  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Normalized Ticket Report</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #333;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #555;
        color: white;
    }
    </style>
</head>

<body>

    <?php include_once "../controller/sidebar.php"; ?>
    <!-- CONTENT -->
    <section id="content">
        <?php include_once "../controller/navbar.php"; ?>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Normalized Table</h1>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Seat ID</th>
                        <th>Buyer Name</th>
                        <th>Buyer Email</th>
                        <th>Buyer Contact</th>
                        <th>Event Title</th>
                        <th>Seat Code</th>
                        <th>Individual Price</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $sql = "
            SELECT 
                s.seatId, 
                t.buyerName, 
                u.email AS buyerEmail, 
                u.contactNumber AS buyerContact,
                e.eventTitle, 
                s.seatCode, 
                t.paymentMethod
            FROM ticket t
            LEFT JOIN users u ON u.fullname = t.buyerName
            LEFT JOIN seats s ON s.seatOwner = t.buyerName AND s.seatEventTitle = t.ticketEventTitle
            LEFT JOIN event e ON e.eventTitle = t.ticketEventTitle
        ";

        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$row['seatId']}</td>
                <td>".htmlspecialchars($row['buyerName'])."</td>
                <td>".htmlspecialchars($row['buyerEmail'])."</td>
                <td>".htmlspecialchars($row['buyerContact'])."</td>
                <td>".htmlspecialchars($row['eventTitle'])."</td>
                <td>".htmlspecialchars($row['seatCode'])."</td>
                <td>500</td>
                <td>".htmlspecialchars($row['paymentMethod'])."</td>
            </tr>";
        }
        ?>
                </tbody>
            </table>
        </main>
    </section>
    <script src="../script/database.js"></script>
    <?php include_once "../css/generalStyles.php"; ?>
    <?php include_once "../css/databaseStyles.php"; ?>
</body>

</html>