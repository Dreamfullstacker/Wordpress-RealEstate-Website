<?php

if ( ! class_exists( 'RECRM_custom_columns' ) ) {

	/**
	 * Class for adding custom columns in contact/enquiry custom post types
	 */
	class RECRM_custom_columns {

		public function __construct() {
			add_action( 'restrict_manage_posts', array( $this, 'filter_contacts_by_taxonomies' ) );
			add_action( 'manage_edit-contact_columns', array( $this, 'custom_columns_contacts' ) );
			add_action( 'manage_edit-enquiry_columns', array( $this, 'custom_columns_enquiry' ), 10, 2 );
			add_action( 'manage_posts_custom_column', array( $this, 'custom_columns_contacts_values' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'custom_columns_enquiry_values' ), 10, 2 );

			add_filter( 'manage_edit-contact_sortable_columns', array(
				$this,
				'contact_custom_column_sorting_meta_key_based'
			) );
			add_action( 'pre_get_posts', array( $this, 'contact_custom_column_sorting_order' ) );

			add_filter( 'manage_edit-enquiry_sortable_columns', array(
				$this,
				'enquiry_custom_column_sorting_meta_key_based'
			) );
			add_action( 'pre_get_posts', array( $this, 'enquiry_custom_column_sorting_order' ) );
		}


		public function custom_columns_contacts() {


			// Columns names and arrangements for contact post type
			$defaults = array(
				'cb'                  => '<input type="checkbox" disabled>',
				'contact_id'          => esc_html__( 'Contact ID', 'real-estate-crm' ),
				'contact_name'        => esc_html__( 'Name', 'real-estate-crm' ),
				'contact_thumbnail'   => esc_html__( 'Photo', 'real-estate-crm' ),
				'contact_email_phone' => esc_html__( 'Contact Details', 'real-estate-crm' ),
				'contact_status'      => esc_html__( 'Status', 'real-estate-crm' ),
				'contact_tags'        => esc_html__( 'Tags', 'real-estate-crm' ),
				'date'                => esc_html__( 'Date', 'real-estate-crm' ),
			);

			$defaults = apply_filters( 'recrm_custom_columns_contacts_filter', $defaults );

			return $defaults;

		}

		public function contact_custom_column_sorting_meta_key_based( $columns ) {
			$columns['contact_status'] = 'contact_status';

			return $columns;
		}

		public function contact_custom_column_sorting_order( $query ) {
			if ( ! is_admin() ) {
				return;
			}

			$orderby = $query->get( 'orderby' );

			if ( 'contact_status' == $orderby ) {
				$query->set( 'meta_key', 'recrm_contact_status' );
				$query->set( 'orderby', 'meta_value' );
			}
		}


		public function custom_columns_contacts_values( $key ) {

			//Values to contact post type custom columns
			$value = get_post_custom( get_the_ID() );

			$not_available = apply_filters( 'recrm_contact_columns_not_available_filters', '-' );

			switch ( $key ) {

				case 'contact_id':
					echo '<a href="' . esc_url( admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ) ) . '">' . get_the_ID() . '</a>';
					break;

				case 'contact_name':
					echo '<a href="' . esc_url( admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ) ) . '">' . get_the_title() . '</a>';
					break;

				case 'contact_email_phone':
					if (
						! empty( $value['recrm_contact_email'] ) ||
						! empty( $value['recrm_contact_mobile'] ) ||
						! empty( $value['recrm_contact_work_phone'] ) ||
						! empty( $value['recrm_contact_home_phone'] )
					) {
						if ( ! empty( $value['recrm_contact_email'] ) ) {
							echo sprintf( esc_html__( 'Email: %1$s %2$s', 'real-estate-crm' ), $value['recrm_contact_email'][0], "<br>" );
						}
						if ( ! empty( $value['recrm_contact_work_phone'] ) ) {
							echo sprintf( esc_html__( 'Work: %1$s %2$s', 'real-estate-crm' ), $value['recrm_contact_work_phone'][0], "<br>" );
						}
						if ( ! empty( $value['recrm_contact_home_phone'] ) ) {
							echo sprintf( esc_html__( 'Home: %1$s %2$s', 'real-estate-crm' ), $value['recrm_contact_home_phone'][0], "<br>" );
						}
						if ( ! empty( $value['recrm_contact_mobile'] ) ) {
							echo sprintf( esc_html__( 'Mobile: %1$s %2$s', 'real-estate-crm' ), $value['recrm_contact_mobile'][0], "<br>" );
						}

					} else {
						echo $not_available;
					}
					break;

				case 'contact_status':
					if ( ! empty( $value['recrm_contact_status'] ) ) {
						echo esc_html( $value['recrm_contact_status'][0] );

					} else {
						echo $not_available;
					}
					break;

				case 'contact_thumbnail':
					$contact_id = get_the_ID();
					if ( has_post_thumbnail( $contact_id ) ) {
						echo get_the_post_thumbnail( $contact_id, array( 64, 64 ) );
					} else {
						if ( isset( $value['recrm_contact_email'] ) && isset( $value['recrm_contact_email'][0] ) ) {
							echo get_avatar( $value['recrm_contact_email'][0], 64 );
						} else {
							echo get_avatar( 'empty@email.com', 64 );
						}
					}
					break;

				case'contact_tags':
					$post_type = get_post_type( get_the_ID() );
					$term_list = wp_get_post_terms( get_the_ID(), 'contact-tags', array( "fields" => "all" ) );
					if ( $term_list ) {
						$counter = 1;
						foreach ( $term_list as $term ) {
							if ( $counter > 1 ) {
								echo ',';
							}
							echo '<a href="' . admin_url( 'edit.php?post_type=' . $post_type ) . '&contact-tags=' . $term->slug . '" > ' . esc_html( $term->name ) . ' </a>';
							$counter ++;
						}
					} else {
						echo $not_available;
					}
					break;


				default:
					break;
			}
		}


		function filter_contacts_by_taxonomies( $post_type ) {

			// Filter to sort contacts by Tags
			if ( 'contact' !== $post_type ) {
				return;
			}

			// A list of taxonomy slugs to filter by
			$taxonomies = array( 'contact-tags' );

			if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy_slug ) {

					// Retrieve taxonomy data
					$taxonomy_obj  = get_taxonomy( $taxonomy_slug );
					$taxonomy_name = $taxonomy_obj->labels->name;

					// Retrieve taxonomy terms
					$terms = get_terms( $taxonomy_slug );

					// Display filter HTML
					echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
					echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'real-estate-crm' ), $taxonomy_name ) . '</option>';
					foreach ( $terms as $term ) {
						printf(
							'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
							$term->slug,
							( ( isset( $_GET[ $taxonomy_slug ] ) && ( $_GET[ $taxonomy_slug ] == $term->slug ) ) ? ' selected="selected"' : '' ),
							$term->name,
							$term->count
						);
					}
					echo '</select>';
				}
			}

		}


		public function the_excerpt_max_charlength( $charlength = 75 ) {

			$post_excerpt = apply_filters( 'recrm_custom_columns_max_post_excerpt_filters', __( '...', 'real-estate-crm' ) );

			$excerpt = get_the_excerpt();
			$charlength ++;

			if ( mb_strlen( $excerpt ) > $charlength ) {
				$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
				$exwords = explode( ' ', $subex );
				$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
				if ( $excut < 0 ) {
					echo mb_substr( $subex, 0, $excut );
				} else {
					echo $subex;
				}
				echo $post_excerpt;
			} else {
				echo $excerpt;
			}
		}


		public function custom_columns_enquiry() {

			$defaults = array(
				'cb'                 => '<input type="checkbox" disabled>',
				'enquiry_id'         => esc_html__( 'Enquiry ID', 'real-estate-crm' ),
				'enquiry_from'       => esc_html__( 'From', 'real-estate-crm' ),
				'enquiry_thumbnail'  => esc_html__( 'Thumbnail', 'real-estate-crm' ),
				'enquiry_excerpt'    => esc_html__( 'Excerpt', 'real-estate-crm' ),
				'enquiry_status'     => esc_html__( 'Status', 'real-estate-crm' ),
				'enquiry_negotiator' => esc_html__( 'Negotiator', 'real-estate-crm' ),
				'enquiry_source'     => esc_html__( 'Source', 'real-estate-crm' ),
				'enquiry_date_time'  => esc_html__( 'Date & Time', 'real-estate-crm' ),
			);

			$defaults = apply_filters( 'recrm_custom_columns_enquiry_filters', $defaults );

			return $defaults;

		}

		public function enquiry_custom_column_sorting_meta_key_based( $columns ) {
			$columns['enquiry_from']   = 'enquiry_from';
			$columns['enquiry_status'] = 'enquiry_status';

			return $columns;
		}

		public function enquiry_custom_column_sorting_order( $query ) {
			if ( ! is_admin() ) {
				return;
			}

			$orderby = $query->get( 'orderby' );

			if ( 'enquiry_status' == $orderby ) {
				$query->set( 'meta_key', 'recrm_enquiry_status' );
				$query->set( 'orderby', 'meta_value' );
			}
			if ( 'enquiry_from' == $orderby ) {
				$query->set( 'meta_key', 'recrm_enquiry_name' );
				$query->set( 'orderby', 'meta_value' );
			}
		}


		public function custom_columns_enquiry_values( $key ) {

			$not_available = apply_filters( 'recrm_enquiry_columns_not_available_filters', '-' );
			$value         = get_post_custom( get_the_ID() );

			switch ( $key ) {

				case 'enquiry_id':
					echo '<a href="' . esc_url( admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ) ) . '">' . get_the_ID() . '</a>';
					break;

				case 'enquiry_excerpt':
					$filter_for_max_length = apply_filters( 'recrm_custom_column_max_length_excerpt', 75 );
					$this->the_excerpt_max_charlength( $filter_for_max_length );
					break;

				case 'enquiry_from':
					if ( ! empty( $value['recrm_enquiry_name'] ) ) {
						echo '<a href="' . esc_url( admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ) ) . '">' . esc_html( $value['recrm_enquiry_name'][0] ) . '</a>';
					} else {
						echo $not_available;
					}
					break;

				case 'enquiry_status':
					if ( ! empty( $value['recrm_enquiry_status'] ) ) {
						echo esc_html( $value['recrm_enquiry_status'][0] );
					} else {
						echo $not_available;
					}
					break;


				case 'enquiry_source':
					if ( ! empty( $value['recrm_enquiry_source'] ) ) {
						echo esc_html( $value['recrm_enquiry_source'][0] );
					} else {
						echo $not_available;
					}
					break;

				case 'enquiry_negotiator':

					if ( ! empty( $value['recrm_enquiry_negotiator'] ) && $value['recrm_enquiry_negotiator'][0] != 'None' ) {
						echo esc_html( $value['recrm_enquiry_negotiator'][0] );
					} elseif ( ! empty( $value['recrm_enquiry_agent_id'][0] ) ) {
						echo get_the_title( $value['recrm_enquiry_agent_id'][0] );
					} elseif ( ! empty( $value['recrm_enquiry_author_id'][0] ) ) {
						echo get_the_author_meta( 'display_name', $value['recrm_enquiry_author_id'][0] );
					}elseif(!empty($value['recrm_acf_agent_name'][0])){
						echo esc_html($value['recrm_acf_agent_name'][0]);
					} else {
						echo $not_available;
					}
					break;

				case 'enquiry_date_time':
					echo get_the_date();
					echo '<br>';
					echo get_the_time();
					break;

				case 'enquiry_thumbnail':
					$contact_enquiry_id = null;
					if ( isset( $value['recrm_contact_enquiry_id'] ) && isset( $value['recrm_contact_enquiry_id'][0] ) ) {

						$contact_enquiry_id = $value['recrm_contact_enquiry_id'][0];
						if ( has_post_thumbnail( $contact_enquiry_id ) ) {
							echo get_the_post_thumbnail( $contact_enquiry_id, array( 64, 64 ) );
						} else {
							$contact_enquiry_id = null;
						}
					}

					if ( empty( $contact_enquiry_id ) ) {
						if ( isset( $value['recrm_enquiry_email'] ) && isset( $value['recrm_enquiry_email'][0] ) ) {
							echo get_avatar( $value['recrm_enquiry_email'][0], 64 );
						} else {
							echo get_avatar( 'empty@email.com', 64 );
						}
					}
					break;

				default:
					break;
			}
		}

	}

	new RECRM_custom_columns();
}

