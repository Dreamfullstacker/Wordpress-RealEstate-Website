<?php
/**
 * Properties children.
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;

$property_children_args = array(
	'post_type'      => 'property',
	'posts_per_page' => 100,
	'post_parent'    => get_the_ID(),
);

$child_properties_query = new WP_Query( apply_filters( 'realhomes_children_properties', $property_children_args ) );

if ( $child_properties_query->have_posts() ) : ?>
    <div class="child-properties clearfix">
		<?php
		$child_properties_title = get_option( 'theme_child_properties_title' );
		if ( ! empty( $child_properties_title ) ) : ?>
            <h3><?php echo esc_html( $child_properties_title ); ?></h3>
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
		    <?php while ( $child_properties_query->have_posts() ) : $child_properties_query->the_post(); ?>
                <article class="property-item clearfix">
                    <figure>
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						    <?php
						    if ( has_post_thumbnail( get_the_ID() ) ) {
							    the_post_thumbnail( 'property-thumb-image' );
						    } else {
							    inspiry_image_placeholder( 'property-thumb-image' );
						    }
						    ?>
                        </a>
                        <figcaption>
						    <?php
						    $status_terms = get_the_terms( get_the_ID(), "property-status" );
						    if ( ! empty( $status_terms ) ) {
							    $status_count = 0;
							    foreach ( $status_terms as $term ) {
								    if ( $status_count > 0 ) {
									    echo ', ';
								    }
								    echo esc_html( $term->name );
								    $status_count ++;
							    }
						    }
						    ?>
                        </figcaption>
                    </figure>
                    <div class="summary">
                        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                        <h5 class="price">
						    <?php
						    // price
						    if ( function_exists( 'ere_property_price' ) ) {
							    ere_property_price();
						    }

						    // property types
						    echo inspiry_get_property_types( get_the_ID() );
						    ?>
                        </h5>
                        <p><?php framework_excerpt( 20 ); ?></p>
                        <a class="more-details" href="<?php the_permalink() ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?><i class="fas fa-caret-right"></i></a>
                    </div>
                    <div class="property-meta">
					    <?php get_template_part( 'assets/classic/partials/property/single/metas' ); ?>
                    </div>
                </article>
		    <?php endwhile; ?>
	    <?php endif; ?>
		<?php wp_reset_postdata(); ?>
    </div>
<?php endif; ?>