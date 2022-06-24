<?php
/**
 * Head of the single property template.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;
?>
<div class="rh_page__head rh_page__property">
    <div class="rh_page__property_title">
		<?php
		inspiry_property_qr_code();

		$display_property_breadcrumbs = get_option( 'theme_display_property_breadcrumbs' );
		if ( 'true' == $display_property_breadcrumbs ) {
			get_template_part( 'common/partials/breadcrumbs' );
		}
		?>

        <h1 class="rh_page__title"><?php the_title(); ?></h1><!-- /.rh_page__title -->

		<?php
		$address_display  = get_option( 'inspiry_display_property_address', 'true' );
		$property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

		if ( 'true' === $address_display ) {
			?>
            <p class="rh_page__property_address">
				<?php echo esc_html( $property_address ); ?>
            </p>

			<?php
		}
		?>
    </div><!-- /.rh_page__property_title -->

    <div class="rh_page__property_price">
		<?php
		/* Property Status. For example: For Sale, For Rent */
		$status_terms = get_the_terms( get_the_ID(), 'property-status' );
		if ( ! empty( $status_terms ) ) {
			?>
            <p class="status">
				<?php
				$status_count = 0;
				foreach ( $status_terms as $term ) {
					if ( $status_count > 0 ) {
						echo ', ';
					}
					echo esc_html( $term->name );
					$status_count ++;
				}
				?>
            </p><!-- /.status -->
			<?php
		}
		?>
        <p class="price">
			<?php
			if ( function_exists( 'ere_property_price' ) ) {
				ere_property_price( get_the_ID(), true );
			}
			?>
        </p><!-- /.price -->
    </div><!-- /.rh_page__property_price -->
</div><!-- /.rh_page__head -->