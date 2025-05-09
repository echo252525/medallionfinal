<?php include_once ("../connection/session.php"); ?>
<?php include_once "../css/generalStyles.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <style>
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 32px;
        color: #333;
    }

    .toggle-btn {
        display: block;
        margin: 0 auto 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    .main-scroll-div {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .cover {
        position: relative;
        width: 100%;
    }

    .scroll-images {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 20px;
        padding-left: calc(50% - 250px);
        padding-right: calc(50% - 250px);
    }

    .scroll-images::-webkit-scrollbar {
        display: none;
    }

    .child {
        flex: 0 0 auto;
        width: 500px;
        margin: 0 20px;
        scroll-snap-align: center;
        transition: transform 0.4s ease, filter 0.4s ease;
        transform-origin: center center;
        text-align: center;
    }

    .child-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.4s ease;
        position: relative;
    }

    .child-img::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.6);
        border-radius: 12px;
    }

    .child h3 {
        margin: 10px 0 5px;
        font-size: 18px;
        color: #333;
        opacity: 0.5;
        transition: opacity 0.4s ease;
    }

    .child p {
        font-size: 14px;
        color: #666;
        opacity: 0.5;
        transition: opacity 0.4s ease;
    }

    .child.spotlight {
        transform: scale(1.2);
        z-index: 10;
    }

    .child.spotlight h3,
    .child.spotlight p {
        opacity: 1;
    }

    .cover::before,
    .cover::after {
        position: absolute;
        content: "";
        top: 0;
        width: 100px;
        height: 100%;
        z-index: 20;
        pointer-events: none;
    }

    .cover::before {
        left: 0;
        background: linear-gradient(to right, #f4f4f4, transparent);
    }

    .cover::after {
        right: 0;
        background: linear-gradient(to left, #f4f4f4, transparent);
    }
    </style>
</head>

<body>

    <?php include_once "../controller/sidebar.php"; ?>

    <section id="content">
        <?php include_once "../controller/navbar.php"; ?>
        <main>
            <div class="container">
                <h1>Events</h1>

                <button class="toggle-btn" id="toggleButton">Show Past Events</button>

                <div class="main-scroll-div">
                    <div class="cover">
                        <div class="scroll-images" id="scroll-container">
                            <?php
                                date_default_timezone_set('Asia/Manila');
                                $currentDate = date('Y-m-d');
                                $currentTime = date('H:i:s');

                                $stmt = $pdo->query("SELECT * FROM event");
                                $events = [];

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $event = [
                                        'title' => htmlspecialchars($row['eventTitle']),
                                        'description' => htmlspecialchars($row['eventDescription']),
                                        'picture' => $row['eventPicture'],
                                        'date' => $row['eventDate'],
                                        'startTime' => $row['startTime'],
                                        'endTime' => $row['endTime']
                                    ];

                                    $isPast = false;
                                    if ($event['date'] < $currentDate) {
                                        $isPast = true;
                                    } elseif ($event['date'] == $currentDate && $event['endTime'] < $currentTime) {
                                        $isPast = true;
                                    }

                                    $event['isPast'] = $isPast;
                                    $events[] = $event;
                                }

                                foreach ($events as $event) {
                                    $class = $event['isPast'] ? 'past-event' : 'upcoming-event';
                                    echo '<div class="child ' . $class . '" style="display: ' . ($event['isPast'] ? 'none' : 'block') . ';">
                                            <a href="selectSeats.php?eventTitle=' . urlencode($event['title']) . '">
                                                <img class="child-img" src="' . $event['picture'] . '" alt="Event">
                                            </a>
                                            <h3>' . $event['title'] . '</h3>
                                            <p>' . $event['description'] . '</p>
                                          </div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </section>

    <script>
    const scrollContainer = document.getElementById('scroll-container');
    const children = document.querySelectorAll('.child');
    const toggleButton = document.getElementById('toggleButton');

    let showingPast = false;

    function updateSpotlight() {
        const containerRect = scrollContainer.getBoundingClientRect();
        const containerCenter = containerRect.left + containerRect.width / 2;

        let closest = null;
        let closestDistance = Infinity;

        children.forEach(child => {
            const rect = child.getBoundingClientRect();
            const childCenter = rect.left + rect.width / 2;
            const distance = Math.abs(containerCenter - childCenter);

            if (distance < closestDistance) {
                closestDistance = distance;
                closest = child;
            }
        });

        children.forEach(child => child.classList.remove('spotlight'));
        if (closest) closest.classList.add('spotlight');
    }

    scrollContainer.addEventListener('scroll', () => {
        window.requestAnimationFrame(updateSpotlight);
    });

    window.addEventListener('load', updateSpotlight);
    window.addEventListener('resize', updateSpotlight);

    toggleButton.addEventListener('click', () => {
        showingPast = !showingPast;

        document.querySelectorAll('.upcoming-event').forEach(el => {
            el.style.display = showingPast ? 'none' : 'block';
        });

        document.querySelectorAll('.past-event').forEach(el => {
            el.style.display = showingPast ? 'block' : 'none';
        });

        toggleButton.textContent = showingPast ? 'Show Upcoming Events' : 'Show Past Events';

        updateSpotlight();
    });
    </script>

</body>

</html>