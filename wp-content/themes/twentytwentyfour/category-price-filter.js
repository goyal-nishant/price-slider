jQuery(document).ready(function($) {
    $('.products-block-post-template').addClass('custom-list');

    // Append CSS styles
    var styles = `
        <style>
            #filters {
                margin: 10px 0;
                padding: 10px;
                background: #f9f9f9;
                border: 1px solid #ddd;
            }
            #filters select,
            #filters #price-slider {
                margin: 10px 0;
            }
            #price-range {
                font-weight: bold;
            }
        </style>
    `;
    $('head').append(styles);

    // Initialize the price slider
    $("#price-slider").slider({
        range: true,
        min: 0,
        max: 50000,
        values: [0, 50000],
        slide: function(event, ui) {
            $("#price-range").text("$" + ui.values[0] + " - $" + ui.values[1]);
            $("#min-price").val(ui.values[0]);
            $("#max-price").val(ui.values[1]);
            filter_products();
        }
    });

    $("#price-range").text("$" + $("#price-slider").slider("values", 0) + " - $" + $("#price-slider").slider("values", 1));

    // Filter products on category change
    $('#category-filter').change(function() {
        filter_products();
    });

    function filter_products() {
        var category = $('#category-filter').val();
        var min_price = $('#min-price').val();
        var max_price = $('#max-price').val();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_products',
                category: category,
                min_price: min_price,
                max_price: max_price
            },
            success: function(response) {
                var result = JSON.parse(response);
                $('.custom-list').html(result.products);
                $('.woocommerce-result-count').html(result.count);
            }
        });
    }
});