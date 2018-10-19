var ShowRooms = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * Takes the data from the ajax get request, generates HTML tables rows
     * using the data, and appends it into the target.
     *
     * @param data the XML data passed from the ajax get request.
     * @param target where the generated HTML should be appended to.
     */
    function parseRooms(data, target) {
        $(data).find("hotelRoom").each(function () {
            var num = $(this).find("number")[0].textContent;
            var type = $(this).find("roomType")[0].textContent;
            var desc = $(this).find("description")[0].textContent;
            var price = $(this).find("pricePerNight")[0].textContent;
            target.append("<tr><td>" + num + "</td><td>" + type + "</td><td>" + desc + "</td><td>" + "$" + price + "</td>");
            target.append("</tr>");
        });
    }

    /**
     * Takes the data from the ajax get request for the room types,
     * loops through the data extracting the relevant information and then
     * generates HTML ot be appended to the target.
     *
     * @param data the XML data passed from the ajax get request.
     * @param target where the generated HTML should be appended on.
     */
    function parseRoomTypes(data, target) {
        $(data).find("roomType").each(function () {
            var id = $(this).find("id")[0].textContent;
            var desc = $(this).find("description")[0].textContent;
            var maxGuests = $(this).find("maxGuests")[0].textContent;
            target.append("<tr><td>" + id + "</td><td>" + desc + "</td><td>" + maxGuests + "</td>");
            target.append("</tr>");
        });
    }

    /**
     * Generates an ajax get request for room data stored in an XML file.
     * On success, it calls parseRooms, which generates the data in tabular form
     * to display to the user.
     * If there is no room data, or the get request fails, the HTML is updated accordingly.
     */
    function showRooms() {
        var target = $("#rooms-all tbody");
        var xmlSource = "hidden/xml/hotelRooms.xml";
        $.ajax({
            type: "GET",
            url: xmlSource,
            cache: false,
            success: function (data) {
                if ($(data).find("hotelRoom").length === 0) {
                    $(target).empty();
                    $(target).append("<p>We have no rooms!<p>");
                } else {
                    parseRooms(data, target);
                }
            },
            error: function () {
                $(target).empty();
                $(target).append("<p>No rooms found!<p>");
            }
        });
    }

    /**
     * Generates an ajax get request for room type data stored in an XML file.
     * On success, it calls parseRoomTypes, which generates the data in tabular form
     * to display to the user.
     * If there is no roomType data, or the get request fails, the HTML is updated accordingly.
     */
    function showTypes() {
        var target = $("#room-type-all tbody");
        var xmlSource = "hidden/xml/roomTypes.xml";
        $.ajax({
            type: "GET",
            url: xmlSource,
            cache: false,
            success: function (data) {
                if ($(data).find("roomType").length === 0) {
                    $(target).empty();
                    $(target).append("<p>We have no rooms!<p>");
                } else {
                    parseRoomTypes(data, target);
                }
            },
            error: function () {
                $(target).empty();
                $(target).append("<p>No rooms found!<p>");
            }
        });
    }

    /**
     * Setup function for ShowRooms
     * Calls showRooms and showTypes function.
     */
    pub.setup = function () {
        showTypes();
        showRooms();
    };

    // Expose public interface
    return pub;

}());

$(document).ready(ShowRooms.setup);