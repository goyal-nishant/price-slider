jQuery(function($){
    $('#category_filter').change(function(){
        var category = $(this).val();
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            data: {
                action: 'filter_products',
                category: category
            },
            success: function(response){
                $('.custom-products-list').html(response);
                updateResultsCount();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    
    function updateResultsCount() {
        var totalCount = $('.custom-products-list .product').length;

        $('.custom-products-result').text('Showing all ' + totalCount + ' results');
    }
});
