var BookRoom = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * Recieves the XML data from the ajax get request, loops through the data extracting
     * all of the relevant information about each room to be stored in an object, which is then
     * pushed into the roomList array.
     * @param data the returned XML data from the ajax get request.
     * @returns {Array} roomList an array of objects representing all of the rooms in the hotel.
     */
    function returnAllRooms(data) {
        var roomList = [];
        var num, price;
        $(data).find("hotelRoom").each(function () {
            num = $(this).find("number")[0].textContent;
            price = $(this).find("pricePerNight")[0].textContent;
            roomList.push({
                roomNum: num,
                roomPrice: price
            });
        });
        return roomList;
    }

    /**
     * Receives the XML data from the ajax get request, loops through the data extracting the relevant information,
     * stores it in an object which is pushed to the bookedList array, and then returns the array.
     * @param data the XML data from the ajax get request.
     * @returns {Array} bookedList array of objects representing all of the rooms currently booked as per the XML.
     */
    function returnAllBooked(data) {
        var bookedList = [];
        $(data).find("booking").each(function () {
            var checkin = $(this).find("checkin");
            var checkout = $(this).find("checkout");

            var number = $(this).find("number")[0].textContent;

            var checkinday = $(checkin).find("day")[0].textContent;
            var checkinmonth = $(checkin).find("month")[0].textContent;
            var checkinyear = $(checkin).find("year")[0].textContent;

            var checkoutday = $(checkout).find("day")[0].textContent;
            var checkoutmonth = $(checkout).find("month")[0].textContent;
            var checkoutyear = $(checkout).find("year")[0].textContent;

            var indate = new Date(checkinyear, checkinmonth - 1, checkinday);
            var outdate = new Date(checkoutyear, checkoutmonth - 1, checkoutday);

            bookedList.push({
                roomNum: number,
                checkInDate: indate,
                checkOutDate: outdate
            });

        });
        return bookedList;
    }

    /**
     * Creates an ajax get request for the hotel rooms data. On success it calls the callback function,
     * and then returns the result of the callback function. On failure it just returns an empty array.
     * @param callback the function to be called on success.
     * @returns {Array} the array of all rooms that is returned from the callback function returnAllRooms.
     */
    function allRooms(callback) {
        var xmlSource = "xml/hotelRooms.xml";
        var rooms = [];
        //var xmlSource = "";
        //var roomList = [];
        $.ajax({
            type: "GET",
            url: xmlSource,
            async: false,
            cache: false,
            success: function (data) {
                rooms = callback(data);
            },
            error: function () {
                return rooms;
            }
        });
        return rooms;
    }

    /**
     * Creates an ajax get request for the booked hotel rooms data. On success, it calls the callback function,
     * and then returns the result of the callback function. On failure it just returns and empty array.
     * @param callback
     * @returns {Array}
     */
    function allBooked(callback) {
        var xmlSource = "xml/roomBookings.xml";
        //var xmlSource = "";
        //var bookedList = [];
        var rooms = [];
        $.ajax({
            type: "GET",
            url: xmlSource,
            async: false,
            cache: false,
            success: function (data) {
                rooms = callback(data);
            },
            error: function () {
                return rooms;
            }
        });
        return rooms;
    }

    /**
     * Gets a list of objects of all possible rooms, and a list of objects of all rooms currently booked.
     * It then loops through the objects of both lists and compares their room numbers and dates. If the room
     * isn't booked, the room object is stored in the availableRoomList. The availableRoomList is then returned.
     *
     * @returns {Array} availableRoomList containing a list of all rooms(room number and prices),
     * that are available between the two dates entered.
     */
    function availableRooms() {
        var availableRoomList = [];

        var callbackAll = returnAllRooms;
        var callBackBooked = returnAllBooked;

        var roomList = allRooms(callbackAll);
        var bookedList = allBooked(callBackBooked);

        var dateToCheckIn = $("#indate").val();
        var dateToCheckOut = $("#outdate").val();
        dateToCheckIn = dateToCheckIn.split("-");
        dateToCheckOut = dateToCheckOut.split("-");

        var dateCheckIn = new Date(dateToCheckIn);
        var dateCheckOut = new Date(dateToCheckOut);

        var i, j;
        var found;

        for (i = 0; i < roomList.length; i += 1) {
            found = false;
            for (j = 0; j < bookedList.length; j += 1) {
                if (bookedList[j].roomNum === roomList[i].roomNum && ((bookedList[j].checkInDate.valueOf() <= dateCheckIn.valueOf() && bookedList[j].checkOutDate.valueOf() >= dateCheckIn.valueOf()) || (bookedList[j].checkInDate.valueOf() <= dateCheckOut.valueOf() && bookedList[j].checkOutDate.valueOf() >= dateCheckOut.valueOf()) || (bookedList[j].checkInDate.valueOf() >= dateCheckIn.valueOf() && bookedList[j].checkOutDate.valueOf() <= dateCheckOut.valueOf()) || (bookedList[j].checkInDate.valueOf() === dateCheckIn.valueOf() && bookedList[j].checkOutDate.valueOf() === dateCheckOut.valueOf()))) {
                    found = true;
                    break;
                }
            }
            if (found === false) {
                availableRoomList.push(roomList[i]);
            }
        }
        //console.log(availableRoomList);
        return availableRoomList;
    }

    /**
     * Gets a list of objects of all available rooms between the two dates entered.
     * It then loops through each object, generating HTML that is then appended to the page.
     * If there are no available rooms(or if there are no rooms due to either no XML data or a failed request),
     * the page is updated accordingly.
     */
    function showAvailableRooms() {
        var availableRoomList = availableRooms();

        //clear the table from any previous searches
        $("#all-table").empty();

        var tableContent = "";
        var i;

        if (availableRoomList.length !== 0) {
            tableContent += "<table id='rooms-available'><caption>Rooms</caption><thead><tr><th scope='col'>No.</th><th scope='col'>Price($)</th><th scope='col'>Available</th></tr></thead><tbody>";
            for (i = 0; i < availableRoomList.length; i += 1) {
                tableContent += "<tr><td id='room-num-dom'>" + availableRoomList[i].roomNum + "</td><td>" + availableRoomList[i].roomPrice + "</td><td><input type='button' value='Book' class='book-button' id='button-dom'></td></tr>";
            }
        } else {
            tableContent += "<p>There are no rooms currently available!</p>";
        }

        $("#all-table").append(tableContent);
    }

    /**
     * Setup function for BookRoom.
     * Also sets up the on-click functions for both the book and close modal buttons.
     */
    pub.setup = function () {
        showAvailableRooms();

        $(".book-button").click(function () {
            $("#success-modal").show(300);
            $("#modal-form").show();
            $("#success-message").empty().hide();
        });

        $(".close-modal").click(function () {
            $("#success-modal").hide(300);
            $("#name").val("");
            $("#modal-errors").empty().hide();
        });

    };

    // Expose public interface
    return pub;

}());