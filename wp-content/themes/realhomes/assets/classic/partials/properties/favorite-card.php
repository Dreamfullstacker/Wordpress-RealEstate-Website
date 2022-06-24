<article class="property-item clearfix">
	<figure>
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail( get_the_ID() ) ) {
				the_post_thumbnail( 'property-thumb-image' );
			} else {
				inspiry_image_placeholder( 'property-thumb-image' );
			}
			?>
		</a>
		<?php inspiry_display_property_label( get_the_ID() ); ?>
		<figcaption>
			<?php
			$status_terms = get_the_terms( get_the_ID(), 'property-status' );
			if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {
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
		<?php
		$user_status = 'user_not_logged_in';
		if ( is_user_logged_in() ) {
			$user_status = 'user_logged_in';
		}
		?>
		<a class="remove-from-favorite <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php the_ID(); ?>" title="<?php esc_attr_e( 'Remove from favorites', 'framework' ); ?>"><i class="fas fa-trash-alt"></i></a>
		<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>
	</figure>

	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

	<p><?php framework_excerpt( 10 ); ?>
		<a class="more-details" href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?>
			<i class="fas fa-caret-right"></i>
		</a>
	</p>
	<?php
	if ( function_exists( 'ere_get_property_price' ) ) : ?>
		<span><?php ere_property_price(); ?></span>
	<?php
	endif;
	?>
	<div class="ajax-response"></div>
</article>