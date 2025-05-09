<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <img src="../images/medallionLogo.png" alt="medallion logo" class="logo">
        <span class="text">Medallion Theatre</span>
    </a>
    <ul class="side-menu top">
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'database.php') ? 'active' : ''; ?>">
            <a href="../pages/database.php" class="nav">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Normalized Table</span>
            </a>
        </li>
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'unnormalizedTable.php') ? 'active' : ''; ?>">
            <a href="../pages/unnormalizedTable.php" class="nav">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Unnormalized Table</span>
            </a>
        </li>
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'events.php') ? 'active' : ''; ?>">
            <a href="../pages/events.php" class="nav">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Reserve Ticket</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="../logOut.php" class="nav logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>

<script src="../script/sidebar.js"></script>
<?php include_once "../css/generalStyles.php"; ?>
<?php include_once "../css/sidebarStyles.php"; ?>