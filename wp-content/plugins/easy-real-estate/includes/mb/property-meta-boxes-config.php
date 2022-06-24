<?php
// Basic information meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/basic-metaboxes.php';

// Location map meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/location-metaboxes.php';

// Gallery meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/gallery-metaboxes.php';

// Floor plans meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/floorplans-metaboxes.php';

// Video meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/video-metaboxes.php';

// Agent meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/agent-metaboxes.php';

// Energy meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/energy-metaboxes.php';

// Misc meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/misc-metaboxes.php';

// Misc meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/homeslider-metaboxes.php';

// Banner meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/banner-metaboxes.php';

// Custom taxonomy meta boxes
include_once ERE_PLUGIN_DIR . 'includes/mb/property/custom-taxonomy-metaboxes.php';

if ( ! function_exists( 'ere_property_meta_boxes' ) ) :
	/**
	 * Contains property related meta box declarations
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	function ere_property_meta_boxes( $meta_boxes ) {

		// tabs are added using filter hooks
		$meta_tabs = array();

		// fields are added using filter hooks
		$meta_fields = array();

		// Property meta boxes
		$meta_boxes[] = array(
			'id'         => 'property-meta-box',
			'title'      => esc_html__( 'Property', 'easy-real-estate' ),
			'post_types' => array( 'property' ),
			'tabs'       => apply_filters( 'ere_property_metabox_tabs', $meta_tabs ),
			'tab_style'  => 'left',
			'fields'     => apply_filters( 'ere_property_metabox_fields', $meta_fields ),
		);

		return apply_filters( 'ere_property_meta_boxes', $meta_boxes );

	}

	add_filter( 'rwmb_meta_boxes', 'ere_property_meta_boxes' );

endif;

