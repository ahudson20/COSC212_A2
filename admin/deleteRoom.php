<!DOCTYPE html>
<html lang="en">

<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 5/10/18
 * Time: 8:06 AM
 *
 * Contains a drop-down of all the rooms, listed by their number.
 * When submitted, the room number is posted to deleteRoomValidation.php
 *
 */
$scriptList = array('../js/jquery-3.3.1.min.js');
$currentPage = basename($_SERVER['PHP_SELF']);
include('../hidden/header.php');
?>
<!--Main-->
<main>
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <h1>Delete Room</h1>
                <p id="delete-warning">NOTE: Removing a room will also remove any associated bookings</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="deleteRoomValidation.php" method="post">
                            <label for="number" class="label">Delete Room</label>
                            <select name="number" class="input">
                                <?php
                                $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');
                                foreach($hotelRooms->hotelRoom as $hotelRoom) {
                                    $number = $hotelRoom->number;
                                    echo "<option value='$number'>$number</option>";
                                }
                                ?>
                            </select>
                        <input class="input" type="submit" value="Delete Room">
                </form>
            </div>
        </div>
    </div>
</main>
<!--Footer-->
<?php include("../hidden/footer.php"); ?>
</body>
</html>
