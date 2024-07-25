jQuery(document).ready(function($) {
    $('ul.products-block-post-template').addClass('custom-products-list');
    $('.woocommerce-result-count').addClass('custom-products-result');


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
            filterProducts(ui.values[0], ui.values[1]); 
        }
    });
    

    function filterProducts(min_price, max_price) {
        var category = $('#category_filter').val(); 
        
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
            error: function(error) {
                console.log(error);
            }
        });
    }
    
    function updateResultsCount() {
        var totalCount = $('.custom-products-list .product').length;

        $('.custom-products-result').text('Showing all ' + totalCount + ' results');
    }
});

    
