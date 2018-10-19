<?php
/**
 * Created by PhpStorm.
 * User: anaruhudson
 * Date: 29/09/18
 * Time: 3:02 PM
 *
 * Takes in the data that has been posted to it via AJAX,
 * and writes a new booking to the roomBookings XML file.
 */

        $indate2 = $_POST['indate1'];
        $outdate2 = $_POST['outdate1'];

        $pieces = explode("/", $indate2);
        $pieces2 = explode("/", $outdate2);

        $orders = simplexml_load_file('../hidden/xml/roomBookings.xml');
        $newBooking = $orders->addChild('booking');


        $newBooking->addChild('number', $_POST['num1']);
        $newBooking->addChild('name', $_POST['name1']);


        $newInDate = $newBooking->addChild('checkin');
        $newInDate->addChild('day', $pieces[0]);
        $newInDate->addChild('month', $pieces[1]);
        $newInDate->addChild('year', $pieces[2]);

        $newOutDate = $newBooking->addChild('checkout');
        $newOutDate->addChild('day', $pieces2[0]);
        $newOutDate->addChild('month', $pieces2[1]);
        $newOutDate->addChild('year', $pieces2[2]);

        $orders->saveXML('../hidden/xml/roomBookings.xml');

?>
