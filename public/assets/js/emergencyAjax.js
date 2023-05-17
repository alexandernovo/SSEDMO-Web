$(document).ready(function () {
    // Update the data initially
    updateData();
    // Update the data every 5 seconds
    setInterval(updateData, 5000);

    function updateData() {
        $.ajax({
            url: "http://localhost/OJT/ajax/emergencyDashboard.php",
            type: "GET",
            success: function (response) {
                $("#emergency").html(response);
                // Start countdown for each element
                $('.countdown').each(function () {
                    var startTime = new Date($(this).attr('time-count')).getTime();
                    setInterval(function () {
                        var now = new Date().getTime();
                        var timePassed = now - startTime;
                        var hours = Math.floor(timePassed / (1000 * 60 * 60));
                        var minutes = Math.floor((timePassed % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((timePassed % (1000 * 60)) / 1000);
                        $(this).text(hours + 'h ' + minutes + 'm ' + seconds + 's ago');
                    }.bind(this), 1000);
                });
            },
            error: function (xhr, status, error) {
                failed('Error getting time availability.');
            }
        });
    }
});
