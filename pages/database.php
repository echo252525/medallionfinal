<?php 
include_once ("../connection/session.php"); 
include_once ("../connection/connection.php"); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Normalized Table</title>
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        position: relative;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-delete,
    .btn-edit,
    .btn-add-event {
        padding: 6px 12px;
        margin-right: 5px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-delete {
        background-color: #e74c3c;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }

    .btn-edit {
        background-color: #3498db;
    }

    .btn-edit:hover {
        background-color: #2980b9;
    }

    .btn-add-event {
        background-color: #2ecc71;
    }

    .btn-add-event:hover {
        background-color: #27ae60;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="password"],
    textarea {
        width: 100%;
        padding: 8px;
        margin: 5px 0 10px 0;
        box-sizing: border-box;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #27ae60;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    </style>
</head>

<body>
    <?php include_once "../controller/sidebar.php"; ?>
    <section id="content">
        <?php include_once "../controller/navbar.php"; ?>
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Normalized Table</h1>
                </div>
            </div>

            <!-- USER TABLE -->
            <section class="table-container">
                <h2>User Table</h2>
                <input type="text" id="searchUser" placeholder="Search Users...">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Contact Number</th>
                            <th>Balance</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $stmt = $pdo->query("SELECT `userid`, `fullname`, `contactNumber`, `balance`, `email`, `password`, `dateCreated` FROM `users`");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>{$row['userid']}</td>
                            <td>".htmlspecialchars($row['fullname'])."</td>
                            <td>".htmlspecialchars($row['contactNumber'])."</td>
                            <td>{$row['balance']}</td>
                            <td>".htmlspecialchars($row['email'])."</td>
                            <td>••••••••</td>
                            <td>{$row['dateCreated']}</td>
                            <td>
                                <button class='btn-edit' onclick=\"openEditModal('{$row['userid']}', '{$row['fullname']}', '{$row['contactNumber']}', '{$row['balance']}', '{$row['email']}')\">Edit</button>
                                <button class='btn-delete' onclick=\"if(confirm('Are you sure you want to delete user {$row['fullname']}?')) { window.location.href='../remote/deleteUser.php?userid={$row['userid']}'; }\">Delete</button>
                            </td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </section>

            <!-- EDIT USER MODAL -->
            <div id="editUserModal" class="modal">
                <div class="modal-content">
                    <span class="close"
                        onclick="document.getElementById('editUserModal').style.display='none'">&times;</span>
                    <h3>Edit User</h3>
                    <form action="../remote/editUser.php" method="POST">
                        <input type="hidden" id="editUserId" name="userid">
                        <label>Fullname:</label>
                        <input type="text" id="editFullname" name="fullname" required>
                        <label>Contact Number:</label>
                        <input type="text" id="editContactNumber" name="contactNumber" required>
                        <label>Balance:</label>
                        <input type="number" id="editBalance" name="balance" required>
                        <label>Email:</label>
                        <input type="email" id="editEmail" name="email" required>
                        <input type="submit" value="Save Changes">
                    </form>
                </div>
            </div>

            <!-- EVENT TABLE -->
            <section class="table-container" aria-label="Event Table">
                <h2>Event Table</h2>
                <input type="text" id="searchEvent" placeholder="Search Events...">
                <table id="eventTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Picture</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $stmt = $pdo->query("SELECT `eventId`, `eventTitle`, `eventPicture`, `eventDescription`, `eventDate`, `startTime`, `endTime` FROM `event`");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>{$row['eventId']}</td>
                            <td>{$row['eventTitle']}</td>
                            <td><img src='../images/{$row['eventPicture']}' class='event-picture' width='80'/></td>
                            <td>{$row['eventDescription']}</td>
                            <td>{$row['eventDate']}</td>
                            <td>" . date("g:i A", strtotime($row['startTime'])) . "</td>
                            <td>" . date("g:i A", strtotime($row['endTime'])) . "</td>
                            <td>
                        <button class='btn-edit' onclick=\"openEditEventModal('{$row['eventId']}', '{$row['eventTitle']}', '{$row['eventDescription']}', '{$row['eventDate']}', '{$row['startTime']}', '{$row['endTime']}')\">Edit</button>
                        <button class='btn-delete' onclick=\"if(confirm('Are you sure you want to delete event {$row['eventTitle']}?')) { window.location.href='../remote/deleteEvent.php?eventId={$row['eventId']}'; }\">Delete</button>
                    </td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <div class="event-footer">
                    <button class="btn-add-event" type="button"
                        onclick="document.getElementById('addEventModal').style.display='block'">Add Event</button>
                </div>
            </section>

            <!-- Edit Event Modal -->
            <div id="editEventModal" class="modal">
                <div class="modal-content">
                    <span class="close"
                        onclick="document.getElementById('editEventModal').style.display='none'">&times;</span>
                    <h3>Edit Event</h3>
                    <form action="../remote/editEvent.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editEventId" name="eventId">
                        <label>Event Title:</label>
                        <input type="text" id="editEventTitle" name="eventTitle" required>
                        <label>Event Description:</label>
                        <textarea id="editEventDescription" name="eventDescription" rows="4" required></textarea>
                        <label>Event Date:</label>
                        <input type="date" id="editEventDate" name="eventDate" required>
                        <label>Start Time:</label>
                        <input type="time" id="editStartTime" name="startTime" required>
                        <label>End Time:</label>
                        <input type="time" id="editEndTime" name="endTime" required>
                        <input type="submit" value="Save Changes">
                    </form>
                </div>
            </div>


            <!-- ADD EVENT MODAL -->
            <div id="addEventModal" class="modal">
                <div class="modal-content">
                    <span class="close"
                        onclick="document.getElementById('addEventModal').style.display='none'">&times;</span>
                    <h3>Add New Event</h3>
                    <form action="../remote/addEvent.php" method="POST" enctype="multipart/form-data">
                        <label>Event Title:</label>
                        <input type="text" name="eventTitle" required>
                        <label>Event Picture:</label>
                        <input type="file" name="eventPicture" required>
                        <label>Event Description:</label>
                        <textarea name="eventDescription" rows="4" required></textarea>
                        <label>Event Date:</label>
                        <input type="date" name="eventDate" required>
                        <label>Start Time:</label>
                        <input type="time" name="startTime" required>
                        <label>End Time:</label>
                        <input type="time" name="endTime" required>
                        <input type="submit" value="Add Event">
                    </form>
                </div>
            </div>

            <!-- SEAT TABLE -->
            <section class="table-container" aria-label="Seat Table">
                <h2>Seat Table</h2>
                <input type="text" id="searchSeat" placeholder="Search Seats...">
                <table id="seatTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seat Code</th>
                            <th>Event Title</th>
                            <th>Seat Owner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $stmt = $pdo->query("SELECT `seatId`, `seatCode`, `seatEventTitle` , `seatOwner` FROM `seats`");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>{$row['seatId']}</td>
                            <td>{$row['seatCode']}</td>
                            <td>{$row['seatEventTitle']}</td>
                            <td>{$row['seatOwner']}</td>
                            <td>
                <button class='btn-delete' onclick=\"if(confirm('Are you sure you want to delete seat {$row['seatCode']}?')) { window.location.href='../remote/deleteSeat.php?seatId={$row['seatId']}'; }\">Delete</button>
            </td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </section>

            <!-- TICKET TABLE -->
            <section class="table-container" aria-label="Receipt Table">
                <h2>Ticket Table</h2>
                <input type="text" id="searchTicket" placeholder="Search Tickets...">
                <table id="ticketTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Buyer Name</th>
                            <th>Event Title</th>
                            <th>Seat Code</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $stmt = $pdo->query("SELECT `ticketId`, `buyerName`, `ticketEventTitle`, `ticketSeatCodes`, `totalPrice`, `paymentMethod` FROM `ticket`");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>
                                    <td>{$row['ticketId']}</td>
                                    <td>{$row['buyerName']}</td>
                                    <td>{$row['ticketEventTitle']}</td>
                                    <td>";
                                
                                $seats = explode(',', $row['ticketSeatCodes']);
                                foreach ($seats as $seat) {
                                    $seatTrimmed = trim($seat);
                                    echo "<span style='display: inline-block; background-color: #17a2b8; color: white; padding: 4px 8px; margin: 2px; border-radius: 4px; font-size: 12px;'>$seatTrimmed</span>";
                                }

                                echo "</td>
                                    <td>{$row['totalPrice']}</td>
                                    <td>{$row['paymentMethod']}</td>
                                    <td>
                                        <button class='btn-delete' onclick=\"if(confirm('Are you sure you want to delete ticket for {$row['buyerName']}?')) { window.location.href='../remote/deleteTicket.php?ticketId={$row['ticketId']}'; }\">Delete</button>
                                    </td>
                                </tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </section>
        </main>
    </section>

    <script>
    function openEditModal(userid, fullname, contactNumber, balance, email) {
        document.getElementById('editUserModal').style.display = 'block';
        document.getElementById('editUserId').value = userid;
        document.getElementById('editFullname').value = fullname;
        document.getElementById('editContactNumber').value = contactNumber;
        document.getElementById('editBalance').value = balance;
        document.getElementById('editEmail').value = email;
    }

    // Search functions
    function addSearch(inputId, tableId) {
        document.getElementById(inputId).addEventListener("keyup", function() {
            var filter = this.value.toUpperCase();
            var rows = document.querySelector(`#${tableId} tbody`).getElementsByTagName("tr");
            for (let row of rows) {
                let txt = row.textContent || row.innerText;
                row.style.display = txt.toUpperCase().includes(filter) ? "" : "none";
            }
        });
    }

    addSearch("searchUser", "userTable");
    addSearch("searchEvent", "eventTable");
    addSearch("searchSeat", "seatTable");
    addSearch("searchTicket", "ticketTable");

    function openEditEventModal(eventId, eventTitle, eventDescription, eventDate, startTime, endTime) {
        document.getElementById('editEventModal').style.display = 'block';
        document.getElementById('editEventId').value = eventId;
        document.getElementById('editEventTitle').value = eventTitle;
        document.getElementById('editEventDescription').value = eventDescription;
        document.getElementById('editEventDate').value = eventDate;
        document.getElementById('editStartTime').value = startTime;
        document.getElementById('editEndTime').value = endTime;
    }
    </script>

    <?php include_once "../css/generalStyles.php"; ?>
    <?php include_once "../css/databaseStyles.php"; ?>
</body>

</html>