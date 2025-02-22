$(document).ready(function () {
    $("#logoutBtn").click(function () {
        window.location.href = '/views/logout.php';
    });

    $("#queryForm").submit(function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        // Show loading spinner
        $("#loading").removeClass("hidden");
        $("#dataContainer").html("");

        $.ajax({
            type: "POST",
            url: "/views/fetch_data.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                $("#loading").addClass("hidden");
                if (response.status === "ERR") {
                    $("#errorMessage").text(response.details);
                    $("#errorAlert").fadeIn();
                } else {
                    $("#errorAlert").fadeOut();
                    $("#dataContainer").html(response.html);
                }
            },
            error: function () {
                $("#loading").addClass("hidden");
                $("#errorMessage").text("Error fetching data");
                $("#errorAlert").fadeIn();
            }
        });
    });
});

function fetchPage(offset) {
    let formData = $("#queryForm").serialize() + "&offset=" + offset;

    // Show loading spinner
    $("#loading").removeClass("hidden");
    $("#dataContainer").html("");

    $.ajax({
        type: "POST",
        url: "/views/fetch_data.php",
        data: formData,
        dataType: "json",
        success: function (response) {
            $("#loading").addClass("hidden");
            if (response.status === "ERR") {
                $("#errorMessage").text(response.details);
                $("#errorAlert").fadeIn();
            } else {
                $("#errorAlert").fadeOut();
                $("#dataContainer").html(response.html);
            }
        },
        error: function () {
            $("#loading").addClass("hidden");
            $("#errorMessage").text("Error fetching data");
            $("#errorAlert").fadeIn();
        }
    });
}
