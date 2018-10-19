<head>

    <title>Hotel Galley</title>
    <meta charset="UTF-8">
    <meta name="author" content="Anaru Hudson">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--CSS and Font-->
<!--    <link rel="stylesheet" type="text/css" href="css/style.css">-->
<!--    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">-->

    <!--Leaflet Map-->
<!--    <link rel="stylesheet" href="../leaflet/leaflet.css"/>-->

    <?php if($currentPage === 'index.php' || $currentPage === 'rooms.php' || $currentPage === 'bookings.php' || $currentPage === 'admin.php') {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">";
        echo "<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\">";
        echo "<link rel=\"stylesheet\" href=\"leaflet/leaflet.css\"/>";
    } else {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/style.css\">";
        echo "<link rel=\"stylesheet\" href=\"../leaflet/leaflet.css\"/>";
        echo "<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\">";
    }

    if (isset($scriptList) && is_array($scriptList)) {
        foreach ($scriptList as $script) {
            echo "<script src='$script'></script>";
        }
    }
    ?>

</head>

<body>
<!--Navigation-->
<header>
    <nav>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    if($currentPage === 'admin.php' ){
        echo "<a href=\"#\">Admin</a>";
    }else{
        if($currentPage === 'bookings.php' || $currentPage === 'rooms.php' || $currentPage === 'index.php'){
            echo "<a href=\"admin.php\">Admin</a>";
        }else{
            echo "<a href=\"../admin.php\">Admin</a>";
        }
    }

    if($currentPage === 'bookings.php'){
        echo "<a href=\"#\">Bookings</a>";
    }else{
        if($currentPage === 'admin.php' || $currentPage === 'rooms.php' || $currentPage === 'index.php'){
            echo "<a href=\"bookings.php\">Bookings</a>";
        }else{
            echo "<a href=\"../bookings.php\">Bookings</a>";
        }
    }

    if($currentPage === 'rooms.php'){
        echo "<a href=\"#\">Rooms</a>";
    }else{
        if($currentPage === 'admin.php' || $currentPage === 'bookings.php' || $currentPage === 'index.php'){
            echo "<a href=\"rooms.php\">Rooms</a>";
        }else{
            echo "<a href=\"../rooms.php\">Rooms</a>";
        }
    }

    if($currentPage === 'index.php'){
        echo "<a href=\"#\" class=\"showHide\" id=\"showHide\">Find Us</a>";
    }else{
        if($currentPage === 'admin.php' || $currentPage === 'bookings.php' || $currentPage === 'rooms.php'){
            echo "<a href=\"index.php\">Book Now</a>";
        }else{
            echo "<a href=\"../index.php\">Book Now</a>";
        }
    }
    ?>
    </nav>
</header>
