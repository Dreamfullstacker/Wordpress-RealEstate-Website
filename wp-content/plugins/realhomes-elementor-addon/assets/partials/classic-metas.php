<?php

global $settings;
$property_bedrooms_label = $settings['ere_property_bedrooms_label'];
$property_bathroom_label = $settings['ere_property_bathroom_label'];
$property_garage_label   = $settings['ere_property_garage_label'];


$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$garages            = get_post_meta( get_the_ID(), 'REAL_HOMES_property_garage', true );


if ( ! empty( $property_size ) ) {
	?>
    <div class="rhea_meta_wrapper">
        <div class="rhea_meta_wrapper_inner">
		<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-size.svg'; ?>
        <span class="figure">
            <?php
            echo esc_html( $property_size );
            if ( ! empty( $size_postfix ) ) {
	            echo '&nbsp;' . esc_html( $size_postfix );
            }
            ?>
        </span>
        </div>
    </div>
	<?php
}

if ( ! empty( $property_bedrooms ) ) {
	?>
    <div class="rhea_meta_wrapper">
        <div class="rhea_meta_wrapper_inner">
		<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-bed.svg'; ?>
        <span class="figure">
                 <?php
                 echo esc_html( $property_bedrooms );
                 if ( ! empty( $property_bedrooms_label ) ) {
	                 echo '&nbsp;' . esc_html( $property_bedrooms_label );
                 } else {
	                echo '&nbsp;' . esc_html__( 'Bedrooms', 'realhomes-elementor-addon' );
                 }
                 ?>
        </span>
    </div>
    </div>
	<?php
}


if ( ! empty( $property_bathrooms ) ) {
	?>
    <div class="rhea_meta_wrapper">
        <div class="rhea_meta_wrapper_inner">
		<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-bath.svg'; ?>
        <span class="figure">
                          <?php
                          echo esc_html( $property_bathrooms );
                          if ( ! empty( $property_bathroom_label ) ) {
	                          echo '&nbsp;' . esc_html( $property_bathroom_label );
                          } else {
	                          echo '&nbsp;' . esc_html__( 'Bathrooms', 'realhomes-elementor-addon' );
                          }
                          ?>
        </span>
    </div>
    </div>
	<?php
}

if ( ! empty( $garages ) ) {
	?>
    <div class="rhea_meta_wrapper">
    <div class="rhea_meta_wrapper_inner">
		<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-garage.svg'; ?>
        <span class="figure">
                                  <?php
                                  echo esc_html( $garages );
                                  if ( ! empty( $property_garage_label ) ) {
	                                  echo '&nbsp;' . esc_html( $property_garage_label );
                                  } else {
	                                  echo '&nbsp;' . esc_html__( 'Garages', 'realhomes-elementor-addon' );
                                  }
                                  ?>
        </span>
    </div>
    </div>
	<?php
}


