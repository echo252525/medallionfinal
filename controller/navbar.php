<!-- NAVBAR -->
<nav>
    <form action="#">
        <div class="form-input">
            <h1 class="title">Event Ticketing System</h1>
        </div>
    </form>


    <div class="text"><?php 
        echo isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : 'Guest';
        ?></div>
    </a>
</nav>
<?php include_once "../css/generalStyles.php"; ?>
<?php include_once "../css/navbarStyles.php"; ?>
<!-- NAVBAR -->