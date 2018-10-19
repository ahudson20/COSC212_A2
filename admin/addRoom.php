<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 2/10/18
 * Time: 9:58 AM
 *
 * Contains a form for creating a new room.
 * When submitted, the values are posted to addRoomValidation.php
 *
 */
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include("../hidden/header.php");
?>
    <!--Main-->
    <main>
        <div id="wrapper">
            <!--Header-->
            <div class="row">
                <div class="col-12">
                    <h1>Add a Room</h1>
                </div>
            </div>
            <!--Displays the form-->
            <div class="row">
                <div class="col-12" id="admin-header">
                    <form action="addRoomValidation.php" method="post">
                        <label for="number" class="label">Room Number</label>
                        <input type="text" name="number" id="number" class="input" <?php
                        if (isset($_SESSION['number'])) {
                            $number = $_SESSION['number'];
                            echo "value='$number'";
                        }
                        ?>>

                        <label for="roomType" class="label">Room Type</label>
                        <select name="roomType" id="roomType" class="input" <?php
                        if (isset($_SESSION['roomType'])) {
                            $type = $_SESSION['roomType'];
                        } ?>>
                            <?php
                            $roomTypes = simplexml_load_file('../hidden/xml/roomTypes.xml');
                            foreach ($roomTypes->roomType as $room) {
                                $id = $room->id;
                                if ($id === $type) {
                                    echo "<option value='$id' selected>$id</option>";
                                } else {
                                    echo "<option value='$id'>$id</option>";
                                }
                            }
                            ?>
                        </select>

                        <label class="label">Description</label>
                        <textarea name="description" class="input"><?php
                            if (isset($_SESSION['description'])) {
                                $description = $_SESSION['description'];
                                echo "$description";
                            }
                            ?></textarea>

                        <label for="pricePerNight" class="label">Price Per Night</label>
                        <input type="text" name="pricePerNight" id="pricePerNight" class="input" <?php
                        if (isset($_SESSION['pricePerNight'])) {
                            $pricePerNight = $_SESSION['pricePerNight'];
                            echo "value='$pricePerNight'";
                        }
                        ?>>
                        <input class="input" type="submit" value="Add Room">
                    </form>
                </div>
            </div>
        </div>
    </main>

<!--Footer-->
<?php include("../hidden/footer.php"); ?>
</body>
</html>
