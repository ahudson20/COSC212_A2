<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 2/10/18
 * Time: 10:09 AM
 *
 * Checks the input to ensure that there are no errors.
 * If there are errors, it displays messages as such.
 * If there are no errors, the input is written to the XML file,
 * and the input is displayed back out to the users, along with a,
 * success message.
 *
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../hidden/header.php");
include("../hidden/validationFunctions.php");
include("../hidden/sessionFunctions.php")
?>

<!--Main-->
<main>
    <div id="wrapper">
        <?php
        $noErrors = true;
        $arrayErrors = array();
        $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');
        foreach ($hotelRooms->hotelRoom as $hotelRoom) {
            $number = $hotelRoom->number;
            if ($number == $_POST['number']) {
                array_push($arrayErrors, "Room " . $_POST['number'] . " all ready exists.");
                $noErrors = false;
                unsetSession("number");
            }
        }
        if (isEmpty($_POST['number']) || !isDigits($_POST['number'])) {
            array_push($arrayErrors, "Enter a valid room number");
            $noErrors = false;
            unsetSession('number');
        } else {
            setSession('number');
        }
        if (isEmpty($_POST['roomType'])) {
            array_push($arrayErrors, "Enter a room type");
            $noErrors = false;
            unsetSession('roomType');
        } else {
            setSession('roomType');
        }
        if (isEmpty($_POST['description'])) {
            array_push($arrayErrors, "Enter a description");
            $noErrors = false;
            unsetSession('description');
        } else {
            setSession('description');
        }
        if (!isMoney($_POST['pricePerNight'])) {
            array_push($arrayErrors, "Enter a valid price - can contain only numbers and decimal points");
            $noErrors = false;
            unsetSession('pricePerNight');
        } else {
            setSession('pricePerNight');
        }
        if ($noErrors) {
            session_destroy();
            $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');
            $newRoom = $hotelRooms->addChild('hotelRoom');
            $newRoom->addChild('number', $_POST['number']);
            $newRoom->addChild('roomType', $_POST['roomType']);
            $newRoom->addChild('description', $_POST['description']);
            $newRoom->addChild('pricePerNight', $_POST['pricePerNight']);
            $hotelRooms->saveXML('../hidden/xml/hotelRooms.xml');
            echo "<div class='row'><div class='col-12'><h1>Success!</h1></div></div>";
            echo "<div class='row'>
                  <div class='col-12'>
                  <table>
                  <caption>Added Room</caption>
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
            foreach ($arrayErrors as $errors) {
                echo "<li>" . $errors;
            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div class='col-12'>";
            echo "<form action='addRoom.php'><input class='submit return-admin-button' id='return-add-button' type='submit' value='Return To Adding Room'></form>";
            echo "</div>";
            echo "</div>";
        }
        ?>

    </div>
</main>

<!--Footer-->
<?php include("../hidden/footer.php"); ?>
</body>
</html>
