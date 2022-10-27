//total orders
function totalOrders() {
    var action = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { action: action },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalOrders').html(data);
        }
    });
}


//total quantity
function totalQuantity() {
    var totalQty = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { totalQty: totalQty },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalQty').html(data);
        }
    });

}


//total weight
function totalWeight() {
    var totalWgt = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { totalWgt: totalWgt },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalWgt').html(data);
        }
    });

}



//category wise
function categoryWise() {
    var CatWise = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { CatWise: CatWise },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#tableCategoryWise').html(data);
        }
    });

}




//staff wise
function staffWise() {
    var StaffWise = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { StaffWise: StaffWise },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#tableBillerWise').html(data);
        }
    });

}