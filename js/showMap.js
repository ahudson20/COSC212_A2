var ShowHide = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * If the map is not on display, then it shows the map, and hides the
     * avaiable and other divs.
     * Otherwise it hides the map and available divs, and shows the other div
     */
    function showHide() {
        if ($("#map").css("display") === "none") {
            $("#available").hide();
            $("#map").show(500);
            $("#other").hide(500);
        } else {
            $("#available").hide();
            $("#map").hide(500);
            $("#other").show(500);
        }
    }

    /**
     * Setup up function for ShowHide
     * Sets the on-click function of the showHide link in the navigation.
     */
    pub.setup = function() {
        $("#showHide").click(showHide);
    };

    // Expose public interface
    return pub;

}());

$(document).ready(ShowHide.setup);