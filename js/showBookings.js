var ShowBookings = (function () {
    "use strict";
    var pub = {};

    /**
     * Takes the parsed "mybookings array", loops through it extracting and generating a string to be
     * returned and appended as HTML to the bookings table.
     * @param cartList the parsed array of the "mybookings" cookie.
     * @returns {string} html repersenting the HTML that is to appended to the bookings table.
     */
    function generateHTML(cartList) {
        var i;
        var html = "";
        for (i = 0; i < cartList.length; i += 1) {
            html += "<tr><td>" + cartList[i].bookedNum + "</td><td>" + cartList[i].bookedInDate + "</td><td>" + cartList[i].bookedOutDate + "</td></tr>";
        }
        return html;
    }

    /**
     * Setup function for ShowBookings.
     * Gets the bookings cookie, parses it and calls generateHTML.
     * If the cookie is not present, it displays a message that there are no pending bookings.
     */
    pub.setup = function () {
        var cart = Cookie.get("mybookings");
        var element = $("#bookings tbody");

        if (cart) {
            cart = JSON.parse(cart);
            element.append(generateHTML(cart));
        } else {
            $("#bookings").hide();
            $("#show-bookings").append("<p>You have made no bookings!</p>");
        }
    };
    return pub;
}());


$(document).ready(ShowBookings.setup);