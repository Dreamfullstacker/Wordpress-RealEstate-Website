<?php
/**
 * Property Custom Post Type
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ere_register_property_post_type' ) ) {

	/**
	 * Register Property CPT
	 */
	function ere_register_property_post_type() {

		if ( post_type_exists( 'property' ) ) {
			return;
		}

		$property_post_type_labels = array(
			'name'               => esc_html__( 'Properties', 'easy-real-estate' ),
			'singular_name'      => esc_html__( 'Property', 'easy-real-estate' ),
			'add_new'            => esc_html__( 'Add New', 'easy-real-estate' ),
			'add_new_item'       => esc_html__( 'Add New Property', 'easy-real-estate' ),
			'edit_item'          => esc_html__( 'Edit Property', 'easy-real-estate' ),
			'new_item'           => esc_html__( 'New Property', 'easy-real-estate' ),
			'view_item'          => esc_html__( 'View Property', 'easy-real-estate' ),
			'search_items'       => esc_html__( 'Search Property', 'easy-real-estate' ),
			'not_found'          => esc_html__( 'No Property found', 'easy-real-estate' ),
			'not_found_in_trash' => esc_html__( 'No Property found in Trash', 'easy-real-estate' ),
			'parent_item_colon'  => esc_html__( 'Parent Property', 'easy-real-estate' ),
		);

		$property_post_type_args = array(
			'labels'             => apply_filters( 'inspiry_property_post_type_labels', $property_post_type_labels ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'easy-real-estate',
			'query_var'          => true,
			'has_archive'        => true,
			'capability_type'    => 'post',
			'hierarchical'       => true,
			'menu_icon'          => 'dashicons-building',
			'menu_position'      => 5,
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes',
				'excerpt',
				'comments'
			),
			'rewrite'            => array(
				'slug' => apply_filters( 'inspiry_property_slug', __( 'property', 'easy-real-estate' ) ),
			),
			'show_in_rest'       => true,
			'rest_base'          => apply_filters( 'inspiry_property_rest_base', 'properties' ),
		);

		$property_post_type_args = apply_filters( 'inspiry_property_post_type_args', $property_post_type_args );
		register_post_type( 'property', $property_post_type_args );

	}

	add_action( 'init', 'ere_register_property_post_type' );
}


