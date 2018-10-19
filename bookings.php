<!DOCTYPE html>
<html lang="en">

<?php
$scriptList = array('js/jquery-3.3.1.min.js', 'js/cookie.js', 'js/showBookings.js');
$currentPage = basename($_SERVER['PHP_SELF']);
include('hidden/header.php');
?>

<!--Main-->
<main>
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <h1>All Bookings</h1>
            </div>
        </div>
        <!--Displays all bookings in cookie-->
        <div class="row">
            <div class="col-12" id="show-bookings">
                <table id="bookings">
                    <caption>Booking Summary</caption>
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">In</th>
                        <th scope="col">Out</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<!--Footer-->
<?php include("hidden/footer.php"); ?>
</body>
</html>