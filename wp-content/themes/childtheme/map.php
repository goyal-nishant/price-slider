<?php
/*
Template Name: Styled Maps
*/
get_header(); 

$taxonomy = 'location_category'; 
$terms = get_terms(array(
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
));

$args = array(
    'post_type'      => 'location',
    'posts_per_page' => -1,
);

$location_query = new WP_Query($args);
?>

<div class="container">
    
    <div id="filter-container">
        <button class="filter-btn" data-category-id="">All</button>
        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
            <?php foreach ($terms as $term) : ?>
                <button class="filter-btn" data-category-id="<?php echo esc_attr($term->term_id); ?>">
                    <?php echo esc_html($term->name); ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="layout-container">
        <div id="button-container">
            <ul id="location-list">
                <?php if ($location_query->have_posts()) : ?>
                    <?php while ($location_query->have_posts()) : $location_query->the_post(); ?>
                        <?php
                        $lat = get_post_meta(get_the_ID(), '_lat', true);
                        $lng = get_post_meta(get_the_ID(), '_lng', true);
                        $icon_url = get_stylesheet_directory_uri() . '/icons/default-dot.png'; 
                        $terms = get_the_terms(get_the_ID(), 'location_category');
                        $term_ids = $terms ? wp_list_pluck($terms, 'term_id') : array();
                        ?>
                        <li data-term-ids="<?php echo esc_attr(implode(',', $term_ids)); ?>">
                            <button 
                                data-lat="<?php echo esc_attr($lat); ?>" 
                                data-lng="<?php echo esc_attr($lng); ?>" 
                                data-icon="<?php echo esc_url($icon_url); ?>">
                                <?php the_title(); ?>
                            </button>
                        </li>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <li>No locations found.</li>
                <?php endif; ?>
            </ul>
        </div>

        <div id="map-container">
            <div id="map"></div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8ga5NZSYzrU2SnCqDssEB-kizBQzVipg&callback=initMap&v=weekly" defer></script>
<!-- <script>
    let map;
    let markers = [];

    function initMap() {
        const defaultCenter = { lat: 40.674, lng: -73.945 };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 5,
            styles: [
                { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                { featureType: "administrative.locality", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                { featureType: "poi.park", elementType: "geometry", stylers: [{ color: "#263c3f" }] },
                { featureType: "poi.park", elementType: "labels.text.fill", stylers: [{ color: "#6b9a76" }] },
                { featureType: "road", elementType: "geometry", stylers: [{ color: "#38414e" }] },
                { featureType: "road", elementType: "geometry.stroke", stylers: [{ color: "#212a37" }] },
                { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#9ca5b3" }] },
                { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#746855" }] },
                { featureType: "road.highway", elementType: "geometry.stroke", stylers: [{ color: "#1f2835" }] },
                { featureType: "road.highway", elementType: "labels.text.fill", stylers: [{ color: "#f3d19c" }] },
                { featureType: "transit", elementType: "geometry", stylers: [{ color: "#2f3948" }] },
                { featureType: "transit.station", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                { featureType: "water", elementType: "geometry", stylers: [{ color: "#17263c" }] },
                { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#515c6d" }] },
                { featureType: "water", elementType: "labels.text.stroke", stylers: [{ color: "#17263c" }] }
            ]
        });

        markers.forEach(marker => marker.setMap(null));
        markers = [];

        const buttons = document.querySelectorAll('#location-list button');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const lat = parseFloat(this.getAttribute('data-lat'));
                const lng = parseFloat(this.getAttribute('data-lng'));
                const icon = this.getAttribute('data-icon');
                const newCenter = { lat, lng };

                map.setCenter(newCenter);

                const marker = new google.maps.Marker({
                    position: newCenter,
                    map: map,
                    icon: {
                        url: icon,
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });

                markers.push(marker);
            });
        });
    }

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            filterLocations(categoryId);
        });
    });

    window.initMap = initMap;
</script> -->

<?php get_footer(); ?>
