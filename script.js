document.addEventListener("DOMContentLoaded", function() {
    var welcomeMessage = document.getElementById("welcomeMessage");
    var currentHour = new Date().getHours();
    var message = "";

    if (currentHour < 12) {
        message = "Good Morning!";
    } else if (currentHour < 18) {
        message = "Good Afternoon!";
    } else {
        message = "Good Evening!";
    }

    welcomeMessage.textContent = message;
});
