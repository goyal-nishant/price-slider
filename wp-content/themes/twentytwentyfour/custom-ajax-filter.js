jQuery(function($) {
    function filterProducts(category, min_price, max_price) {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_products',
                category: category,
                min_price: min_price,
                max_price: max_price
            },
            success: function(response) {
                $('.custom-products-list').html(response); 
                updateResultsCount(); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $('#category_filter').change(function() {
        var category = $(this).val(); 
        var min_price = $('#price-range-slider').slider('values', 0); 
        var max_price = $('#price-range-slider').slider('values', 1); 
        filterProducts(category, min_price, max_price); 
    });

    $('#price-range-slider').slider({
        range: true,
        min: 0,
        max: 50000,
        values: [0, 50000],
        slide: function(event, ui) {
            $('#min_price_value').val('$' + ui.values[0]); 
            $('#max_price_value').val('$' + ui.values[1]); 
        },
        change: function(event, ui) {
            var category = $('#category_filter').val(); 
            filterProducts(category, ui.values[0], ui.values[1]); 
        }
    });

    function updateResultsCount() {
        var totalCount = $('.custom-products-list .product').length;
        $('.custom-products-result').text('Showing all ' + totalCount + ' results');
    }
});
