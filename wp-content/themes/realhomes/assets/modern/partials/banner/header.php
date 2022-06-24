<?php
/**
 * None banner header.
 *
 * @package realhomes
 * @subpackage modern
 */

        $get_responsive_header = get_option('inspiry_responsive_header_option','solid');

        if($get_responsive_header == 'solid'){
            $responsive_class = ' rh_banner__default_hide ';
        }else{
	        $responsive_class = ' ';
        }
?>

<section class="rh_banner rh_banner__default <?php echo esc_attr( $responsive_class ); ?>"></section>
<!-- /.rh_banner -->
