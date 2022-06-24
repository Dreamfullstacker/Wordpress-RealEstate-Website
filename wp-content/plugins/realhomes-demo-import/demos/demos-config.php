<?php
/**
 * This file has the configuration of available demos to import, related plugins to install and
 * settings after a demo import.
 *
 * @since      1.0.0
 * @package    realhomes-demo-import
 * @subpackage realhomes-demo-import/demos
 */


/**
 * Demos to Import.
 *
 * @return array[]
 */


if ( ! function_exists( 'rhdi_mime_types' ) ) {
	// Allow SVG icon
	function rhdi_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}
}

if ( ! function_exists( 'rhdi_enable_svg_permission' ) ) {
	// Enable SVG files upload for demo imports only
	function rhdi_enable_svg_permission() {
		add_filter( 'upload_mimes', 'rhdi_mime_types' );
	}

	add_action( 'import_start', 'rhdi_enable_svg_permission' );
}


function rhdi_import_files(): array {
	$path_to_demos_dir = trailingslashit( plugin_dir_path( __FILE__ ) );
	$url_to_demos_dir = plugin_dir_url( __FILE__ );
	return array(
		// 0
		array(
			'import_file_name'             => 'Modern - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'elementor-modern/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'elementor-modern/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'elementor-modern/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'elementor-modern/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/elementor-modern/',
			'categories'                   => array( 'Elementor', 'Modern' ),
		),
		// 1
		array(
			'import_file_name'             => 'Modern 02 - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'elementor-modern-02/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'elementor-modern-02/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'elementor-modern-02/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'elementor-modern-02/demo.jpg',
			'preview_url'                  => 'https://sample.realhomes.io/modern02/',
			'categories'                   => array( 'New' , 'Elementor', 'Modern'),
			'is_new'                       => true,
		),
		//2
		array(
			'import_file_name'             => 'Modern 03 - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'elementor-modern-03/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'elementor-modern-03/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'elementor-modern-03/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'elementor-modern-03/demo.jpg',
			'preview_url'                  => 'https://sample.realhomes.io/modern03/',
			'categories'                   => array( 'New' , 'Elementor', 'Modern'),
			'is_new'                       => true,
		),
		//3
		array(
			'import_file_name'             => 'Modern 04 - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'elementor-modern-04/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'elementor-modern-04/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'elementor-modern-04/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'elementor-modern-04/demo.jpg',
			'preview_url'                  => 'https://sample.realhomes.io/modern04/',
			'categories'                   => array( 'New' , 'Elementor', 'Modern'),
			'is_new'                       => true,
		),
		// 4
		array(
			'import_file_name'             => 'Single Property - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'single-property/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'single-property/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'single-property/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'single-property/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/single-property/',
			'categories'                   => array( 'Elementor', 'Modern' ),
		),
		//5
		array(
			'import_file_name'             => 'Single Property 02 - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'single-property-02/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'single-property-02/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'single-property-02/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'single-property-02/demo.jpg',
			'preview_url'                  => 'https://sample.realhomes.io/single-property-02/',
			'categories'                   => array( 'New' , 'Elementor', 'Modern' ),
			'is_new'                       => true,
		),
		// 6
		array(
			'import_file_name'             => 'Single Agent - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'single-agent/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'single-agent/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'single-agent/customizer.dat',
			'local_import_slider_file'     => $path_to_demos_dir . 'single-agent/realhomes-agent-slider.zip',
			'import_preview_image_url'     => $url_to_demos_dir . 'single-agent/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/solo-agent/',
			'categories'                   => array( 'Elementor', 'Modern', 'Slider Revolution' ),
		),
		// 7
		array(
			'import_file_name'             => 'Vacation Rentals - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'vacation-rentals/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'vacation-rentals/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'vacation-rentals/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'vacation-rentals/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/vacation-rentals/',
			'categories'                   => array( 'Elementor', 'Modern', 'Vacation Rentals' ),
		),
		// 8
		array(
			'import_file_name'             => 'Modern',
			'local_import_file'            => $path_to_demos_dir . 'modern/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'modern/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'modern/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'modern/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/modern/',
			'categories'                   => array( 'Modern' ),
		),
		// 9
		array(
			'import_file_name'             => 'Classic - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'elementor-classic/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'elementor-classic/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'elementor-classic/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'elementor-classic/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/classic-elementor/',
			'categories'                   => array( 'Elementor', 'Classic' ),
		),
		// 10
		array(
			'import_file_name'             => 'Classic',
			'local_import_file'            => $path_to_demos_dir . 'classic/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'classic/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'classic/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'classic/demo.jpg',
			'preview_url'                  => 'https://di.realhomes.io/classic/',
			'categories'                   => array( 'Classic' ),
		),
		// 11
		array(
			'import_file_name'             => 'Español Modern - Elementor',
			'local_import_file'            => $path_to_demos_dir . 'spanish-elementor-modern/contents.xml',
			'local_import_widget_file'     => $path_to_demos_dir . 'spanish-elementor-modern/widgets.wie',
			'local_import_customizer_file' => $path_to_demos_dir . 'spanish-elementor-modern/customizer.dat',
			'import_preview_image_url'     => $url_to_demos_dir . 'spanish-elementor-modern/demo.jpg',
			'preview_url'                  => 'https://demo.realhomes.io/spanish/',
			'categories'                   => array( 'Elementor', 'Modern', 'Español' ),
		),
	);
}

