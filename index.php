<!DOCTYPE html>
<html lang="en">

<?php
session_start();

$scriptList = array('js/jquery-3.3.1.min.js', 'js/cookie.js', 'js/bookRoom.js', 'js/bookings.js', 'js/searchValidation.js', 'js/map.js', 'leaflet/leaflet.js', 'js/testingAjax.js');
$currentPage = basename($_SERVER['PHP_SELF']);
include('hidden/header.php');
?>

<!--Main-->
<main>
    <div id="wrapper">
        <!--Displays Map-->
        <div id="map"></div>
        <!--Displays Search Form-->
        <div id="other">
            <div class="row">
                <div class="col-12">
                    <h1>Search Rooms</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form>

                        <label for="indate" class="label">Arrival Date</label>
                        <input type="date" name="indate" id="indate" class="input">


                        <label for="outdate" class="label">Departure Date</label>
                        <input type="date" name="outdate" id="outdate" class="input">


                        <input type="button" value="Search" id="button-search" name="search-button" class="input">

                    </form>
                    <div id="errors"></div>
                </div>
            </div>
        </div>
        <!--Displays all available rooms-->
        <div id="available">
            <div class="row">
                <div class="col-12">
                    <h1>Available Rooms</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="all-table">

                </div>
            </div>
            <!--Confirm booking/on success pop-up modal -->
            <div id="success-modal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <div class="row">
                        <div class="col-12">
                            <form id="modal-form">
                                <label for="name" class="label">Name</label>
                                <input type="text" name="name" id="name" class="input">
                                <input type="hidden" name="num" id="num" value="">
                                <input type="button" value="Confirm" id="name-button" name="name-button" class="input">
                            </form>
                            <div id="success-message"></div>
                            <div id="modal-errors"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<!--Footer-->
<?php include("hidden/footer.php"); ?>

</body>
</html>