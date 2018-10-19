var Bookings = (function () {
    "use strict";
    var pub = {};

    /**
     * Gets the bookings cookie and parses it, gets the relevant pending bookings information from the user,
     * creates an object using that information, and pushes that information onto the parsed cookie,
     * which is then re-set back on the cookie.
     */
    function bookRoom() {
        var cart, booking;

        cart = Cookie.get("mybookings");

        if (cart) {
            cart = JSON.parse(cart);
        } else {
            cart = [];
        }

        booking = {};
        booking.bookedName = $("#name").val();
        booking.bookedNum = $("#num").val();

        var i = $("#indate").val().split("-");
        var o = $("#outdate").val().split("-");

        booking.bookedInDate = i[2] + "/" + i[1] + "/" + i[0];
        booking.bookedOutDate = o[2] + "/" + o[1] + "/" + o[0];
        cart.push(booking);

        Cookie.set("mybookings", JSON.stringify(cart));
    }

    /**
     * Setup function for storing pending booking(s) onto the cookie.
     * Calls bookRoom function.
     */
    pub.setup = function () {
        bookRoom();
    };

    return pub;

}());