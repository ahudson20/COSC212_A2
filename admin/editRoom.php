<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 4/10/18
 * Time: 6:36 PM
 *
 * Displays a drop-down of all of the rooms by their room number.
 * Shows a form for editing the details of the selected room.
 * If no new values are entered, the original values are used.
 *
 */
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include("../hidden/header.php");
?>

    <main>
        <div id="wrapper">
            <div class="row">
                <div class="col-12" id="edit-room-header">
                    <h1>Edit Room</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="editRoomValidation.php" method="post">

                            <label class="label">Room To Change</label>
                            <select name="roomNumber" class="input" <?php
                            if (isset($_SESSION['roomNumber'])) {
                                $room = $_SESSION['roomNumber'];
                            }?>>
                                <?php
                                $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');
                                foreach($hotelRooms->hotelRoom as $hotelRoom) {
                                    $number = $hotelRoom->number;
                                    if ($number === $room) {
                                        echo "<option value='$number' selected>$number</option>";
                                    } else {
                                        echo "<option value='$number'>$number</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label class="label">New Room Number</label>
                            <input type="text" name="number" class="input" <?php
                            if (isset($_SESSION['number'])) {
                                $number = $_SESSION['number'];
                                echo "value='$number'";
                            }
                            ?>>

                            <label class="label">New Room Type</label>
                            <select name="roomType" class="input" <?php
                            if (isset($_SESSION['roomType'])) {
                                $type = $_SESSION['roomType'];
                            }?>>
                                <?php
                                $roomTypes = simplexml_load_file('../xml/roomTypes.xml');
                                foreach($roomTypes->roomType as $room) {
                                    $id = $room->id;
                                    if ($id === $type) {
                                        echo "<option value='$id' selected>$id</option>";
                                    } else {
                                        echo "<option value='$id'>$id</option>";
                                    }
                                }
                                ?>
                            </select>

                            <label class="label">New Description</label>
                            <textarea name="description" class="input"><?php
                                if (isset($_SESSION['description'])) {
                                    $description = $_SESSION['description'];
                                    echo "$description";
                                }
                                ?></textarea>

                            <label class="label">New Price Per Night</label>
                            <input type="text" name="pricePerNight" class="input" <?php
                            if (isset($_SESSION['pricePerNight'])) {
                                $pricePerNight = $_SESSION['pricePerNight'];
                                echo "value='$pricePerNight'";
                            }
                            ?>>

                        <input class="input" type="submit" value="Modify Room">
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include("../hidden/footer.php"); ?>
</body>
</html>
