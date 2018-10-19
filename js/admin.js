var Admin = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * Recieves the XML data, loops through each booking, extracting the relevant information,
     * and generates table rows to be appended onto the view all bookings table.
     * @param data the XML data returned from the ajax get request.
     * @param target where the generated HTML should be appended to.
     */
    function parseRooms(data, target) {
        $(data).find("booking").each(function () {
            var checkIn = $(this).find("checkin");
            var checkOut = $(this).find("checkout");

            var number = $(this).find("number")[0].textContent;
            var name = $(this).find("name")[0].textContent;

            var checkInDay = $(checkIn).find("day")[0].textContent;
            var checkInMonth = $(checkIn).find("month")[0].textContent;
            var checkInYear = $(checkIn).find("year")[0].textContent;

            var checkOutDay = $(checkOut).find("day")[0].textContent;
            var checkOutMonth = $(checkOut).find("month")[0].textContent;
            var checkOutYear = $(checkOut).find("year")[0].textContent;
            target.append("<tr><td id='booking-num'>" + number + "</td><td id='booking-name'>" + name + "</td><td id='booking-checkin'>" + checkInDay + "/" + checkInMonth + "/" + checkInYear + "</td><td id='booking-checkout'>" + checkOutDay + "/" + checkOutMonth + "/" + checkOutYear + "</td><td><input type='button' class='admin-button' id='delete-button' value='Cancel'></td>");
            //target.append("<td><input type='submit' value='Cancel'></td>");
            target.append("</tr>");
        });
    }

    /**
     * Creates an ajax get request for the current bookings data,
     * On success, if there is no data to retrieve, the html is updated accordingly,
     * otherwise it calls parseRooms.
     * On failure, the html is updated accordingly.
     */
    function showBooked() {
        var table = $("#bookings");
        var target = $("#bookings tbody");
        var hidden = $("#h-no-bookings");
        var xmlSource = "hidden/xml/roomBookings.xml";
        $.ajax({
            type: "GET",
            url: xmlSource,
            cache: false,
            success: function (data) {
                if ($(data).find("booking").length === 0) {
                    $(table).hide();
                    $(hidden).append("<p>No bookings made!<p>");
                } else {
                    parseRooms(data, target);
                }
            },
            error: function () {
                $(table).hide();
                $(hidden).append("<p>No bookings found!<p>");
            }
        });
    }

    /**
     *
     * Takes the values from the table, which are accessed via thisObj in the DOM.
     * It then posts the values via AJAX to removeBooking.php, where the booking,
     * is removed from the roomBookings.xml file.
     *
     * @param thisObj a reference to this.
     */
    function showTypes(thisObj) {

        var name = thisObj.parent().siblings("#booking-name").text();
        var num = thisObj.parent().siblings("#booking-num").text();
        var indate = thisObj.parent().siblings("#booking-checkin").text();
        var outdate = thisObj.parent().siblings("#booking-checkout").text();

        var dataString = 'name1=' + name + '&num1=' + num + '&indate1=' + indate + '&outdate1=' + outdate;

        var xmlSource = "hidden/removeBooking.php";
        $.ajax({
            type: "POST",
            url: xmlSource,
            cache: false,
            data: dataString,
            async: false,
            success: function () {
                $("#success-modal").show(300);
                $("#success-message").append("<p>Success! Booking has been deleted! You will now be redirected to the admin page in 5 seconds!</p>").show();
                setTimeout(function () {
                    location.reload(true);
                }, 5000);
            },
            error: function () {
                $("#success-modal").show(300);
                $("#success-message").append("<p>Something went wrong! You will now be redirected to the admin page in 5 seconds!</p>").show();
                setTimeout(function () {
                    location.reload(true);
                }, 5000);
            }
        });
    }

    /**
     * Setup function for Admin.
     * Calls showBooked function.
     * Sets the onclick function for the remove booking button.
     */
    pub.setup = function () {
        showBooked();
        $(document).on("click", ".admin-button", function () {
            showTypes($(this));
        });
        //
        // $(".close-modal").click(function () {
        //     $("#success-modal").hide(300);
        // });
    };

    // Expose public interface
    return pub;

}());

$(document).ready(Admin.setup);