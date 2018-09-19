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
            target.append("<tr> <td>" + number + "</td><td>" + name + "</td><td>" + checkInDay + "/" + checkInMonth + "/" + checkInYear + "</td><td>" + checkOutDay + "/" + checkOutMonth + "/" + checkOutYear + "</td>");
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
        var target = $("#bookings tbody");
        var xmlSource = "xml/roomBookings.xml";
        $.ajax({
            type: "GET",
            url: xmlSource,
            cache: false,
            success: function (data) {
                if ($(data).find("booking").length === 0) {
                    $(target).empty();
                    $(target).append("<p>No bookings made!<p>");
                } else {
                    parseRooms(data, target);
                }
            },
            error: function () {
                $(target).empty();
                $(target).append("<p>No bookings found!<p>");
            }
        });
    }

    /**
     * Setup function for Admin.
     * Calls showBooked function.
     */
    pub.setup = function () {
        showBooked();
    };

    // Expose public interface
    return pub;

}());

$(document).ready(Admin.setup);