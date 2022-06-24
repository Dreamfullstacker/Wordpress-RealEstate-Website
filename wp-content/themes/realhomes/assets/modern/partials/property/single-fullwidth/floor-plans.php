<?php
global $post;
$property_floor_plans = get_post_meta( get_the_ID(), 'inspiry_floor_plans', true );
if ( ! empty( $property_floor_plans ) && is_array( $property_floor_plans ) && ! empty( $property_floor_plans[0]['inspiry_floor_plan_name'] ) ) : ?>
    <div class="floor-plans-content-wrapper single-property-section">
        <div class="container">
            <?php get_template_part( 'assets/modern/partials/property/single/floor-plans' ); ?>
        </div>
    </div>
	<?php
endif;
