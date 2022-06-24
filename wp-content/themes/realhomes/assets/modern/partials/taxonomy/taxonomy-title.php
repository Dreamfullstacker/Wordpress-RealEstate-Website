<?php
/**
 * Taxonomy: Title
 *
 * Title of taxonomy.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

// Taxonomy Title.
$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$page_title = $current_term->name;

// Page Head.
$header_variation = get_option( 'inspiry_listing_header_variation' );
?>
<div class="rh_page__head">
	<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
		<h2 class="rh_page__title rh_page__title_pad">
			<?php echo inspiry_get_exploded_heading( $page_title ); ?>
		</h2><!-- /.rh_page__title -->
	<?php endif; ?>
	<div class="rh_page__controls">
		<?php get_template_part( 'assets/modern/partials/properties/sort-controls' ); ?>
		<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
			<?php get_template_part( 'assets/modern/partials/properties/view-buttons' ); ?>
		<?php endif; ?>
	</div><!-- /.rh_page__controls -->
</div><!-- /.rh_page__head -->

<?php inspiry_term_description(); ?>