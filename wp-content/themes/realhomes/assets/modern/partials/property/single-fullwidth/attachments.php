<?php
/**
 * Attachments of a property.
 *
 * @package    realhomes
 * @subpackage modern
 */
if ( 'true' === get_option( 'theme_display_attachments' ) ) :
	if ( ! empty( inspiry_get_property_attachments() ) ) :
		?>
        <div class="attachments-content-wrapper single-property-section">
            <div class="container">
				<?php get_template_part( 'assets/modern/partials/property/single/attachments' ); ?>
            </div>
        </div>
	<?php
	endif;
endif;