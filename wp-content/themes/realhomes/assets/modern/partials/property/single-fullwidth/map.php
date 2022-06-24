<?php if ( 'true' === get_option( 'theme_display_google_map' ) ) : ?>
    <div class="map-content-wrapper single-property-section">
        <div class="container">
			<?php get_template_part( 'assets/modern/partials/property/single/map' ); ?>
        </div>
    </div>
<?php endif; ?>