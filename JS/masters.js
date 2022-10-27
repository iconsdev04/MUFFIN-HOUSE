function getManufacturerData() {
    var action = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "MasterData.php",
        data: { action: action },
        beforeSend: function() {
            $('#displayManufacturer').addClass("d-none");
            $('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            $('#displayManufacturer').removeClass("d-none");
            $('#loadCard').addClass("d-none");
            $('#displayManufacturer').html(data);
        }
    });
}



function getCategoryData() {
    var cats = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "categoryData.php",
        data: { cats: cats },
        beforeSend: function() {
            $('#displayCategory').addClass("d-none");
            $('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            $('#displayCategory').removeClass("d-none");
            $('#loadCard').addClass("d-none");
            $('#displayCategory').html(data);
        }
    });
}


function getUserData() {
    var user = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "userData.php",
        data: { user: user },
        beforeSend: function() {
            $('#displayUser').addClass("d-none");
            $('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            $('#displayUser').removeClass("d-none");
            $('#loadCard').addClass("d-none");
            $('#displayUser').html(data);
        }
    });
}