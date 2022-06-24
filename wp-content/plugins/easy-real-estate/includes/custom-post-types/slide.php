<?php
/**
 * Slide Custom Post Type
 */

if ( ! function_exists( 'ere_register_slide_post_type' ) ) {

	function ere_register_slide_post_type() {

		$slide_post_type_labels = array(
			'name'               => esc_html__( 'Slides', 'easy-real-estate' ),
			'singular_name'      => esc_html__( 'Slide', 'easy-real-estate' ),
			'add_new'            => esc_html__( 'Add New', 'easy-real-estate' ),
			'add_new_item'       => esc_html__( 'Add New Slide', 'easy-real-estate' ),
			'edit_item'          => esc_html__( 'Edit Slide', 'easy-real-estate' ),
			'new_item'           => esc_html__( 'New Slide', 'easy-real-estate' ),
			'view_item'          => esc_html__( 'View Slide', 'easy-real-estate' ),
			'search_items'       => esc_html__( 'Search Slide', 'easy-real-estate' ),
			'not_found'          => esc_html__( 'No Slide found', 'easy-real-estate' ),
			'not_found_in_trash' => esc_html__( 'No Slide found in Trash', 'easy-real-estate' ),
			'parent_item_colon'  => '',
		);

		$slide_post_type_args = array(
			'labels'              => apply_filters( 'inspiry_slide_post_type_labels', $slide_post_type_labels ),
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'query_var'           => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-images-alt',
			'menu_position'       => 5,
			'supports'            => array( 'title', 'thumbnail' ),
		);

		// Filter the arguments to register slide post type.
		$slide_post_type_args = apply_filters( 'inspiry_slide_post_type_args', $slide_post_type_args );
		register_post_type( 'slide', $slide_post_type_args );

	}

	add_action( 'init', 'ere_register_slide_post_type' );

}


if ( ! function_exists( 'ere_slide_edit_columns' ) ) {

	/**
	 * Add Custom Columns.
	 *
	 * @param  array $columns - Array of columns.
	 *
	 * @return array
	 */
	function ere_slide_edit_columns( $columns ) {
		$columns = array(
			'cb'             => '<input type="checkbox" >',
			'title'          => esc_html__( 'Slide Title', 'easy-real-estate' ),
			'slide_thumb'    => esc_html__( 'Thumbnail', 'easy-real-estate' ),
			'slide_sub_text' => esc_html__( 'Slide Sub Text', 'easy-real-estate' ),
			'date'           => esc_html__( 'Date', 'easy-real-estate' ),
		);

		return $columns;
	}

	add_filter( 'manage_edit-slide_columns', 'ere_slide_edit_columns' );
}


if ( ! function_exists( 'ere_slide_custom_columns' ) ) {

	/**
	 * Content for Custom Columns.
	 *
	 * @param  array $column - Content of columns.
	 */
	function ere_slide_custom_columns( $column ) {
		global $post;
		switch ( $column ) {
			case 'slide_thumb':
				if ( has_post_thumbnail( $post->ID ) ) {
					the_post_thumbnail( 'post-thumbnail' );
				} else {
					esc_html_e( 'No Slider Image', 'easy-real-estate' );
				}
				break;
			case 'slide_sub_text':
				$slide_sub_text = get_post_meta( $post->ID, 'slide_sub_text', true );
				if ( ! empty( $slide_sub_text ) ) {
					echo esc_html( $slide_sub_text );
				} else {
					esc_html_e( 'NA', 'easy-real-estate' );
				}
				break;
		}
	}

	add_action( 'manage_posts_custom_column', 'ere_slide_custom_columns' );
}


if ( ! function_exists( 'ere_slide_meta_box_add' ) ) {
	/**
	 * Add Metabox to Slide
	 */
	function ere_slide_meta_box_add() {
		add_meta_box( 'slide-meta-box', esc_html__( 'Slide Information', 'easy-real-estate' ), 'ere_slide_meta_box', 'slide', 'normal', 'high' );
	}

	add_action( 'add_meta_boxes', 'ere_slide_meta_box_add' );
}


if ( ! function_exists( 'ere_slide_meta_box' ) ) {
	function ere_slide_meta_box( $post ) {
		$values = get_post_custom( $post->ID );

		$slide_sub_text = isset( $values[ 'slide_sub_text' ] ) ? esc_attr( $values[ 'slide_sub_text' ][ 0 ] ) : '';
		$slide_url      = isset( $values[ 'slide_url' ] ) ? esc_attr( $values[ 'slide_url' ][ 0 ] ) : '';

		wp_nonce_field( 'slide_meta_box_nonce', 'meta_box_nonce_slide' );
		?>
		<table style="width:100%;">
			<tr>
				<td style="width:25%; vertical-align: top;">
					<label for="slide_sub_text"><strong><?php esc_html_e( 'Sub Text', 'easy-real-estate' ); ?></strong></label>
				</td>
				<td style="width:75%;">
					<textarea name="slide_sub_text" id="slide_sub_text" cols="30" rows="3" style="width:60%; margin-right:4%;"><?php echo esc_textarea( $slide_sub_text ); ?></textarea>
					<span style="color:#999; display:block;"><?php esc_html_e( 'This text will appear below Title on slide.', 'easy-real-estate' ); ?></span>
				</td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align:top;">
					<label for="slide_url"><strong><?php esc_html_e( 'Target URL', 'easy-real-estate' ); ?></strong></label>
				</td>
				<td style="width:75%; ">
					<input type="text" name="slide_url" id="slide_url" value="<?php echo esc_url( $slide_url ); ?>" style="width:60%; margin-right:4%;"/>
					<span style="color:#999; display:block;  margin-bottom:10px;"><?php esc_html_e( 'This URL will be applied on Slide Image.', 'easy-real-estate' ); ?></span>
				</td>
			</tr>
		</table>
		<?php
	}
}


if ( ! function_exists( 'ere_slide_meta_box_save' ) ) {
	function ere_slide_meta_box_save( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST[ 'meta_box_nonce_slide' ] ) || ! wp_verify_nonce( $_POST[ 'meta_box_nonce_slide' ], 'slide_meta_box_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post' ) ) {
			return;
		}

		if ( isset( $_POST[ 'slide_sub_text' ] ) ) {
			update_post_meta( $post_id, 'slide_sub_text', $_POST[ 'slide_sub_text' ] );
		}

		if ( isset( $_POST[ 'slide_url' ] ) ) {
			update_post_meta( $post_id, 'slide_url', $_POST[ 'slide_url' ] );
		}

	}

	add_action( 'save_post', 'ere_slide_meta_box_save' );
}
