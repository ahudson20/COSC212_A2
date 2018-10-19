<!DOCTYPE html>
<html lang="en">

<?php
$scriptList = array('js/jquery-3.3.1.min.js', 'js/showRooms.js');
$currentPage = basename($_SERVER['PHP_SELF']);
include('hidden/header.php');
?>

<!--Main-->
<main>
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <!--<h1>All Rooms</h1>-->
                <table id="room-type-all">
                    <caption>Types</caption>
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Beds</th>
                        <th scope="col">Guests</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!--Displays all rooms-->
        <div class="row">
            <div class="col-12">
                <table id="rooms-all">
                    <caption>Rooms</caption>
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Type</th>
                        <th scope="col">Detail</th>
                        <th scope="col">Price</th>
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