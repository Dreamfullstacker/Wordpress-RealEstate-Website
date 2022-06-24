<?php
/**
 * This class is responsible for the Invoice post type and related stuff.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! class_exists( 'RVR_Invoice' ) ) {
	/**
	 * Class RVR_Invoice
	 *
	 * Responsible for all stuff related to Invoice Post Type.
	 *
	 * @package    realhomes_vacation_rentals
     * @subpackage realhomes_vacation_rentals/admin
	 */
	class RVR_Invoice {

		/**
		 * Register invoice custom post type
		 */
		public function rvr_invoice_post_type() {

			// Add 'invoice' post type only if WooCommerce payments are enabled.
			if ( ! rvr_is_wc_payment_enabled() ) {
				return;
			}

			$labels = array(
				'name'                  => esc_html_x( 'Invoices', 'Post Type General Name', 'realhomes-vacation-rentals' ),
				'singular_name'         => esc_html_x( 'Invoice', 'Post Type Singular Name', 'realhomes-vacation-rentals' ),
				'menu_name'             => esc_html__( 'Invoices', 'realhomes-vacation-rentals' ),
				'name_admin_bar'        => esc_html__( 'Invoice', 'realhomes-vacation-rentals' ),
				'archives'              => esc_html__( 'Invoice Archives', 'realhomes-vacation-rentals' ),
				'attributes'            => esc_html__( 'Invoice Attributes', 'realhomes-vacation-rentals' ),
				'parent_item_colon'     => esc_html__( 'Parent Invoice:', 'realhomes-vacation-rentals' ),
				'all_items'             => esc_html__( 'All Invoices', 'realhomes-vacation-rentals' ),
				'add_new_item'          => esc_html__( 'Add New Invoice', 'realhomes-vacation-rentals' ),
				'add_new'               => esc_html__( 'Add New', 'realhomes-vacation-rentals' ),
				'new_item'              => esc_html__( 'New Invoice', 'realhomes-vacation-rentals' ),
				'edit_item'             => esc_html__( 'Edit Invoice', 'realhomes-vacation-rentals' ),
				'update_item'           => esc_html__( 'Update Invoice', 'realhomes-vacation-rentals' ),
				'view_item'             => esc_html__( 'View Invoice', 'realhomes-vacation-rentals' ),
				'view_items'            => esc_html__( 'View Invoices', 'realhomes-vacation-rentals' ),
				'search_items'          => esc_html__( 'Search Invoice', 'realhomes-vacation-rentals' ),
				'not_found'             => esc_html__( 'Not found', 'realhomes-vacation-rentals' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'realhomes-vacation-rentals' ),
				'featured_image'        => esc_html__( 'Featured Image', 'realhomes-vacation-rentals' ),
				'set_featured_image'    => esc_html__( 'Set featured image', 'realhomes-vacation-rentals' ),
				'remove_featured_image' => esc_html__( 'Remove featured image', 'realhomes-vacation-rentals' ),
				'use_featured_image'    => esc_html__( 'Use as featured image', 'realhomes-vacation-rentals' ),
				'insert_into_item'      => esc_html__( 'Insert into invoice', 'realhomes-vacation-rentals' ),
				'uploaded_to_this_item' => esc_html__( 'Uploaded to this invoice', 'realhomes-vacation-rentals' ),
				'items_list'            => esc_html__( 'Invoices list', 'realhomes-vacation-rentals' ),
				'items_list_navigation' => esc_html__( 'Invoices list navigation', 'realhomes-vacation-rentals' ),
				'filter_items_list'     => esc_html__( 'Filter invoices list', 'realhomes-vacation-rentals' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Invoice', 'realhomes-vacation-rentals' ),
				'description'         => esc_html__( 'Invoices of property bookings.', 'realhomes-vacation-rentals' ),
				'labels'              => $labels,
				'supports'            => array( 'title' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => 'rvr',
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-printer',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => false,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
				),

				// Disabled REST API Support for Invoices
				//'show_in_rest'        => true,
				//'rest_base'           => apply_filters( 'rvr_invoice_rest_base', esc_html__( 'invoices', 'realhomes-vacation-rentals' ) )
			);
			register_post_type( 'invoice', $args );

		}

		/**
		 * Replace "Enter Title Here" placeholder text.
		 *
		 * @param string $title Default title text.
		 *
		 * @return string
		 */
		public function invoice_title_text( $title ) {
			$screen = get_current_screen();

			if ( 'invoice' === $screen->post_type ) {
				$title = esc_html__( 'Enter invoice ID here', 'realhomes-vacation-rentals' );
			}

			return $title;
		}

		/**
		 * Add Metabox to Display Invoice Payment Information
		 */
		public function add_invoice_payment_metabox() {
			add_meta_box( 'invoice-payment-metabox', esc_html__( 'Invoice Information', 'realhomes-vacation-rentals' ), array( $this, 'invoice_payment_metabox' ), 'invoice', 'normal', 'default' );
		}

		/**
		 * Invoice Payment Metabox.
		 *
		 * @param object $post Current invoice post.
		 */
		public function invoice_payment_metabox( $post ) {

			$values        = get_post_custom( $post->ID );
			$not_available = esc_html__( 'Not Available', 'realhomes-vacation-rentals' );

			$transaction_id  = isset( $values['transaction_id'] ) ? esc_attr( $values['transaction_id'][0] ) : $not_available;
			$payment_date    = isset( $values['payment_date'] ) ? esc_attr( $values['payment_date'][0] ) : $not_available;
			$payment_method  = isset( $values['payment_method'] ) ? esc_attr( $values['payment_method'][0] ) : $not_available;
			$payer_email     = isset( $values['payer_email'] ) ? esc_attr( $values['payer_email'][0] ) : $not_available;
			$first_name      = isset( $values['first_name'] ) ? esc_attr( $values['first_name'][0] ) : $not_available;
			$last_name       = isset( $values['last_name'] ) ? esc_attr( $values['last_name'][0] ) : $not_available;
			$payment_status  = isset( $values['payment_status'] ) ? esc_attr( $values['payment_status'][0] ) : $not_available;
			$payment_amount  = isset( $values['payment_amount'] ) ? esc_attr( $values['payment_amount'][0] ) : $not_available;
			$amount_currency = isset( $values['amount_currency'] ) ? esc_attr( $values['amount_currency'][0] ) : $not_available;
			$booking_id      = $values['booking_id'][0];
			if ( ! empty( $booking_id ) ) {
				$booking_info = '<a href="' . get_edit_post_link( $booking_id ) . '">' . get_the_title( $booking_id ) . '</a>';
			} else {
				$booking_info = $not_available;
			}
			?>
			<table style="width:100%;">
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payer First Name', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $first_name ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payer Last Name', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $last_name ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payer Email', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $payer_email ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payment Method', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( ucfirst( $payment_method ) ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Transaction ID', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $transaction_id ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payment Date', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $payment_date ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Amount', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $payment_amount ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Currency', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $amount_currency ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Payment Status', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo esc_html( $payment_status ); ?></td>
				</tr>
				<tr>
					<td style="width:25%; vertical-align: top; border: 1px solid #e1e1e3; padding: 10px;">
						<strong><?php esc_html_e( 'Booking ID', 'realhomes-vacation-rentals' ); ?></strong></td>
					<td style="width:75%; border: 1px solid #e1e1e3; padding: 10px;"><?php echo $booking_info; ?></td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Custom columns for invoices.
		 *
		 * @param array $columns Default columns.
		 *
		 * @return array
		 */
		public function invoice_edit_columns( $columns ) {

			$columns = array(
				'cb'           => '<input type="checkbox" />',
				'title'        => esc_html__( 'Invoice ID', 'realhomes-vacation-rentals' ),
				'booking'      => esc_html__( 'Booking ID', 'realhomes-vacation-rentals' ),
				'payer'        => esc_html__( 'Payer', 'realhomes-vacation-rentals' ),
				'payer_email'  => esc_html__( 'Payer Email', 'realhomes-vacation-rentals' ),
				'amount'       => esc_html__( 'Amount', 'realhomes-vacation-rentals' ),
				'currency'     => esc_html__( 'Currency', 'realhomes-vacation-rentals' ),
				'method'       => esc_html__( 'Method', 'realhomes-vacation-rentals' ),
				'payment_date' => esc_html__( 'Payment Time', 'realhomes-vacation-rentals' ),
			);

			/**
			 * WPML Support.
			 */
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				global $sitepress;
				$wpml_columns = new WPML_Custom_Columns( $sitepress );
				$columns      = $wpml_columns->add_posts_management_column( $columns );
			}

			/**
			 * Reverse the array for RTL
			 */
			if ( is_rtl() ) {
				$columns = array_reverse( $columns );
			}

			return $columns;
		}

		/**
		 * Setting invoice columns values.
		 *
		 * @param string $column_name Name of the current column.
		 */
		public function invoice_columns_values( $column_name ) {

			global $post, $post_type, $pagenow;

			if ( 'edit.php' === $pagenow && 'invoice' === $post_type ) {

				$meta_data         = get_post_custom( $post->ID );

				switch ( $column_name ) {

					case 'booking':
						echo ( ! empty( $meta_data['booking_id'] ) ) ? $meta_data['booking_id'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'payer':
						echo get_avatar( $meta_data['payer_email'][0], 64 ) . '<br>';
						echo ( ! empty( $meta_data['first_name'] ) ) ? $meta_data['first_name'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						echo ( ! empty( $meta_data['last_name'] ) ) ? ' ' . $meta_data['last_name'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'payer_email':
						echo ( ! empty( $meta_data['payer_email'] ) ) ? $meta_data['payer_email'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'amount':
						echo ( ! empty( $meta_data['payment_amount'] ) ) ? $meta_data['payment_amount'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'currency':
						echo ( ! empty( $meta_data['amount_currency'] ) ) ? ' ' . $meta_data['amount_currency'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'method':
						echo ( ! empty( $meta_data['payment_method'] ) ) ? ucfirst( $meta_data['payment_method'][0] ) : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'payment_date':
						the_date( 'Y/m/d' );
						echo '<br>';
						the_time( 'g:i a' );
						break;

					default:
						break;
				}
			}
		}
	}
}
