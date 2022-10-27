function getcartData() {
    var cart = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "cartData.php",
        data: { cart: cart },
        success: function(data) {
            //console.log(data);
            $('#displayCart').html(data);
        }
    });
}