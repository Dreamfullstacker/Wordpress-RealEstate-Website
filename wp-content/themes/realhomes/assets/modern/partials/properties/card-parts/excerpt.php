<?php
$theme_listing_excerpt_length = get_option( 'theme_listing_excerpt_length' );

if ( ! empty( $theme_listing_excerpt_length ) && ( 0 < $theme_listing_excerpt_length ) ) {
	$card_excerpt = $theme_listing_excerpt_length;
} else {
	$card_excerpt = 10;
}
?>
    <p class="rh_prop_stylish_card__excerpt"><?php framework_excerpt( esc_html( $card_excerpt ) ); ?></p>
	<?php
