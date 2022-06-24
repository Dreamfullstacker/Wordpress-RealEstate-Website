<?php
/**
 * Grid Property Card
 *
 * Property grid card to be displayed on grid listing page.
 *
 * @package easy_real_estate
 */

$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );

?>


<article class="rh_latest_properties_2 rh_property_card_stylish">

	<div class="rh_property_card_stylish_inner">

		<div class="rh_thumbnail_wrapper">
			<div class="rh_top_tags_box">
				<?php
				ere_get_template_part( 'includes/widgets/grid-cards/card-parts/media-count' );
				ere_get_template_part( 'includes/widgets/grid-cards/card-parts/tags' );
				?>
			</div>
			<div class="rh_bottom_tags_box">
				<?php
				if ( ! empty( inspiry_get_property_types_string( get_the_ID() ) ) ) {
					?>
					<span class="rh_stylish_property_types">
				<?php
				echo inspiry_get_property_types_string( get_the_ID() );
				?>
				</span>
					<?php
				}
				ere_get_template_part( 'includes/widgets/grid-cards/card-parts/status' );
				?>
			</div>

			<?php
			ere_get_template_part( 'includes/widgets/grid-cards/card-parts/thumbnail' );

			?>
		</div>

		<div class="rh_detail_wrapper rh_detail_wrapper_2">

			<?php
			ere_get_template_part( 'includes/widgets/grid-cards/card-parts/heading' );

			ere_get_template_part( 'includes/widgets/grid-cards/card-parts/address' );

			if ( inspiry_is_rvr_enabled() ) {
				?>
				<div class="rh_rvr_ratings_wrapper_stylish rvr_rating_left">

					<?php rh_rvr_rating_average(); ?>

					<?php
					ere_get_template_part( 'includes/widgets/grid-cards/card-parts/added' );
					?>
				</div>
				<?php
			} else {
				ere_get_template_part( 'includes/widgets/grid-cards/card-parts/added' );
			}

			ere_get_template_part( 'includes/widgets/grid-cards/card-parts/grid-card-meta' );
			?>
			<div class="rh_price_fav_box">

				<div class="rh_price_box">
					<?php
					ere_get_template_part( 'includes/widgets/grid-cards/card-parts/price' );
					?>
				</div>

				<div class="rh_fav_icon_box rh_parent_fav_button">
					<?php
					if ( function_exists( 'inspiry_favorite_button' ) ) {
						inspiry_favorite_button( get_the_ID(), null, '', '' );
					}
					if ( function_exists( 'inspiry_add_to_compare_button' ) ) {
						inspiry_add_to_compare_button();
					}
					?>

				</div>
			</div>

		</div>
        <div class="rh_wrapper_bottom_agent">
			<?php
			if ( ! is_singular( 'agent' ) ) {
				if ( inspiry_is_rvr_enabled() ) {
					ere_get_template_part( 'includes/widgets/grid-cards/card-parts/rvr-owner' );

				} else {
					ere_get_template_part( 'includes/widgets/grid-cards/card-parts/agent-in-listing' );
				}
			}
			?>
        </div>

	</div>

</article>
