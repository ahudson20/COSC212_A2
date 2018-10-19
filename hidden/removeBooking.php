<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 29/09/18
 * Time: 6:30 PM
 *
 * Takes in the values posted to it via AJAX,
 * and removes the booking in the roomBookings XML that matches
 * the values posted to it.
 *
 */



$num2 = $_POST['num1'];
$name2 = $_POST['name1'];
$indate2 = $_POST['indate1'];
$outdate2 = $_POST['outdate1'];

$pieces = explode("/", $indate2);
$pieces2 = explode("/", $outdate2);

$bookings = simplexml_load_file('../hidden/xml/roomBookings.xml');
foreach($bookings->booking as $booking) {
    $name = $booking->name;
    $number = $booking->number;
    $checkin = $booking->checkin->day."/".$booking->checkin->month."/".$booking->checkin->year;
    $checkout = $booking->checkout->day."/".$booking->checkout->month."/".$booking->checkout->year;

    if ($name2 == $name && $num2 == $number && $indate2 == $checkin && $outdate2 == $checkout) {
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
    }
}

/**
 * If the cookie is set, it will check for the booking that was jsut removed.
 * If that booking is present in the cookie, it will also remove the booking from the cookie,
 * thus removing the booking from the all bookings page, as well as from roomBookings.xml
 */

if(isset($_COOKIE['mybookings'])) {
    $finalArray = array();
    $c = json_decode($_COOKIE['mybookings'], true);
    $count = count($c);
    for($i = 0;$i<$count;$i++){
        if($c[$i]['bookedName'] == $name2 && $c[$i]['bookedNum'] == $num2  && $c[$i]['bookedInDate'] == $indate2  && $c[$i]['bookedOutDate'] == $outdate2){
            unset($c[$i]);
        }else{
            $array = array("bookedName" => $c[$i]['bookedName'], "bookedNum" => $c[$i]['bookedNum'], "bookedInDate" => $c[$i]['bookedInDate'],"bookedOutDate" => $c[$i]['bookedOutDate']);
            array_push($finalArray, $array);
            unset($array);
        }
    }

//    $a = array("bookedName" => $name2, "bookedNum" => $num2, "bookedInDate" => $indate2,"bookedOutDate" => $outdate2);
//
//    foreach ($c as $thisArrIndex=>$a)
//    {
//        if ( $a['bookedName'] == $name2  && $a['bookedNum'] == $num2  && $a['bookedInDate'] == $indate2  && $a['bookedOutDate'] == $outdate2)
//        {
//            unset($c[$thisArrIndex]);
//        }
//    }
    //$c = json_encode($c);
    $finalArray = json_encode($finalArray);
    setcookie('mybookings', $finalArray, time() + (86400 * 30), "/");
}
?>