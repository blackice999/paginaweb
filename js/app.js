$(document).ready(function () {
    $(".quantity").keyup(function () {
        $("#cart").find("tr").each(function () {
            var row_total = 0;
            var quantity = 0;
            $(".quantity").each(function () {
                quantity = $(this).val();

                var productPrice = $(this).parent(this).siblings("td.price").text();
                row_total += Number(quantity * productPrice);
            });
            $(".total").text(row_total);
        });
    });
});