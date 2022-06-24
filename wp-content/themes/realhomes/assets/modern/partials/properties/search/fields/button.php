<?php
/**
 * Advance Search Button
 *
 * Advance property submit search button.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_prop_search__btnWrap clearfix">

	<div class="rh_prop_search__advance">
		<a href="#" class="rh_prop_search__advance_btn">
			<?php inspiry_safe_include_svg( '/images/icons/icon-search-plus.svg' ); ?>
		</a>

		<?php
		$inspiry_enable_search_label_image = get_post_meta( get_the_ID(), 'inspiry_enable_search_label_image', true );
		$inspiry_search_label_text         = get_post_meta( get_the_ID(), 'inspiry_search_label_text', true );

		if ( ( $inspiry_enable_search_label_image == 'true' ) && ( ! empty( $inspiry_search_label_text ) ) ) {
			?>
			<span class="advance-search-arrow">
			<span class="arrow-inner">
				<span><?php echo esc_html( $inspiry_search_label_text ); ?></span>
				<?php inspiry_safe_include_svg( '/images/icons/advance-search-arrow.svg' ); ?>
			</span>
		</span>
			<?php
		}
		?>

	</div>
	<div class="rh_prop_search__searchBtn">
		<?php $inspiry_search_button_text = get_option( 'inspiry_search_button_text' ); ?>
		<button class="rh_btn rh_btn__prop_search" type="submit">
			<?php inspiry_safe_include_svg( '/images/icons/icon-search.svg' ); ?>
			<span>
				<?php
                if ( !empty( $inspiry_search_button_text ) ) {
                    echo esc_html( $inspiry_search_button_text );
                } else {
                    echo esc_html__( 'Search', 'framework' );
                }
				?>
			</span>
		</button>
	</div>

</div>
<!-- /.rh_prop_search__btnWrap -->
