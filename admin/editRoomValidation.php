<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 4/10/18
 * Time: 7:29 PM
 *
 * Checks that there are no errors in the input.
 * If there are, messages are display as such.
 * Otherwise, it loops through each hotel room in hotelRooms.xml,
 * and if the room number posted matches the room number in the XML file,
 * its contents are removed, and replaced with those values posted from editRoom.php
 *
 */

$currentPage = basename($_SERVER['PHP_SELF']);
include("../hidden/header.php");
include("../hidden/validationFunctions.php");
include("../hidden/sessionFunctions.php");
?>

<main>
    <div id="wrapper">
        <?php
        $noErrors = true;
        $arrayErrors = array();
        $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');

        if(isEmpty($_POST['number']) || ($_POST['number'] == $_POST['roomNumber'])) {
            $_POST['number'] = $_POST['roomNumber'];
        }else{
            foreach ($hotelRooms->hotelRoom as $hotelRoom) {
                $number = $hotelRoom->number;
                if ($number == $_POST['number']) {
                    //echo "<p>Room " . $_POST['number'] . " all ready exists.</p>";
                    array_push($arrayErrors, "Room " . $_POST['number'] . " all ready exists.");
                    $noErrors = false;
                    unsetSession("number");
                } else {
                    setSession('number');
                }
            }
        }

        foreach ($hotelRooms->hotelRoom as $hotelRoom) {
            $number = $hotelRoom->number;
            if ($number == $_POST['roomNumber']) {
                if (isEmpty($_POST['description'])) {
                    $_POST['description'] = $hotelRoom->description;
                } else {
                    setSession('description');
                }
                if (isEmpty($_POST['pricePerNight'])) {
                    $_POST['pricePerNight'] = $hotelRoom->pricePerNight;
                }
            }
        }
        if(!isMoney($_POST['pricePerNight'])){
            array_push($arrayErrors, "Enter a valid price - can contain only numbers and decimal points");
            $noErrors = false;
            unsetSession('pricePerNight');
        } else {
            setSession('pricePerNight');
        }

        if ($noErrors) {
            session_destroy();
            $roomNumber = $_POST['roomNumber'];
            $number = $_POST['number'];
            $roomType = $_POST['roomType'];
            $description = $_POST['description'];
            $pricePerNight = $_POST['pricePerNight'];

            foreach($hotelRooms->hotelRoom as $hotelRoom) {
                $number = $hotelRoom->number;
                $roomType = $hotelRoom->roomType;
                $description = $hotelRoom->description;
                $pricePerNight = $hotelRoom->pricePerNight;
                if ($_POST['roomNumber'] == $number) {
                    unset($number[0]);
                    unset($roomType[0]);
                    unset($description[0]);
                    unset($pricePerNight[0]);
                    $hotelRoom->addChild('number', $_POST['number']);
                    $hotelRoom->addChild('roomType', $_POST['roomType']);
                    $hotelRoom->addChild('description', $_POST['description']);
                    $hotelRoom->addChild('pricePerNight', $_POST['pricePerNight']);
                }
            }
            $hotelRooms->saveXML('../hidden/xml/hotelRooms.xml');
            echo "<div class='row'><div class='col-12'><h1>Success!</h1></div></div>";
            echo "<div class='row'>
                  <div class='col-12'>
                  <table>
                  <caption>Edited Room</caption>
                  <thead>
                  <tr>
                  <th scope='col'>Number</th>
                  <th scope='col'>Type</th>
                  <th scope='col'>Desc</th>
                  <th scope='col'>Price($)</th>
                  </tr>
                  </thead>
                  <tbody class='added-room-table'>
                  <tr>
                  <td>" . $_POST['number'] . "</td>
                  <td>" . $_POST['roomType'] . "</td>
                  <td> " . $_POST['description'] . "</td>
                  <td> " . $_POST['pricePerNight'] . "</td>
                  </tr>
                  </tbody>
                  </table>
                  </div>
                  </div>";
        } else {
            echo "<div class='row'>";
            echo "<div class='col-12'>";
            echo "<h3>Please fix these errors before continuing:</h3>";
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div class='col-12'>";
            echo "<ul class='error-ul'>";
            foreach($arrayErrors as $errors){
                echo "<li>" . $errors;
            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div class='col-12'>";
            echo "<form action='editRoom.php'><input class='submit return-admin-button' type='submit' value='Return To Edit Room'></form>";
            echo "</div>";
            echo "</div>";
        }

        ?>
    </div>
</main>

<?php include("../hidden/footer.php"); ?>
</body>
</html>
