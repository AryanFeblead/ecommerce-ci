$(document).ready(function() {
    $("#success,#danger").hide();
    $(document).on('click', '.add_cart', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var isValid = true;
        if (isValid) {
            $.ajax({
                type: "POST",
                url: baseUrl + "/addCart/" + id,
                data: {},
                success: function(data) {
                    if (data.status == "success") {
                        $("#success")
                            .show()
                            .delay(2000)
                            .fadeOut()
                            .html("Item Added Successfully");
                    }
                    if (data.status == "error") {
                        $("#danger").show().delay(2000).fadeOut().html("Product Not added");
                    }
                },
                error: function() {
                    console.error("error");
                },
            });
        }
    });
    $(".dell").click(function() {
        var itemId = $(this).data("item-id");
        console.log(itemId);
        if (confirm("Are you sure?")) {
            $.ajax({
                url: baseUrl + "deleteCart/" + itemId,
                type: "POST",
                data: {},
                success: function(data) {
                    if (data.status == "success") {
                        $(this).closest(".item-row").remove();
                        window.location.reload();
                    } else {
                        alert("Failed to remove item.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                },
            });
        }
    });

    function updateTotalPrice($quantityInput) {
        var $row = $quantityInput.closest("tr"); // Get the closest row
        var price = parseFloat($row.find(".prod-price").text().replace("$", "")); // Get the price from the row
        var quantity = parseInt($quantityInput.val()); // Get the new quantity
        var totalPrice = price * quantity; // Calculate the total price

        $row.find(".prod-total").text(totalPrice); // Update the total price in the row

        var itemId = $row.find(".dell").data("item-id"); // Get item ID
        $.ajax({
            url: baseUrl + "updateCart",
            type: "POST",
            data: {
                id: itemId,
                quantity: quantity,
                actionName: "update_cart_quantity",
            },
            success: function(data) {
                var cart_total = 0;
                $.each(data, function(index, user) {
                    cart_total += parseFloat(user.prod_total);
                })
                $('.cart_total').text(cart_total);
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
            },
        });
    }

    $(document).on("input", ".item-quantity", function() {
        if ($(this).val() < 1) {
            $(this).val(1);
        }
        updateTotalPrice($(this)); // Update the total price when the quantity changes
    });

    $(document).on("click", ".btn-plus", function() {
        var $quantityInput = $(this).closest(".input-group").find(".item-quantity");
        $quantityInput.val(parseInt($quantityInput.val()));
        updateTotalPrice($quantityInput); // Update the total price
    });

    $(document).on("click", ".btn-minus", function() {
        var $quantityInput = $(this).closest(".input-group").find(".item-quantity");
        if (parseInt($quantityInput.val()) > 1) {
            $quantityInput.val(parseInt($quantityInput.val())); // Decrement quantity
            updateTotalPrice($quantityInput); // Update the total price
        }
    });
});