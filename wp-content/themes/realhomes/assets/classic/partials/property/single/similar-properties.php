<?php
/**
 * Similar Properties
 *
 * @package    realhomes
 * @subpackage classic
 */
if ( 'true' === get_option( 'theme_display_similar_properties', 'true' ) ) {
	global $post;

	$property_id                  = get_the_ID();
	$number_of_similar_properties = get_option( 'theme_number_of_similar_properties', '3' );
	$similar_properties_args      = array(
		'post_type'           => 'property',
		'posts_per_page'      => intval( $number_of_similar_properties ),
		'post__not_in'        => array( $property_id ),
		'post_parent__not_in' => array( $property_id ),    // to avoid child posts from appearing in similar properties.
	);

	$inspiry_similar_properties = get_option( 'inspiry_similar_properties', array( 'property-type', 'property-city' ) );

	if ( ! empty( $inspiry_similar_properties ) && is_array( $inspiry_similar_properties ) ) {

		$similar_properties_taxonomies = array_diff( $inspiry_similar_properties, array( 'property-agent' ) );
		$similar_properties_count      = count( $similar_properties_taxonomies );
		$tax_query                     = array();

		for ( $index = 0; $index < $similar_properties_count; $index ++ ) {
			/* Property Taxonomies array */
			$property_terms = get_the_terms( $property_id, $similar_properties_taxonomies[ $index ] );
			if ( ! empty( $property_terms ) && is_array( $property_terms ) ) {
				$terms_array = array();
				foreach ( $property_terms as $property_term ) {
					$terms_array[] = $property_term->term_id;
				}
				$tax_query[] = array(
					'taxonomy' => $similar_properties_taxonomies[ $index ],
					'field'    => 'id',
					'terms'    => $terms_array,
				);
			}
		}

		$tax_count = count( $tax_query );   // Count number of taxonomies.
		if ( $tax_count > 1 ) {
			$tax_query['relation'] = 'OR';  // Add OR relation if more than one.
		}
		if ( $tax_count > 0 ) {
			$similar_properties_args['tax_query'] = $tax_query;   // Add taxonomies query.
		}

		if ( in_array( 'property-agent', $inspiry_similar_properties ) ) {
			$property_agents = get_post_meta( $property_id, 'REAL_HOMES_agents' );
			if ( ! empty( $property_agents ) ) {
				$similar_properties_args['meta_query'] = array(
					array(
						'key'     => 'REAL_HOMES_agents',
						'value'   => $property_agents,
						'compare' => 'IN',
					),
				);
			}
		}
	}

	/* Sort Properties Based on Theme Option Selection */
	$similar_properties_sorty_by = get_option( 'inspiry_similar_properties_sorty_by' );
	if ( ! empty( $similar_properties_sorty_by ) ) {
		if ( 'low-to-high' == $similar_properties_sorty_by ) {
			$similar_properties_args['orderby']  = 'meta_value_num';
			$similar_properties_args['meta_key'] = 'REAL_HOMES_property_price';
			$similar_properties_args['order']    = 'ASC';
		} elseif ( 'high-to-low' == $similar_properties_sorty_by ) {
			$similar_properties_args['orderby']  = 'meta_value_num';
			$similar_properties_args['meta_key'] = 'REAL_HOMES_property_price';
			$similar_properties_args['order']    = 'DESC';
		} elseif ( 'random' == $similar_properties_sorty_by ) {
			$similar_properties_args['orderby'] = 'rand';
		}
	}

	$similar_properties_args  = apply_filters( 'inspiry_similar_properties_filter', $similar_properties_args );
	$similar_properties_query = new WP_Query( $similar_properties_args );

	if ( $similar_properties_query->have_posts() ) :
		?>
        <section class="listing-layout property-grid">
            <div class="list-container clearfix">
	            <?php
	            $similar_properties_title = get_option( 'theme_similar_properties_title' );
	            if ( ! empty( $similar_properties_title ) ) :
		            ?><h3><?php echo esc_html( $similar_properties_title ); ?></h3><?php
	            endif;

	            // Similar properties filters markup.
	            realhomes_similar_properties_filters( 'classic' );
	            ?>
                <div id="similar-properties">
	                <?php
	                while ( $similar_properties_query->have_posts() ) :
		                $similar_properties_query->the_post();
		                // Display Property for Grid
		                get_template_part( 'assets/classic/partials/property/single/similar-property-card' );
	                endwhile;
	                wp_reset_postdata();
	                ?>
                </div>
            </div>
        </section>
	<?php
	endif;
}
