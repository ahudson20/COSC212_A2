<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 5/10/18
 * Time: 8:41 AM
 *
 * Takes the room number posted to it from deleteRoom.php.
 * It then loops through all of the rooms in hotelRooms.xml,
 * and deletes the rooms with the corresponding number.
 *
 * It also loops through all of the bookings in roomBookings.xml,
 * and deletes any bookings made for that room. If it deletes any bookings,
 * the booking details are displayed back to the user.
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
        if(!(isset($_POST['number']))){
            echo "<div class='row'>
                <div class='col-12'>
                    <h1>Please return the the Admin page!</h1>
                </div>
              </div>";
            echo "<div class='row'>";
            echo "<div class='col-12'>";
            echo "<form action='../admin.php'><input class='submit return-admin-button' type='submit' value='Return To Admin'></form>";
            echo "</div>";
            echo "</div>";
        }else {
            $hotelRooms = simplexml_load_file('../hidden/xml/hotelRooms.xml');
            $bookings = simplexml_load_file('../hidden/xml/roomBookings.xml');
            $numberToDelete = $_POST['number'];
            $array = array();
            foreach ($hotelRooms->hotelRoom as $hotelRoom) {
                $number = $hotelRoom->number;
                if ($number == $numberToDelete) {
                    unset($hotelRoom->name[0]);
                    unset($hotelRoom->number[0]);
                    unset($hotelRoom->roomType[0]);
                    unset($hotelRoom->description[0]);
                    unset($hotelRoom->pricePerNight[0]);
                    unset($hotelRoom[0]);
                    $hotelRooms->saveXML('../hidden/xml/hotelRooms.xml');
                }
            }
            echo "<div class='row'>
                <div class='col-12'>
                    <h1>Success!</h1>
                    <p class='admin-success-delete'>Room " . $numberToDelete . " was deleted</p>
                </div>
              </div>";
            foreach ($bookings->booking as $booking) {
                $number = $booking->number;
                if ($number == $numberToDelete) {
                    $bookingArray = array();
                    array_push($bookingArray, strval($booking->name[0]), strval($booking->number[0]), strval($booking->checkin->day[0]) . '/' . strval($booking->checkin->month[0]) . '/' . strval($booking->checkin->year[0]), strval($booking->checkout->day[0]) . '/' . strval($booking->checkout->month[0]) . '/' . strval($booking->checkout->year[0]));
                    unset($booking->name[0]);
                    unset($booking->number[0]);
                    unset($booking->checkin->year[0]);
                    unset($booking->checkin->month[0]);
                    unset($booking->checkin->day[0]);
                    unset($booking->checkin[0]);
                    unset($booking->checkout->year[0]);
                    unset($booking->checkout->month[0]);
                    unset($booking->checkout->day[0]);
                    unset($booking->checkout[0]);
                    unset($booking[0]);
                    $bookings->saveXML('../hidden/xml/roomBookings.xml');
                    array_push($array, $bookingArray);
                }
            }

            if (count($array) > 0) {
                //$aCount = count($array);

                echo "<div class='row'>
                  <div class='col-12'>
                  <table>
                  <caption>Bookings Deleted</caption>
                  <thead>
                  <tr>
                  <th scope='col'>Name</th>
                  <th scope='col'>Number</th>
                  <th scope='col'>In</th>
                  <th scope='col'>Out</th>
                  </tr>
                  </thead>
                  <tbody class='added-room-table'>
                  ";

                for ($row = 0; $row < count($array); $row++) {
                    echo "<tr>";
                    for ($col = 0; $col < count($array[$row]); $col++) {
                        echo "<td>" . $array[$row][$col] . "</td>";
                    }
                    echo "</tr>";
                }

                echo "</tbody>
                  </table>
                  </div>
                  </div>";


                if(isset($_COOKIE['mybookings'])) {
                    $finalArray = array();
                    $c = json_decode($_COOKIE['mybookings'], true);
                    $count = count($c);
                    for($i = 0;$i<$count;$i++){
                        if($c[$i]['bookedNum'] == $numberToDelete){
                            unset($c[$i]);
                        }else{
                            $array = array("bookedName" => $c[$i]['bookedName'], "bookedNum" => $c[$i]['bookedNum'], "bookedInDate" => $c[$i]['bookedInDate'],"bookedOutDate" => $c[$i]['bookedOutDate']);
                            array_push($finalArray, $array);
                            unset($array);
                        }
                    }

                    $finalArray = json_encode($finalArray);
                    setcookie('mybookings', $finalArray, time() + (86400 * 30), "/");
                }



            } else {
                echo "<div class='row'><div class='col-12'><p class='admin-success-delete'>No bookings were removed for Room " . $numberToDelete . "</p></div></div>";
            }
        }
        ?>
    </div>
</main>

<?php include("../hidden/footer.php"); ?>
</body>
</html>
