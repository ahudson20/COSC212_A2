/**
 * NOTE: this was taken from the lab work, and is not my own code.
 */
var Cookie = (function () {
    "use strict";
    var pub = {};

    pub.set = function (name, value, hours) {
        var date, expires;
        name = encodeURIComponent(name);
        value = encodeURIComponent(value);
        if (hours) {
            date = new Date();
            date.setHours(date.getHours() + hours);
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    };

    pub.get = function (name) {
        var nameEq, cookies, cookie, i;
        name = encodeURIComponent(name);
        nameEq = name + "=";
        cookies = document.cookie.split(";");
        for (i = 0; i < cookies.length; i += 1) {
            cookie = cookies[i].trim();
            if (cookie.indexOf(nameEq) === 0) {
                return decodeURIComponent(cookie.substring(nameEq.length, cookie.length));
            }
        }
        return null;
    };
    pub.clear = function (name) {
        name = encodeURIComponent(name);
        pub.set(name, "", -1);
    };
    return pub;
}());