add_filter( 'ocdi/import_files', 'rhdi_import_files' );

/**
 * Required plugins for demo imports.
 *
 * @return array|array[]
 */
function rhdi_register_plugins( $plugins ): array {
	// list of plugins recommended by RealHomes
	$theme_plugins = [
		[
			'name'        => 'Easy Real Estate',
			'description' => esc_html__( 'Provides real estate functionality for RealHomes theme.', 'realhomes-demo-import' ),
			'slug'        => 'easy-real-estate',
			'version'     => '1.1.3',
			'source'   => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/easy-real-estate.zip',
			'required'    => true,
			'preselected' => true,
		]
	];

	// Check if user is on the theme recommeneded plugins step and a demo was selected.
	if (
		isset( $_GET['step'] ) &&
		$_GET['step'] === 'import' &&
		isset( $_GET['import'] )
	) {

		// Add required plugins for Elementor based demo import
		if (
			$_GET['import'] === '0' ||  // Modern - Elementor
			$_GET['import'] === '1' ||  // Modern 02 - Elementor
			$_GET['import'] === '2' ||  // Modern 03 - Elementor
			$_GET['import'] === '3' ||  // Modern 04 - Elementor
			$_GET['import'] === '4' ||  // Single Property - Elementor
			$_GET['import'] === '5' ||  // Single Property 02 - Elementor
			$_GET['import'] === '6' ||  // Single Agent - Elementor
			$_GET['import'] === '7' ||  // Vocation Rental - Elementor
			$_GET['import'] === '9' ||  // Classic - Elementor
			$_GET['import'] === '11'     // Espanol Modern - Elementor
		) {
			$theme_plugins[] = [
				'name'        => esc_html__( 'Elementor Page Builder', 'realhomes-demo-import' ),
				'description' => esc_html__( 'The page builder supported by RealHomes theme.', 'realhomes-demo-import' ),
				'slug'        => 'elementor',
				'required'    => true,
				'preselected' => true,
			];

			$theme_plugins[] = [
				'name'        => 'RealHomes Elementor Addon',
				'description' => esc_html__( 'Provides RealHomes based Elementor widgets.', 'realhomes-demo-import' ),
				'slug'        => 'realhomes-elementor-addon',
				'version'     => '0.9.5',
				'source'   => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/realhomes-elementor-addon.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

		// Add required plugin for single agent demo import
		if ( $_GET['import'] === '6' ) {
			$theme_plugins[] = [
				'name'        => 'Slider Revolution',
				'description' => esc_html__( 'Slider Revolution plugin.', 'realhomes-demo-import' ),
				'slug'        => 'revslider',
				'version'     => '6.4.3',
				'source'      => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/revslider.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

		// Add required plugin for RVR demo import
		if ( $_GET['import'] === '7' ) {
			$theme_plugins[] = [
				'name'        => 'RealHomes Vacation Rentals',
				'description' => esc_html__( 'Provides vacation rentals functionality for RealHomes.', 'realhomes-demo-import' ),
				'slug'        => 'realhomes-vacation-rentals',
				'version'     => '1.3.2',
				'source'    => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/realhomes-vacation-rentals.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

		// Fix of a bug in OCDI
		// For AJAX calls during plugins installation
		// We get slug in $_POST based on AJAX calls from installPluginsAjaxCall function in main.js file.
	} elseif ( isset( $_POST['slug'] ) ){

		if ( $_POST['slug'] == 'elementor' ) {
			$theme_plugins[] = [
				'name'        => esc_html__( 'Elementor Page Builder', 'realhomes-demo-import' ),
				'description' => esc_html__( 'The page builder supported by RealHomes theme.', 'realhomes-demo-import' ),
				'slug'        => 'elementor',
				'required'    => true,
				'preselected' => true,
			];
		}

		if ( $_POST['slug'] == 'realhomes-elementor-addon' ) {
			$theme_plugins[] = [
				'name'        => 'RealHomes Elementor Addon',
				'description' => esc_html__( 'Provides RealHomes based Elementor widgets.', 'realhomes-demo-import' ),
				'slug'        => 'realhomes-elementor-addon',
				'version'     => '0.9.5',
				'source'   => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/realhomes-elementor-addon.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

		if ( $_POST['slug'] == 'revslider' ) {
			$theme_plugins[] = [
				'name'        => 'Slider Revolution',
				'description' => esc_html__( 'Slider Revolution plugin.', 'realhomes-demo-import' ),
				'slug'        => 'revslider',
				'version'     => '6.4.3',
				'source'      => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/revslider.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

		if ( $_POST['slug'] == 'realhomes-vacation-rentals' ) {
			$theme_plugins[] = [
				'name'        => 'RealHomes Vacation Rentals',
				'description' => esc_html__( 'Provides vacation rentals functionality for RealHomes.', 'realhomes-demo-import' ),
				'slug'        => 'realhomes-vacation-rentals',
				'version'     => '1.3.2',
				'source'    => 'https://inspiry-plugins.s3.us-east-2.amazonaws.com/realhomes-vacation-rentals.zip',
				'required'    => true,
				'preselected' => true,
			];
		}

	}

	// A recommended plugin in the end
	$theme_plugins[] = [
		'name'        => 'Quick and Easy FAQs',
		'description' => esc_html__( 'Provides FAQs functionality.', 'realhomes-demo-import' ),
		'slug'        => 'quick-and-easy-faqs',
		'required'    => false,
	];

	return array_merge( $plugins, $theme_plugins );
}

add_filter( 'ocdi/register_plugins', 'rhdi_register_plugins' );


/**
 * After import setup.
 *
 * @param $selected_import
 */
function rhdi_after_import_setup( $selected_import ) {

	$import_demo_name = $selected_import['import_file_name'];

	// Update design setting.
	if ( 'Classic' === $import_demo_name || 'Classic - Elementor' === $import_demo_name ) {
		update_option( 'inspiry_design_variation', 'classic' );
	} elseif ( 'Modern' === $import_demo_name
	           || 'Modern - Elementor' === $import_demo_name
	           || 'Modern 02 - Elementor' === $import_demo_name
	           || 'Modern 03 - Elementor' === $import_demo_name
	           || 'Modern 04 - Elementor' === $import_demo_name
	           || 'Single Agent - Elementor' === $import_demo_name
	           || 'Single Property - Elementor' === $import_demo_name
	           || 'Single Property 02 - Elementor' === $import_demo_name
	           || 'Vacation Rentals - Elementor' === $import_demo_name
	           || 'Español Modern - Elementor' === $import_demo_name ) {
		update_option( 'inspiry_design_variation', 'modern' );
	}

	// Assign menu to right location.
	$locations = get_theme_mod( 'nav_menu_locations' );
	if ( ! empty( $locations ) && is_array( $locations ) ) {
		foreach ( $locations as $location_id => $menu_value ) {
			$menu = null;
			switch ( $location_id ) {
				case 'responsive-menu':
				case 'main-menu':
					$menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
					break;

			}
			if ( ! empty( $menu ) ) {
				$locations[ $location_id ] = $menu->term_id;
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Set homepage as front page and blog page as posts page.
	if ( 'Español Modern - Elementor' === $import_demo_name ) {
		$home_page = get_page_by_title( 'Inicio' );
		$blog_page = get_page_by_title( 'Blog' );

	} elseif ( 'Vacation Rentals - Elementor' === $import_demo_name ) {
		$home_page = get_page_by_title( 'Home' );
		$blog_page = get_page_by_title( 'Blog' );

		// Enable RVR in its settings if it's not yet.
		$rvr_settings = get_option( 'rvr_settings' );
		$rvr_enabled  = isset( $rvr_settings['rvr_activation'] ) ? $rvr_settings['rvr_activation'] : false;

		if ( ! $rvr_enabled && class_exists( 'Realhomes_Vacation_Rentals' ) ) {
			$rvr_settings['rvr_activation'] = 1;
			update_option( 'rvr_settings', $rvr_settings );
		}

	} elseif ( 'Modern - Elementor' === $import_demo_name
	           || 'Single Property - Elementor' === $import_demo_name
	           ||'Single Property 02 - Elementor' === $import_demo_name
	           ||'Single Property 03 - Elementor' === $import_demo_name
	           ||'Single Property 04 - Elementor' === $import_demo_name
	           || 'Single Agent - Elementor' === $import_demo_name ) {
		$home_page = get_page_by_title( 'Home' );
		$blog_page = get_page_by_title( 'Blog' );

	} else {
		$home_page = get_page_by_title( 'Home' );
		$blog_page = get_page_by_title( 'News' );
	}

	// Show page as front
	if ( $home_page || $blog_page ) {
		update_option( 'show_on_front', 'page' );
	}

	// Set homepage as front page
	if ( $home_page ) {
		update_option( 'page_on_front', $home_page->ID );
	}

	// Set blog page as posts page
	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
		update_option( 'posts_per_page', 4 );
	}

	// Importing Slider Revolution Zip
	if ( 'Single Agent - Elementor' === $import_demo_name ) {
		if ( class_exists( 'RevSliderSliderImport' ) ) {
			$rev_slider_importer = new RevSliderSliderImport();
			$rev_slider_zip      = $selected_import['local_import_slider_file'];

			if ( file_exists( $rev_slider_zip ) ) {
				$is_template       = false;
				$single_slide      = true;
				$update_animation  = true;
				$update_navigation = true;
				$install           = true;

				// finally import rev slider zip file
				$slider_import_result = $rev_slider_importer->import_slider( $update_animation, $rev_slider_zip, $is_template, $single_slide, $update_navigation, $install );

				if ( ! $slider_import_result['success'] ) {
					inspiry_log( $slider_import_result );
				}
			}
		}
	}

	// No need of migration after latest demo import.
	update_option( 'inspiry_home_settings_migration', 'true' );

	// Set fonts to Default.
	if ( 'Single Property - Elementor' === $import_demo_name ) {
		// single property uses custom fonts in customizer settings
	} else {
		update_option( 'inspiry_heading_font', 'Default' );
		update_option( 'inspiry_secondary_font', 'Default' );
		update_option( 'inspiry_body_font', 'Default' );
	}

	// Set scroll to top default position
	update_option( 'inspiry_stp_position_from_bottom', '15px' );

	// Disable Elementor typography and color schemes.
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_disable_color_schemes', 'yes' );

	// Update Elementor container width.
	$get_elementor_container_width = get_option( 'elementor_container_width' );
	if ( empty( $get_elementor_container_width ) ) {
		update_option( 'elementor_container_width', 1240 );
	}
}

add_action( 'ocdi/after_import', 'rhdi_after_import_setup' );
