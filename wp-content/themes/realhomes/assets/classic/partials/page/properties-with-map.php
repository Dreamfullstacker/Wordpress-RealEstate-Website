<?php
/**
 * Half map based Property Listing
 *
 * Page template for half map based property listing.
 *
 * @package    realhomes
 * @subpackage classic
 */
get_header();

echo '</div>'; // close inspiry_half_map_header_wrapper in header.php

?>


<?php get_template_part( 'assets/classic/partials/properties/half-map-list' ); ?>

<?php get_footer(); ?>