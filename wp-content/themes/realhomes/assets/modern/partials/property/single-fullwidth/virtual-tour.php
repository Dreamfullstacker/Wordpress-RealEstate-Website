<?php if ( 'true' === get_option( 'inspiry_display_virtual_tour' ) && ! empty( get_post_meta( get_the_ID(), 'REAL_HOMES_360_virtual_tour', true ) ) ) : ?>
    <div class="virtual-tour-content-wrapper single-property-section">
        <div class="container">
			<?php get_template_part( 'assets/modern/partials/property/single/virtual-tour' ); ?>
        </div>
    </div>
<?php endif; ?>