if ( ! function_exists( 'ere_set_property_slug' ) ) :
	/**
	 * This function set property's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property slug.
	 *
	 * @return string
	 */
	function ere_set_property_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_property_slug' );
		if ( ! empty( $new_slug ) ) {
			return utf8_uri_encode( $new_slug );
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_property_slug', 'ere_set_property_slug' );
	add_filter( 'inspiry_property_rest_base', 'ere_set_property_slug' );
endif;


if ( ! function_exists( 'ere_register_property_taxonomies' ) ) {
	/**
	 * Register Property related custom taxonomies
	 */
	function ere_register_property_taxonomies() {
		ere_register_property_feature_taxonomy();
		ere_register_property_type_taxonomy();
		ere_register_property_city_taxonomy();
		ere_register_property_status_taxonomy();
	}

	add_action( 'init', 'ere_register_property_taxonomies', 0 );
}


if ( ! function_exists( 'ere_register_property_feature_taxonomy' ) ) :
	function ere_register_property_feature_taxonomy() {
		if ( taxonomy_exists( 'property-feature' ) ) {
			return;
		}

		$feature_labels = array(
			'name'                       => esc_html__( 'Property Features', 'easy-real-estate' ),
			'singular_name'              => esc_html__( 'Property Feature', 'easy-real-estate' ),
			'search_items'               => esc_html__( 'Search Property Features', 'easy-real-estate' ),
			'popular_items'              => esc_html__( 'Popular Property Features', 'easy-real-estate' ),
			'all_items'                  => esc_html__( 'All Property Features', 'easy-real-estate' ),
			'parent_item'                => esc_html__( 'Parent Property Feature', 'easy-real-estate' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Feature:', 'easy-real-estate' ),
			'edit_item'                  => esc_html__( 'Edit Property Feature', 'easy-real-estate' ),
			'update_item'                => esc_html__( 'Update Property Feature', 'easy-real-estate' ),
			'add_new_item'               => esc_html__( 'Add New Property Feature', 'easy-real-estate' ),
			'new_item_name'              => esc_html__( 'New Property Feature Name', 'easy-real-estate' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Features with commas', 'easy-real-estate' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Features', 'easy-real-estate' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Features', 'easy-real-estate' ),
			'menu_name'                  => esc_html__( 'Property Features', 'easy-real-estate' ),
		);

		register_taxonomy(
			'property-feature',
			array( 'property' ),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters( 'inspiry_property_feature_labels', $feature_labels ),
				'show_ui'      => true,
				'show_in_menu' => 'easy-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters( 'inspiry_property_feature_slug', __( 'property-feature', 'easy-real-estate' ) ),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters( 'inspiry_property_feature_rest_base', __( 'property-features', 'easy-real-estate' ) )
			)
		);
	}
endif;


if ( ! function_exists( 'ere_register_property_type_taxonomy' ) ) :
	function ere_register_property_type_taxonomy() {
		if ( taxonomy_exists( 'property-type' ) ) {
			return;
		}

		$type_labels = array(
			'name'                       => esc_html__( 'Property Types', 'easy-real-estate' ),
			'singular_name'              => esc_html__( 'Property Type', 'easy-real-estate' ),
			'search_items'               => esc_html__( 'Search Property Types', 'easy-real-estate' ),
			'popular_items'              => esc_html__( 'Popular Property Types', 'easy-real-estate' ),
			'all_items'                  => esc_html__( 'All Property Types', 'easy-real-estate' ),
			'parent_item'                => esc_html__( 'Parent Property Type', 'easy-real-estate' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Type:', 'easy-real-estate' ),
			'edit_item'                  => esc_html__( 'Edit Property Type', 'easy-real-estate' ),
			'update_item'                => esc_html__( 'Update Property Type', 'easy-real-estate' ),
			'add_new_item'               => esc_html__( 'Add New Property Type', 'easy-real-estate' ),
			'new_item_name'              => esc_html__( 'New Property Type Name', 'easy-real-estate' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Types with commas', 'easy-real-estate' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Types', 'easy-real-estate' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Types', 'easy-real-estate' ),
			'menu_name'                  => esc_html__( 'Property Types', 'easy-real-estate' ),
		);

		register_taxonomy(
			'property-type',
			array( 'property' ),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters( 'inspiry_property_type_labels', $type_labels ),
				'show_ui'      => true,
				'show_in_menu' => 'easy-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters( 'inspiry_property_type_slug', __( 'property-type', 'easy-real-estate' ) ),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters( 'inspiry_property_type_rest_base', __( 'property-types', 'easy-real-estate' ) )
			)
		);
	}
endif;


if ( ! function_exists( 'ere_register_property_city_taxonomy' ) ) :
	function ere_register_property_city_taxonomy() {
		if ( taxonomy_exists( 'property-city' ) ) {
			return;
		}

		$city_labels = array(
			'name'                       => esc_html__( 'Property Locations', 'easy-real-estate' ),
			'singular_name'              => esc_html__( 'Property Location', 'easy-real-estate' ),
			'search_items'               => esc_html__( 'Search Property Locations', 'easy-real-estate' ),
			'popular_items'              => esc_html__( 'Popular Property Locations', 'easy-real-estate' ),
			'all_items'                  => esc_html__( 'All Property Locations', 'easy-real-estate' ),
			'parent_item'                => esc_html__( 'Parent Property Location', 'easy-real-estate' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Location:', 'easy-real-estate' ),
			'edit_item'                  => esc_html__( 'Edit Property Location', 'easy-real-estate' ),
			'update_item'                => esc_html__( 'Update Property Location', 'easy-real-estate' ),
			'add_new_item'               => esc_html__( 'Add New Property Location', 'easy-real-estate' ),
			'new_item_name'              => esc_html__( 'New Property Location Name', 'easy-real-estate' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Locations with commas', 'easy-real-estate' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Locations', 'easy-real-estate' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Locations', 'easy-real-estate' ),
			'menu_name'                  => esc_html__( 'Property Locations', 'easy-real-estate' ),
		);

		register_taxonomy(
			'property-city',
			array( 'property' ),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters( 'inspiry_property_city_labels', $city_labels ),
				'show_ui'      => true,
				'show_in_menu' => 'easy-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters( 'inspiry_property_city_slug', __( 'property-city', 'easy-real-estate' ) ),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters( 'inspiry_property_city_rest_base', __( 'property-cities', 'easy-real-estate' ) )
			)
		);
	}
endif;


if ( ! function_exists( 'ere_register_property_status_taxonomy' ) ) :
	function ere_register_property_status_taxonomy() {
		if ( taxonomy_exists( 'property-status' ) ) {
			return;
		}

		$status_labels = array(
			'name'                       => esc_html__( 'Property Statuses', 'easy-real-estate' ),
			'singular_name'              => esc_html__( 'Property Status', 'easy-real-estate' ),
			'search_items'               => esc_html__( 'Search Property Status', 'easy-real-estate' ),
			'popular_items'              => esc_html__( 'Popular Property Status', 'easy-real-estate' ),
			'all_items'                  => esc_html__( 'All Property Status', 'easy-real-estate' ),
			'parent_item'                => esc_html__( 'Parent Property Status', 'easy-real-estate' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Status:', 'easy-real-estate' ),
			'edit_item'                  => esc_html__( 'Edit Property Status', 'easy-real-estate' ),
			'update_item'                => esc_html__( 'Update Property Status', 'easy-real-estate' ),
			'add_new_item'               => esc_html__( 'Add New Property Status', 'easy-real-estate' ),
			'new_item_name'              => esc_html__( 'New Property Status Name', 'easy-real-estate' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Status with commas', 'easy-real-estate' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Status', 'easy-real-estate' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Status', 'easy-real-estate' ),
			'menu_name'                  => esc_html__( 'Property Status', 'easy-real-estate' ),
		);

		register_taxonomy(
			'property-status',
			array( 'property' ),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters( 'inspiry_property_status_labels', $status_labels ),
				'show_ui'      => true,
				'show_in_menu' => 'easy-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters( 'inspiry_property_status_slug', __( 'property-status', 'easy-real-estate' ) ),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters( 'inspiry_property_status_rest_base', __( 'property-statuses', 'easy-real-estate' ) )
			)
		);
	}
endif;


if ( ! function_exists( 'ere_set_property_city_slug' ) ) :
	/**
	 * This function set property location's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property location slug.
	 *
	 * @return string
	 */
	function ere_set_property_city_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_property_city_slug' );
		if ( ! empty( $new_slug ) ) {
			return utf8_uri_encode( $new_slug );
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_property_city_slug', 'ere_set_property_city_slug' );
	add_filter( 'inspiry_property_city_rest_base', 'ere_set_property_city_slug' );
endif;


if ( ! function_exists( 'ere_set_property_status_slug' ) ) :
	/**
	 * This function set property status's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property status slug.
	 *
	 * @return string
	 */
	function ere_set_property_status_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_property_status_slug' );
		if ( ! empty( $new_slug ) ) {
			return utf8_uri_encode( $new_slug );
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_property_status_slug', 'ere_set_property_status_slug' );
	add_filter( 'inspiry_property_status_rest_base', 'ere_set_property_status_slug' );
endif;


if ( ! function_exists( 'ere_set_property_type_slug' ) ) :
	/**
	 * This function set property type's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property type slug.
	 *
	 * @return string
	 */
	function ere_set_property_type_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_property_type_slug' );
		if ( ! empty( $new_slug ) ) {
			return utf8_uri_encode( $new_slug );
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_property_type_slug', 'ere_set_property_type_slug' );
	add_filter( 'inspiry_property_type_rest_base', 'ere_set_property_type_slug' );
endif;


if ( ! function_exists( 'ere_set_property_feature_slug' ) ) :
	/**
	 * This function set property feature's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property feature slug.
	 *
	 * @return string
	 */
	function ere_set_property_feature_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_property_feature_slug' );
		if ( ! empty( $new_slug ) ) {
			return utf8_uri_encode( $new_slug );
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_property_feature_slug', 'ere_set_property_feature_slug' );
	add_filter( 'inspiry_property_feature_rest_base', 'ere_set_property_feature_slug' );
endif;


if ( ! function_exists( 'ere_property_edit_columns' ) ) {
	/**
	 * Custom columns for properties
	 *
	 * @param array $columns - Columns array.
	 *
	 * @return array
	 */
	function ere_property_edit_columns( $columns ) {

		// Property initial columns.
		$columns = array(
			'cb'                 => '<input type="checkbox" />',
			'title'              => esc_html__( 'Property Title', 'easy-real-estate' ),
			'property-thumbnail' => esc_html__( 'Thumbnail', 'easy-real-estate' ),
			'city'               => esc_html__( 'Location', 'easy-real-estate' ),
			'type'               => esc_html__( 'Type', 'easy-real-estate' ),
			'status'             => esc_html__( 'Status', 'easy-real-estate' ),
			'price'              => esc_html__( 'Price', 'easy-real-estate' ),
			'id'                 => esc_html__( 'Property ID', 'easy-real-estate' ),
		);

		// Add property views column if property analytics are enabled.
		if ( 'enabled' === get_option( 'inspiry_property_analytics_status', false ) ) {
			$time_period = get_option( 'inspiry_property_analytics_time_period', 14 );
			$time_label  = esc_html__( 'Last 1 Week', 'easy-real-estate' );
			switch ( $time_period ) {
				case 14:
					$time_label = esc_html__( 'Last 2 Weeks', 'easy-real-estate' );
					break;
				case 30:
					$time_label = esc_html__( 'Last 30 Days', 'easy-real-estate' );
					break;
			}

			$columns['views'] = esc_html( $time_label );
		}

		// Add property published time column.
		$columns['date'] = esc_html__( 'Publish Time', 'easy-real-estate' );

		// WPML Support
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			global $sitepress;
			$wpml_columns = new WPML_Custom_Columns( $sitepress );
			$columns      = $wpml_columns->add_posts_management_column( $columns );
		}

		// Reverse the array for RTL
		if ( is_rtl() ) {
			$columns = array_reverse( $columns );
		}

		return $columns;
	}

	add_filter( 'manage_edit-property_columns', 'ere_property_edit_columns' );
}


if ( ! function_exists( 'ere_property_custom_columns' ) ) {
	/**
	 * Property custom columns
	 *
	 * @param $column
	 */
	function ere_property_custom_columns( $column ) {
		global $post;
		switch ( $column ) {
			case 'property-thumbnail':
				?>
                <div class="ere-properties-table-thumbnail-wrap">
					<?php
					if ( has_post_thumbnail( $post->ID ) ) :
						?>
                        <a href="<?php the_permalink(); ?>" target="_blank"><?php the_post_thumbnail( array(
								130,
								130
							) );
							?>
                        </a>
					<?php
					else :
						?>
                        <span class="ere-properties-table-no-thumbnail"><?php esc_html_e( 'No Thumbnail', 'easy-real-estate' ); ?></span>
					<?php
					endif;

					$is_featured = get_post_meta( $post->ID, 'REAL_HOMES_featured', true );
					if ( ! empty( $is_featured ) ) :
						?>
                        <span class="ere-featured-property"><?php esc_html_e( 'Featured', 'easy-real-estate' ); ?></span>
					<?php
					endif;
					?>
                </div>
				<?php
				break;
			case 'id':
				$Prop_id = get_post_meta( $post->ID, 'REAL_HOMES_property_id', true );
				if ( ! empty( $Prop_id ) ) {
					echo esc_html( $Prop_id );
				} else {
					_e( 'NA', 'easy-real-estate' );
				}
				break;
			case 'agent':
				$agents_id = get_post_meta( $post->ID, 'REAL_HOMES_agents' );
				if ( ! empty( $agents_id ) ) {
					$agents_title = array();
					foreach ( $agents_id as $agent_id ) {
						$agents_title[] = get_the_title( $agent_id );
					}
					echo implode( ', ', $agents_title );
				} else {
					_e( 'NA', 'easy-real-estate' );
				}
				break;
			case 'city':
				echo ere_admin_taxonomy_terms( $post->ID, 'property-city', 'property' );
				break;
			case 'address':
				$address = get_post_meta( $post->ID, 'REAL_HOMES_property_address', true );
				if ( ! empty( $address ) ) {
					echo esc_html( $address );
				} else {
					_e( 'No Address Provided!', 'easy-real-estate' );
				}
				break;
			case 'type':
				echo ere_admin_taxonomy_terms( $post->ID, 'property-type', 'property' );
				break;
			case 'status':
				echo ere_admin_taxonomy_terms( $post->ID, 'property-status', 'property' );
				break;
			case 'price':
				ere_property_price();
				break;
			case 'bed':
				$bed = get_post_meta( $post->ID, 'REAL_HOMES_property_bedrooms', true );
				if ( ! empty( $bed ) ) {
					echo esc_html( $bed );
				} else {
					_e( 'NA', 'easy-real-estate' );
				}
				break;
			case 'bath':
				$bath = get_post_meta( $post->ID, 'REAL_HOMES_property_bathrooms', true );
				if ( ! empty( $bath ) ) {
					echo esc_html( $bath );
				} else {
					_e( 'NA', 'easy-real-estate' );
				}
				break;
			case 'garage':
				$garage = get_post_meta( $post->ID, 'REAL_HOMES_property_garage', true );
				if ( ! empty( $garage ) ) {
					echo esc_html( $garage );
				} else {
					_e( 'NA', 'easy-real-estate' );
				}
				break;
			case 'features':
				echo get_the_term_list( $post->ID, 'property-feature', '', ', ', '' );
				break;
			case 'views':
				$views   = inspiry_get_property_summed_views( $post->ID );
				$views   = ( $views ) ? $views : esc_html__( 'NA', 'easy-real-estate' );
				$postfix = '';
				if ( 1 === $views ) {
					$postfix = esc_html__( ' View', 'easy-real-estate' );
				}
				if ( $views > 1 ) {
					$postfix = esc_html__( ' Views', 'easy-real-estate' );
				}
				echo esc_html( $views . $postfix );
				break;
		}
	}
	add_action( 'manage_pages_custom_column', 'ere_property_custom_columns' );
}


if ( ! function_exists( 'ere_add_payment_meta_box' ) ) {
	/**
	 * Add Metabox to Display Property Payment Information
	 */
	function ere_add_payment_meta_box() {
		if ( ( function_exists( 'rpp_is_enabled' ) && rpp_is_enabled() ) || ( function_exists( 'isp_is_enabled' ) && isp_is_enabled() ) ) {
			add_meta_box( 'payment-meta-box', esc_html__( 'Payment Information', 'easy-real-estate' ), 'ere_payment_meta_box', 'property', 'normal', 'default' );
		}
	}
	add_action( 'add_meta_boxes', 'ere_add_payment_meta_box' );
}


if ( ! function_exists( 'ere_payment_meta_box' ) ) {
	/**
	 * Payment meta box
	 *
	 * @param $post
	 */
	function ere_payment_meta_box( $post ) {

		$values        = get_post_custom( $post->ID );
		$not_available = esc_html__( 'Not Available', 'easy-real-estate' );

		$txn_id           = isset( $values['txn_id'] ) ? esc_attr( $values['txn_id'][0] ) : $not_available;
		$payment_date     = isset( $values['payment_date'] ) ? esc_attr( $values['payment_date'][0] ) : $not_available;
		$payer_email      = isset( $values['payer_email'] ) ? esc_attr( $values['payer_email'][0] ) : $not_available;
		$first_name       = isset( $values['first_name'] ) ? esc_attr( $values['first_name'][0] ) : $not_available;
		$last_name        = isset( $values['last_name'] ) ? esc_attr( $values['last_name'][0] ) : $not_available;
		$payment_status   = isset( $values['payment_status'] ) ? esc_attr( $values['payment_status'][0] ) : $not_available;
		$payment_gross    = isset( $values['payment_gross'] ) ? esc_attr( $values['payment_gross'][0] ) : $not_available;
		$payment_currency = isset( $values['mc_currency'] ) ? esc_attr( $values['mc_currency'][0] ) : $not_available;

		?>
		<table style="width:100%;">
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Transaction ID', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $txn_id ); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Payment Date', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $payment_date ); ?></td>
			</tr>
			<?php
			if ( ! isset( $values['isp_transaction'] ) ) {
				?>
				<tr>
					<td style="width:25%; vertical-align: top;">
						<strong><?php esc_html_e( 'First Name', 'easy-real-estate' ); ?></strong></td>
					<td style="width:75%;"><?php echo esc_html( $first_name ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top;">
						<strong><?php esc_html_e( 'Last Name', 'easy-real-estate' ); ?></strong></td>
					<td style="width:75%;"><?php echo esc_html( $last_name ); ?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Payer Email', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $payer_email ); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Payment Status', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $payment_status ); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Payment Amount', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $payment_gross ); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e( 'Payment Currency', 'easy-real-estate' ); ?></strong></td>
				<td style="width:75%;"><?php echo esc_html( $payment_currency ); ?></td>
			</tr>
		</table>
		<?php
	}
}


if ( ! function_exists( 'ere_admin_taxonomy_terms' ) ) {

	/**
	 * Comma separated taxonomy terms with admin side links.
	 *
	 * @param  int $post_id      - Post ID.
	 * @param  string $taxonomy  - Taxonomy name.
	 * @param  string $post_type - Post type.
	 *
	 * @return string|bool
	 * @since  1.0.0
	 */
	function ere_admin_taxonomy_terms( $post_id, $taxonomy, $post_type ) {

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) ) {
			$out = array();
			/* Loop through each term, linking to the 'edit posts' page for the specific term. */
			foreach ( $terms as $term ) {
				$out[] = sprintf(
					'<a href="%s">%s</a>',
					esc_url(
						add_query_arg(
							array(
								'post_type' => $post_type,
								$taxonomy   => $term->slug,
							), 'edit.php'
						)
					),
					esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'display' ) )
				);
			}

			/* Join the terms, separating them with a comma. */

			return join( ', ', $out );
		}

		return false;
	}
}

if ( ! function_exists( 'ere_properties_filter_fields_admin' ) ) {
	/**
	 * Add custom filter fields for properties on admin
	 */
	function ere_properties_filter_fields_admin() {

		global $post_type;
		if ( $post_type == 'property' ) {

			// Property Location Dropdown Option
			$prop_city_args = array(
				'show_option_all' => esc_html__( 'All Property Locations', 'easy-real-estate' ),
				'orderby'         => 'NAME',
				'order'           => 'ASC',
				'name'            => 'property_city_admin_filter',
				'taxonomy'        => 'property-city'
			);
			if ( isset( $_GET['property_city_admin_filter'] ) ) {
				$prop_city_args['selected'] = sanitize_text_field( $_GET['property_city_admin_filter'] );
			}
			wp_dropdown_categories( $prop_city_args );

			// Property Type Dropdown Option
			$prop_type_args = array(
				'show_option_all' => esc_html__( 'All Property Types', 'easy-real-estate' ),
				'orderby'         => 'NAME',
				'order'           => 'ASC',
				'name'            => 'property_type_admin_filter',
				'taxonomy'        => 'property-type'
			);
			if ( isset( $_GET['property_type_admin_filter'] ) ) {
				$prop_type_args['selected'] = sanitize_text_field( $_GET['property_type_admin_filter'] );
			}
			wp_dropdown_categories( $prop_type_args );

			// Property Status Dropdown Option
			$prop_status_args = array(
				'show_option_all' => esc_html__( 'All Property Statuses', 'easy-real-estate' ),
				'orderby'         => 'NAME',
				'order'           => 'ASC',
				'name'            => 'property_status_admin_filter',
				'taxonomy'        => 'property-status'
			);
			if ( isset( $_GET['property_status_admin_filter'] ) ) {
				$prop_status_args['selected'] = sanitize_text_field( $_GET['property_status_admin_filter'] );
			}
			wp_dropdown_categories( $prop_status_args );

			// User Dropdown Option
			$user_args = array(
				'show_option_all'  => esc_html__( 'All Users', 'easy-real-estate' ),
				'orderby'          => 'display_name',
				'order'            => 'ASC',
				'name'             => 'author_admin_filter',
				'who'              => 'authors',
				'include_selected' => true
			);
			if ( isset( $_GET['author_admin_filter'] ) ) {
				$user_args['selected'] = (int) sanitize_text_field( $_GET['author_admin_filter'] );
			}
			wp_dropdown_users( $user_args );

			// Property ID Input Option
			$value_escaped = '';
			if ( isset( $_GET['prop_id_admin_filter'] ) && ! empty( $_GET['prop_id_admin_filter'] ) ) {
				$value_escaped = esc_attr( $_GET['prop_id_admin_filter'] );
			}
			?>
            <input id="prop_id_admin_filter" type="text" name="prop_id_admin_filter" placeholder="<?php esc_html_e( 'Property ID', 'easy-real-estate' ); ?>" value="<?php echo $value_escaped; ?>">
			<?php
		}
	}

	add_action( 'restrict_manage_posts', 'ere_properties_filter_fields_admin' );
}

if ( ! function_exists( 'ere_properties_filter_admin' ) ) {
	/**
	 * Restrict the properties by the chosen filters
	 *
	 * @param $query
	 */
	function ere_properties_filter_admin( $query ) {

		global $post_type, $pagenow;

		//if we are currently on the edit screen of the property post-type listings
		if ( $pagenow == 'edit.php' && $post_type == 'property' ) {

			$tax_query  = array();
			$meta_query = array();

			// Property ID Filter
			if ( isset( $_GET['prop_id_admin_filter'] ) && ! empty( $_GET['prop_id_admin_filter'] ) ) {

				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_id',
					'value'   => sanitize_text_field( $_GET['prop_id_admin_filter'] ),
					'compare' => 'LIKE',
				);

			}

			// Property Status Filter
			if ( isset( $_GET['property_status_admin_filter'] ) && ! empty( $_GET['property_status_admin_filter'] ) ) {

				//get the desired property status
				$property_status = sanitize_text_field( $_GET['property_status_admin_filter'] );

				//if the property status is not 0 (which means all)
				if ( $property_status != 0 ) {
					$tax_query[] = array(
						'taxonomy' => 'property-status',
						'field'    => 'ID',
						'terms'    => array( $property_status )
					);
				}
			}

			// Property Type Filter
			if ( isset( $_GET['property_type_admin_filter'] ) && ! empty( $_GET['property_type_admin_filter'] ) ) {

				//get the desired property type
				$property_type = sanitize_text_field( $_GET['property_type_admin_filter'] );

				//if the property type is not 0 (which means all)
				if ( $property_type != 0 ) {

					$tax_query[] = array(
						'taxonomy' => 'property-type',
						'field'    => 'ID',
						'terms'    => array( $property_type )
					);

				}
			}

			// Property Location Filter
			if ( isset( $_GET['property_city_admin_filter'] ) && ! empty( $_GET['property_city_admin_filter'] ) ) {

				//get the desired property location
				$property_city = sanitize_text_field( $_GET['property_city_admin_filter'] );

				//if the property location is not 0 (which means all)
				if ( $property_city != 0 ) {
					$tax_query[] = array(
						'taxonomy' => 'property-city',
						'field'    => 'ID',
						'terms'    => array( $property_city )
					);

				}
			}

			// Property Author Filter
			if ( isset( $_GET['author_admin_filter'] ) && ! empty( $_GET['author_admin_filter'] ) ) {

				//set the query variable for 'author' to the desired value
				$author_id = sanitize_text_field( $_GET['author_admin_filter'] );

				//if the author is not 0 (meaning all)
				if ( $author_id != 0 ) {
					$query->query_vars['author'] = $author_id;
				}

			}

			if ( ! empty( $meta_query ) ) {
				$query->query_vars['meta_query'] = $meta_query;

			}

			if ( ! empty( $tax_query ) ) {
				$query->query_vars['tax_query'] = $tax_query;
			}
		}
	}

	add_action( 'pre_get_posts', 'ere_properties_filter_admin' );
}

if ( ! function_exists( 'ere_sortable_price_column' ) ) {
	/**
     * Make property price column sortable
     *
	 * @param $columns
	 *
	 * @return mixed
	 */
	function ere_sortable_price_column( $columns ) {
		$columns['price'] = 'price';

		return $columns;
	}

	add_filter( 'manage_edit-property_sortable_columns', 'ere_sortable_price_column' );
}

if ( ! function_exists( 'ere_price_orderby' ) ) {
	/**
	 * Sort properties based on price
	 *
	 * @param $query
	 */
	function ere_price_orderby( $query ) {
		global $post_type, $pagenow;

		//if we are currently on the edit screen of the property post-type listings
		if ( $pagenow == 'edit.php' && $post_type == 'property' ) {
			$orderby = $query->get( 'orderby' );
			if ( 'price' == $orderby ) {
				$query->set( 'meta_key', 'REAL_HOMES_property_price' );
				$query->set( 'orderby', 'meta_value_num' );
			}
		}
	}

	add_action( 'pre_get_posts', 'ere_price_orderby' );
}
