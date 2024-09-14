$(document).ready(function () {
    $('#search-in-shop').on('keypress', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            var isValid = true;
            if ($("#search-in-shop").val() == "") {
                $("#all_prod").show();
                $("#search-result").hide();
                $("#show-error").hide();
                isValid = false;
            }
            if (isValid) {
                var search = $("#search-in-shop").val();
                $("#search-result").hide();
                $.ajax({
                    type: "POST",
                    url: baseUrl + "view_data",
                    data: {
                        search: search,
                    },
                    success: function (data) {
                        if (data.length === 0) {
                            $("#show-error").show();
                            $("#show-error").html(
                                "<h1 class='text-center'>No Product Found</h1>"
                            );
                            $("#all_prod").hide();
                        } else {
                            $("#show-error").hide();
                            $("#all_prod").hide();
                            rows = "";
                            $.each(data, function (index, user) {
                                rows +=
                                    `<div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                                <div class="rounded position-relative fruite-item">
                                                                                    <div class="fruite-img">
                                                                                        <img src="` + baseUrl + `assets/mainDoc/` +
                                    user.prod_img +
                                    `" class="img-fluid w-100 rounded-top" alt="">
                                                                                        </div>
                                                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                                    user.prod_category +
                                    `</div>
                                                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                        <h4>` +
                                    user.prod_name +
                                    `</h4>
                                                                                        <p class="text-dark">` +
                                    user.prod_desc +
                                    `</p>
                                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                        <p class="text-dark fs-5 fw-bold mb-0">` +
                                    user.prod_price +
                                    ` / kg</p>
                                                                                        <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                      </a>  </div>`;
                            });

                            $("#search-result").show();
                            $("#search-result1").html(rows);
                        }
                    },
                    error: function () {
                        console.error("error");
                    },
                });
            }
        }
    });
    $("#search-icon-11").on("click", function (e) {
        e.preventDefault();
        var isValid = true;
        if ($("#search-in-shop").val() == "") {
            $("#all_prod").show();
            $("#search-result").hide();
            $("#show-error").hide();
            isValid = false;
        }
        if (isValid) {
            var search = $("#search-in-shop").val();
            $("#search-result").hide();
            $.ajax({
                type: "POST",
                url: baseUrl + "view_data",
                data: {
                    search: search,
                },
                success: function (data) {
                    if (data.length === 0) {
                        $("#show-error").show();
                        $("#show-error").html(
                            "<h1 class='text-center'>No Product Found</h1>"
                        );
                        $("#all_prod").hide();
                    } else {
                        $("#show-error").hide();
                        $("#all_prod").hide();
                        rows = "";
                        $.each(data, function (index, user) {
                            rows +=
                                `<div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                                <div class="rounded position-relative fruite-item">
                                                                                    <div class="fruite-img">
                                                                                        <img src="` + baseUrl + `assets/mainDoc/` +
                                user.prod_img +
                                `" class="img-fluid w-100 rounded-top" alt="">
                                                                                        </div>
                                                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                                user.prod_category +
                                `</div>
                                                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                        <h4>` +
                                user.prod_name +
                                `</h4>
                                                                                        <p class="text-dark">` +
                                user.prod_desc +
                                `</p>
                                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                        <p class="text-dark fs-5 fw-bold mb-0">` +
                                user.prod_price +
                                ` / kg</p>
                                                                                        <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                      </a>  </div>`;
                        });

                        $("#search-result").show();
                        $("#search-result1").html(rows);
                    }
                },
                error: function () {
                    console.error("error");
                },
            });
        }
    });
    $("#all_product_cat").on("click", function (e) {
        e.preventDefault();
        $("#all_prod").show();
        $("#search-result").hide();
        $("#show-error").hide();
    });
    $("#all_fruit_cat").on("click", function (e) {
        e.preventDefault();
        $("#all_prod").hide();
        var isValid = true;
        if (isValid) {
            $.ajax({
                type: "POST",
                url: baseUrl + "fruit_data",
                data: {},
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                                <div class="rounded position-relative fruite-item">
                                                                                    <div class="fruite-img">
                                                                                        <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                        </div>
                                                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                        <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                        <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                        <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div></a>
                                                                                        </div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }
    });
    $("#all_vegetable_cat").on("click", function (e) {
        e.preventDefault();
        $("#all_prod").hide();
        var isValid = true;
        if (isValid) {
            $.ajax({
                type: "POST",
                url: baseUrl + "vegetable_data",
                data: {},
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                                <div class="rounded position-relative fruite-item">
                                                                                    <div class="fruite-img">
                                                                                        <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                        </div>
                                                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                        <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                        <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                        <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                        </a></div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }
    });
    $("#rangeInput").on("change", function (e) {
        e.preventDefault();
        $("#all_prod").hide();
        var isValid = true;
        if (isValid) {
            var searchprice = $("#rangeInput").val();
            $.ajax({
                type: "POST",
                url: baseUrl + "searchbar_data",
                data: {
                    searchprice: searchprice,
                },
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                                <div class="rounded position-relative fruite-item">
                                                                                    <div class="fruite-img">
                                                                                        <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                        </div>
                                                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                        <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                        <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                        <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                       </a> </div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }
    });
    $("#fruits").on("change", function (e) {
        e.preventDefault();
        $("#all_prod").hide();
        var search = $("#search-in-shop").val();
        var searchprice1 = $("#rangeInput").val();
        var isValid = true;
        var searchprice = $("#fruits").val();
        if (isValid && searchprice == "lowtohigh") {
            $.ajax({
                type: "POST",
                url: baseUrl + "lowtohigh_data",
                data: {
                    search: search,
                    searchprice1: searchprice1
                },
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                              <div class="rounded position-relative fruite-item">
                                                                                  <div class="fruite-img">
                                                                                      <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                      </div>
                                                                                      <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                      <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                      <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                      <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                      <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                      <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                      </div>
                                                                                      </div>
                                                                                      </div>
                                                                                     </a> </div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }

        if (isValid && searchprice == "hightolow") {
            $.ajax({
                type: "POST",
                url: baseUrl + "hightolow_data",
                data: {
                    search: search,
                    searchprice1: searchprice1
                },
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                            <div class="rounded position-relative fruite-item">
                                                                                <div class="fruite-img">
                                                                                    <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                    </div>
                                                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                    <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                    <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                    <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    </a></div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }

        if (isValid && searchprice == "atoz") {
            $.ajax({
                type: "POST",
                url: baseUrl + "atoz_data",
                data: {
                    search: search,
                    searchprice1: searchprice1
                },
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                          <div class="rounded position-relative fruite-item">
                                                                              <div class="fruite-img">
                                                                                  <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                  </div>
                                                                                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                  <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                  <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                  <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                  <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                  <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                  </div>
                                                                                  </div>
                                                                                  </div>
                                                                                </a>  </div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }

        if (isValid && searchprice == "ztoa") {
            $.ajax({
                type: "POST",
                url: baseUrl + "ztoa_data",
                data: {
                    search: search,
                    searchprice1: searchprice1
                },
                success: function (data) {
                    rows = "";
                    $.each(data, function (index, user) {
                        rows +=
                            `                                                   <div class="col-md-6 col-lg-6 col-xl-4"><a href="` + siteUrl + `product/` + user.prod_id + `">
                                                                        <div class="rounded position-relative fruite-item">
                                                                            <div class="fruite-img">
                                                                                <img src="` + baseUrl + `assets/mainDoc/` +
                            user.prod_img +
                            `" class="img-fluid w-100 rounded-top" alt="">
                                                                                </div>
                                                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">` +
                            user.prod_category +
                            `</div>
                                                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                                <h4>` +
                            user.prod_name +
                            `</h4>
                                                                                <p class="text-dark">` +
                            user.prod_desc +
                            `</p>
                                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                                <p class="text-dark fs-5 fw-bold mb-0">` +
                            user.prod_price +
                            ` / kg</p>
                            <a data-id="` + user.prod_id + `" class="btn border border-secondary rounded-pill px-3 text-primary add_cart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                                </div>
                                                                                </div>
                                                                                </div>
                                                                              </a>  </div>`;
                    });

                    $("#search-result").show();
                    $("#search-result1").html(rows);
                },
                error: function () {
                    console.error("error");
                },
            });
        }
    });
});