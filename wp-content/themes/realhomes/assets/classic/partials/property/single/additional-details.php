<?php
/**
 * Additional details.
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;

ere_additional_details_migration( get_the_ID() ); // Migrate property additional details from old metabox key to new key.
$additional_details = get_post_meta( get_the_ID(), 'REAL_HOMES_additional_details_list', true );

if ( ! empty( $additional_details ) ) {
	$additional_details = array_filter( $additional_details ); // remove empty values.
}

if ( ! empty( $additional_details ) ) {

	$additional_details_title = get_option( 'theme_additional_details_title' );
	if ( ! empty( $additional_details_title ) ) {
		echo '<h4 class="additional-title">' . esc_html( $additional_details_title ) . '</h4>';
	}

	echo '<ul class="additional-details clearfix">';
	foreach ( $additional_details as $field => $value ) {
		?>
		<li>
			<strong><?php echo esc_html( $value[0] ); ?>:</strong>
			<span><?php echo esc_html( $value[1] ); ?></span>
		</li>
		<?php
	}
	echo '</ul>';

}
