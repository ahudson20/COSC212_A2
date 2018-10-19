/**
 * Validation functions for the Classic Cinema site.
 *
 * Created by: Steven Mills, 09/04/2014
 * Last Modified by: Steven Mills 08/08/2016
 */

/**
 * Form Validation using the module pattern.
 * Taken from above^^, and adapted to suit as needed.
 */
var Validation = (function () {
    "use strict";

    // Public interface
    var pub = {};

    /**
     * Check to see if a string is empty.
     *
     * Leading and trailing whitespace are ignored.
     * @param textValue The string to check.
     * @return {boolean} True if textValue is not just whitespace, false otherwise.
     */
    function checkNotEmpty(textValue) {
        return textValue.trim().length > 0;
    }

    /**
     * Ensures that the check-in date is not before today,
     * and that the check-out date is not before the check-in date.
     *
     *
     * @param inDate the String value of the check-in date from the input.
     * @param outDate the String value of the check-out date from the input.
     */
    function checkDate(inDate, outDate, messages) {

        inDate = inDate.split("-");
        outDate = outDate.split("-");

        var dateCheckIn = new Date(inDate);
        var dateCheckOut = new Date(outDate);

        var now = new Date();
        now.setDate(now.getDate() - 1);

        if (!(dateCheckIn >= now)) {
            messages.push("Check-in date must be future date");
        }

        if (!(dateCheckOut > dateCheckIn)) {
            messages.push("Check-out date must be after Check-in");
        }
    }

    /**
     *
     * @param name the value that was entered into the name input.
     * @param nameMessages the list of error messages specific to the name input form.
     */
    function checkName(name, nameMessages) {
        if (!(checkNotEmpty(name))) {
            nameMessages.push("Name must be given");
        }
    }

    /**
     *  NOTE: this function is not used, but originally I had the user enter in,
     *  the number of guests as well. Thus, this function ensured a valid number,
     *  was passed into the input.
     *
     * @param num the number entered into the input for guests.
     */
    // function checkGuests(num, messages) {
    //     // if((checkDigits(num) && checkLength(num, 1, 2)) && (checkNotEmpty(num) && parseInt(num) > 0)) {
    //     //     return true;
    //     // }
    //     // return false;
    //
    //      if(!(checkDigits(num))){
    //          messages.push("No. Guests must only contain digits")
    //      }
    //      if(!(checkLength(num, 1, 2))){
    //          messages.push("No. Guests must be less than 99")
    //      }
    //      if(!(checkNotEmpty(num))){
    //          messages.push("No. Guests must not be empty")
    //      }
    //      if(!(parseInt(num) > 0)){
    //          messages.push("No. Guests must be greater than 0")
    //      }
    // }

    /**
     * Checks that the date search form is valid.
     *
     * @return boolean true if the dates are valid,
     * otherwise false, and displays error message(s) to,
     * the user.
     *
     */
    function validateSearch() {
        var messages = [];
        var errorHTML;

        // Validates the dates entered
        var dateToCheckIn = $("#indate").val();
        var dateToCheckOut = $("#outdate").val();
        checkDate(dateToCheckIn, dateToCheckOut, messages);
        if (messages.length === 0) {
            return true;
        } else {
            errorHTML = "<p>Please fix these errors before searching:</p>";
            errorHTML += "<ul>";
            messages.forEach(function (msg) {
                errorHTML += "<li>" + msg;
            });
            errorHTML += "</ul>";
            $("#errors").show();
            $("#errors").html(errorHTML);
            return false;
        }
    }

    /**
     * Checks if the name input box is valid.
     *
     * @return boolean true if the name input box is valid,
     * otherwise returns false, and displays error message to the user.
     */
    function validateName() {
        var nameMessages = [];
        var errorNameHTML;
        var name = $("#name").val();
        checkName(name, nameMessages);

        if (nameMessages.length === 0) {
            return true;
        } else {
            errorNameHTML = "<p>Please fix these errors before confirming:</p>";
            errorNameHTML += "<ul>";
            nameMessages.forEach(function (msg) {
                errorNameHTML += "<li>" + msg;
            });
            errorNameHTML += "</ul>";
            $("#modal-errors").html(errorNameHTML);
            $("#modal-errors").show();
            return false;
        }
    }

    /**
     * Sets the default value of the check-in date to the current date,
     * and the default value of the check-out date to the day after the current date.
     */
    function setDefaultDates() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var day_t = ("0" + tomorrow.getDate()).slice(-2);
        var month_t = ("0" + (tomorrow.getMonth() + 1)).slice(-2);
        var tom = tomorrow.getFullYear() + "-" + (month_t) + "-" + (day_t);

        $("#indate").val(today);
        $("#outdate").val(tom);
    }

    /**
     * Setup function for both form validation.
     *
     * Adds validation to the form on submission.
     */
    pub.setup = function () {
        // Sets the dates into the date-pickers
        setDefaultDates();
        /**
         * Checks dates are valid.
         * If they are valid, calls BookRoom.
         * Then displays/hides info.
         *
         * NOTE: had it displaying div, and then generating data,
         * now is the other way around - generating data into div,
         * and then displaying it.
         */
        $("#button-search").click(function () {
            if (validateSearch.call(this) === true) {
                BookRoom.setup.call(this);
                $("#other").hide();
                $("#errors").empty().hide();
                $("#available").show();
            }
        });
        /**
         * If the validateName function returns true i.e. no errors,
         * then it will call Bookings -> stores booking in Cookie.
         */
        $("#name-button").click(function () {
            if (validateName.call(this) === true) {
                //BookRoom.setup.call(this);
                $("#modal-errors").empty().hide();
                $("#modal-form").hide();
                //$("#success-message").append("<p>Success! Your Booking has been confirmed!</p>").show();
                Bookings.setup.call(this);
                TestingAjax.setup.call(this);
            }
        });
    };

    // Expose public interface
    return pub;

}());

$(document).ready(Validation.setup);