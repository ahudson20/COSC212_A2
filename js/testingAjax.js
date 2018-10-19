var TestingAjax = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * Takes the values put in from the user for a new booking,
     * and posts them via AJAx to tester.php, which then writes the booking,
     * data to the roomBookings.xml file.
     */
    function showTypes() {
        var name = $("#name").val();
        var num = $("#num").val();
        var i = $("#indate").val().split("-");
        var o = $("#outdate").val().split("-");


        var indate = i[2] + "/" + i[1] + "/" + i[0];
        var outdate = o[2] + "/" + o[1] + "/" + o[0];

        var dataString = "name1=" + name + "&num1=" + num + "&indate1=" + indate + "&outdate1=" + outdate;

        var xmlSource = "hidden/tester.php";
        $.ajax({
            type: "POST",
            url: xmlSource,
            cache: false,
            data: dataString,
            async: false,
            success: function () {
                $("#success-message").append("<p>Success! Your Booking has been confirmed! You will now be redirected to the home page in 5 seconds!</p>").show();
                setTimeout(location.reload.bind(location), 5000);
            },
            error: function () {
                $("#success-message").append("<p>Something went wrong! You will now be redirected to the home page in 5 seconds!</p>").show();

                setTimeout(location.reload.bind(location), 5000);
            }
        });
    }

    /**
     * Setup function for TestingAjax
     * Calls showTypes function.
     */
    pub.setup = function () {
        showTypes();
    };

    // Expose public interface
    return pub;

}());