<?php
global $post;

$property_children_args = array(
	'post_type'      => 'property',
	'posts_per_page' => 100,
	'post_parent'    => get_the_ID(),
);

$child_properties_query = new WP_Query( apply_filters( 'realhomes_children_properties', $property_children_args ) );

if ( $child_properties_query->have_posts() ) : ?>
    <div class="children-content-wrapper single-property-section">
        <div class="container">
            <div class="rh_property__child_properties">
				<?php
				$child_properties_title = get_option( 'theme_child_properties_title' );
				if ( ! empty( $child_properties_title ) ) : ?>
					<h4 class="rh_property__heading"><?php echo esc_html( $child_properties_title ); ?></h4>
				<?php endif; ?>
	            <?php
	            if ( 'table' === get_option( 'inspiry_child_properties_layout', 'default' ) ) : ?>
		            <div class="sub-properties-table-container">
			            <table class="table sub-properties-list-table">
				            <thead>
				            <tr>
					            <th class="sub-property-title"><?php esc_html_e( 'Title', 'framework' ); ?></th>
					            <th class="sub-property-price"><?php esc_html_e( 'Price', 'framework' ); ?></th>
					            <th class="sub-property-beds"><?php esc_html_e( 'Beds', 'framework' ); ?></th>
					            <th class="sub-property-baths"><?php esc_html_e( 'Baths', 'framework' ); ?></th>
					            <th class="sub-property-size"><?php esc_html_e( 'Property Size', 'framework' ); ?></th>
					            <th class="sub-property-type"><?php esc_html_e( 'Property Type', 'framework' ); ?></th>
					            <th class="sub-property-availability"><?php esc_html_e( 'Availability Date', 'framework' ); ?></th>
				            </tr>
				            </thead>
				            <tbody>
				            <?php
                            while ( $child_properties_query->have_posts() ) :
                                $child_properties_query->the_post();

					            $property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
					            $size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
					            $property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
					            $property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
					            ?>
					            <tr>
						            <td><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a></td>
						            <td><?php
							            if ( function_exists( 'ere_property_price' ) ) {
								            ere_property_price();
							            }
							            ?>
						            </td>
						            <td><?php echo esc_html( $property_bedrooms ); ?></td>
						            <td><?php echo esc_html( $property_bathrooms ); ?></td>
						            <td><?php echo esc_html( $property_size );
							            if ( ! empty( $size_postfix ) ) {
								            echo '<sup>' . esc_html( $size_postfix ) . '</sup>';
							            }
							            ?>
						            </td>
						            <td><?php echo inspiry_get_property_types_string( get_the_ID() ); ?></td>
						            <td><?php esc_html_e( 'Call for availabilty', 'framework' ); ?></td>
					            </tr>
				            <?php endwhile; ?>
				            </tbody>
			            </table>
		            </div>
	            <?php else : ?>
		            <div id="rh_property__child_slider" class="rh_property__child_slider clearfix">
			            <div class="flexslider">
				            <ul class="slides">
					            <?php while ( $child_properties_query->have_posts() ) : ?>
						            <?php $child_properties_query->the_post(); ?>
						            <?php get_template_part( 'assets/modern/partials/property/single-fullwidth/child' ); ?>
					            <?php endwhile; ?>
				            </ul><!-- /.slides -->
			            </div><!-- /.flexslider loading -->
		            </div><!-- /.rh_section__properties -->
	            <?php endif; ?>
				<?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>