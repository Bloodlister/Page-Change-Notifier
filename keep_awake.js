var http = require("http");
setInterval(function () {
    http.get("https://notifier-for-new-cars.herokuapp.com");
}, 1000 * 60 * 15); // every 5 minutes (300000)