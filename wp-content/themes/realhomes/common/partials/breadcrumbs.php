<?php
/**
 * Breadcrumbs for property detail page.
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;

$possible_taxonomies  = array( 'property-city', 'property-type', 'property-status' );
$breadcrumbs_taxonomy = get_option( 'theme_breadcrumbs_taxonomy' );
if ( $breadcrumbs_taxonomy && in_array( $breadcrumbs_taxonomy, $possible_taxonomies ) ) {

	$inspiry_breadcrumbs_items = inspiry_get_breadcrumbs_items( get_the_ID(), $breadcrumbs_taxonomy, false );
	$breadcrumbs_count         = count( $inspiry_breadcrumbs_items );

	if ( is_array( $inspiry_breadcrumbs_items ) && ( 0 < $breadcrumbs_count ) ) {

		$bread_crumbs_modern = '';
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$bread_crumbs_modern = ' page-breadcrumbs-modern';
		}
		?>
		<div class="page-breadcrumbs <?php echo esc_attr( $bread_crumbs_modern );?>">
			<nav class="property-breadcrumbs">
				<ul>
					<?php
					$breadcrumbs_item_index = 1;
					foreach ( $inspiry_breadcrumbs_items as $item ) {

						echo '<li>';

						if ( isset( $item['url'] ) && ! empty( $item['url'] ) ) {
							?>
							<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['name'] ); ?></a><?php
						} else {
							echo esc_html( $item['name'] );
						}

						$breadcrumbs_item_index ++;
						if ( $breadcrumbs_item_index <= $breadcrumbs_count ) {
							if ( is_rtl() ) {
								?><i class="breadcrumbs-separator fas fa-angle-left"></i><?php
							} else {
								?><i class="breadcrumbs-separator fas fa-angle-right"></i><?php
							}
						}

						echo '</li>';
					}
					?>
				</ul>
			</nav>
		</div>
		<?php

	}
}
