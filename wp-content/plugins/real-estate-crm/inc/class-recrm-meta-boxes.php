<?php

if ( ! class_exists( 'RECRM_meta_boxes' ) ) {

	/**
	 * Custom Meta boxes for contact/enquiry post types
	 */
	class RECRM_meta_boxes {


		public function __construct() {

			add_action( 'post_edit_form_tag', array( $this, 'allow_files_upload' ) );
			add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ) );
			if ( is_admin() ) {
				add_action( 'load-post.php', array( $this, 'init_metabox' ) );
				add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
			}
			add_action( 'wp_ajax_recrm_save_communication', array( $this, 'save_communication' ) );
			add_action( 'wp_ajax_recrm_remove_note', array( $this, 'remove_note' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_ajax_script_with_localize' ) );


		}


		public function init_metabox() {

			add_action( 'add_meta_boxes', array( $this, 'add_contact_metabox' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_enquiry_metabox' ) );
			add_action( 'save_post', array( $this, 'save_contact_metabox' ), 10, 2 );
			add_action( 'save_post', array( $this, 'save_enquiry_metabox' ), 10, 2 );

		}


		public function enqueue_ajax_script_with_localize() {

			wp_enqueue_script( 'recrm-ajax-scripts', plugins_url( 'js/recrm-ajax.js', dirname( __FILE__ ) ), 'jquery', RECRM_Real_Estate_CRM::$version, true );

			$locals = array(
				'security'        => wp_create_nonce( 'custom_nonce_communication' ),
				'security_delete' => wp_create_nonce( 'custom_nonce_delete' ),
				'added_by'        => esc_html__( 'Just added a note', 'real-estate-crm' ),
				'delete'          => esc_html__( 'x', 'real-estate-crm' ),
				'Error'           => esc_html__( 'An Error Occurred' ),
				'just'            => esc_html__( ' - Just Added' ),
			);

			$locals = apply_filters( 'recrm_ajax_script_localized_filter', $locals );

			wp_localize_script( 'recrm-ajax-scripts', 'RECRM_ajax_handle', $locals );

		}


		public function add_contact_metabox() {

			$metabox_title = apply_filters( 'recrm_contact_details_meta_box_title_filter', esc_html__( 'Contact Details', 'real-estate-crm' ) );

			add_meta_box(
				'recrm-contact-detail-metabox',
				$metabox_title,
				array( $this, 'render_contact_metabox_fields' ),
				'contact',
				'normal',
				'high'
			);

		}

		public static function get_option( $key, $settings, $defaults = '' ) {

			/**
			 * Get plugin options
			 *
			 * @param string $key - unique key for settings option
			 * @param array $section - Settings fields array
			 *
			 */


			$options = get_option( $settings );

			if ( isset( $options[ $key ] ) ) {
				return $options[ $key ];
			}

			return $defaults;
		}

		public static function select_options( $option, $first_option = '' ) {

			/**
			 * Return select options array for metabox select fields
			 *
			 * @param string $option -  comma separated string
			 * @param string $first_option - first option in select field
			 *
			 */

			$get_option = $option;

			$option_array = explode( ',', $get_option );
			if ( is_array( $option_array ) && ! empty( $option_array ) ) {

				if ( ! empty( $first_option ) ) {
					$new_option = array( 0 => $first_option );
				} else {
					$new_option = array();
				}

				foreach ( $option_array as $single ) {
					$new_option[] = $single;
				}

			}

			return $new_option;

		}

		public static function select_negotiator_options( $option, $first_option = '' ) {

			/**
			 * Return select options array for Negotiator/Agent metabox select fields
			 *
			 * @param string $option -  comma separated string
			 * @param string $first_option - first option in select field
			 *
			 */

			$get_option = $option;
			if ( $get_option == 'user' ) {
				$option_array = get_users( array( 'fields' => array( 'display_name' ) ) );


				if ( is_array( $option_array ) && ! empty( $option_array ) ) {

					if ( ! empty( $first_option ) ) {
						$new_option = array( 0 => $first_option );
					} else {
						$new_option = array();
					}

					foreach ( $option_array as $user ) {
						$new_option[ $user->display_name ] = $user->display_name;
					}

				}
			}


			if ( $get_option == 'cpt' ) {

				$get_cpt = self::get_option( 'recrm_enquiry_negotiator_cpt_settings', 'recrm_settings' );

				$post_type_query = new WP_Query(
					array(
						'post_type'      => $get_cpt,
						'posts_per_page' => - 1
					)
				);
				$posts_array     = $post_type_query->posts;
				$option_array    = wp_list_pluck( $posts_array, 'post_title', 'ID' );

				if ( is_array( $option_array ) && ! empty( $option_array ) ) {

					if ( ! empty( $first_option ) ) {
						$new_option = array( 0 => $first_option );
					} else {
						$new_option = array();
					}

					foreach ( $option_array as $user ) {
						$new_option[ $user ] = $user;
					}

				}
			}

			return $new_option;

		}


		public function allow_files_upload() {

			//It helps to upload files through custom meta fields
			echo ' enctype="multipart/form-data"';
		}

		public function remove_meta_boxes() {
			//Remove slug and featured image metabox from contact/enquiry custom post type
			remove_meta_box( 'slugdiv', 'enquiry', 'normal' );
			remove_meta_box( 'slugdiv', 'contact', 'normal' );
			remove_meta_box( 'postimagediv', 'enquiry', 'side' );
			remove_meta_box( 'commentsdiv', array( 'contact', 'enquiry' ), 'normal' );
		}

		public function set_contact_meta_box_fields() {

			$contact_statuses = self::select_options(
				self::get_option( 'recrm_contact_status_settings', 'recrm_settings', esc_html__( 'Lead,Customer', 'real-estate-crm' ) )
			);
			$contact_prefixes = self::select_options(
				self::get_option( 'recrm_contact_prefixes_settings', 'recrm_settings', esc_html__( 'Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs', 'real-estate-crm' ) ), esc_html__( 'None', 'real-estate-crm' )
			);
			$contact_source   = self::select_options(
				self::get_option( 'recrm_contact_source_settings', 'recrm_settings', esc_html__( 'Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ) ), esc_html__( 'None', 'real-estate-crm' )
			);

			$prefix = 'recrm_';

			$fields = array(

				'contact-id' => array(
					'label'      => esc_html__( 'Contact ID', 'real-estate-crm' ),
					'id'         => $prefix . 'contact_id',
					'type'       => 'text',
					'readonly'   => 'readonly',
					'contact-id' => true,
				),

				'status' => array(
					'label'   => esc_html__( 'Status', 'real-estate-crm' ),
					'id'      => $prefix . 'contact_status',
					'type'    => 'select',
					'options' => $contact_statuses
				),

				'prefix' => array(
					'label'   => esc_html__( 'Prefix', 'real-estate-crm' ),
					'id'      => $prefix . 'contact_prefix',
					'desc'    => esc_html__( 'i.e Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs', 'real-estate-crm' ),
					'type'    => 'select',
					'options' => $contact_prefixes
				),

				'first-name' => array(
					'label' => esc_html__( 'First Name', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_first_name',
					'type'  => 'text'
				),

				'last-name' => array(
					'label' => esc_html__( 'Last Name', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_last_name',
					'type'  => 'text'
				),

				'email' => array(
					'label' => esc_html__( 'Email', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_email',
					'type'  => 'text'
				),

				'address' => array(
					'label' => esc_html__( 'Address', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_address',
					'type'  => 'textarea'
				),

				'city' => array(
					'label' => esc_html__( 'City', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_city',
					'type'  => 'text'
				),

				'state' => array(
					'label' => esc_html__( 'State/Province', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_state',
					'type'  => 'text'
				),

				'zip-code' => array(
					'label' => esc_html__( 'Zip/Postal Code', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_zip_code',
					'type'  => 'text'
				),


				'country' => array(
					'label' => esc_html__( 'Country', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_country',
					'type'  => 'text'
				),


				'mobile' => array(
					'label' => esc_html__( 'Mobile', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_mobile',
					'type'  => 'text'
				),

				'work-phone' => array(
					'label' => esc_html__( 'Work Phone', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_work_phone',
					'type'  => 'text'
				),

				'home-phone' => array(
					'label' => esc_html__( 'Home Phone', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_home_phone',
					'type'  => 'text'
				),

				'twitter-url' => array(
					'label' => esc_html__( 'Twitter Profile URL', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_twitter_id',
					'type'  => 'text'
				),

				'linkedin-url' => array(
					'label' => esc_html__( 'Linkedin Profile URL', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_linkedin_id',
					'type'  => 'text'
				),

				'facebook-url' => array(
					'label' => esc_html__( 'Facebook Profile URL', 'real-estate-crm' ),
					'id'    => $prefix . 'contact_facebook_id',
					'type'  => 'text'
				),

				'source' => array(
					'label'   => esc_html__( 'Source', 'real-estate-crm' ),
					'id'      => $prefix . 'contact_source',
					'desc'    => esc_html__( 'i.e Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ),
					'type'    => 'select',
					'options' => $contact_source
				),

				'private-note' => array(
					'label' => esc_html__( 'Private Note', 'real-estate-crm' ),
					'id'    => $prefix . 'private_note',
					'type'  => 'textarea'
				),


			);

			$fields = apply_filters( 'recrm_set_contact_meta_box_fields_filters', $fields );

			return $fields;

		}

		public function recrm_file_attachment_field() {

			/**
			 *  Attachments field for contact post type
			 */
			$get_files = get_post_meta( get_the_ID(), 'recrm_attachments', true );

			?>
            <div class="recrm_wrapper_files">
                <label class="recrm_wp_custom_attachment"
                       for="recrm_wp_custom_attachment"><?php esc_html_e( 'Attachment', 'real-estate-crm' ) ?></label>
				<?php

				if ( ! empty( $get_files ) && is_array( $get_files ) ) {

					foreach ( $get_files as $file ) {

						echo '<div class="file_display_wrapper">';
						echo '<span class="dashicons dashicons-no recrm_delete_file"></span>';
						echo '<a download href="' . wp_get_attachment_url( $file ) . '" title="' . get_the_title( $file ) . '">';
						echo '<input type="hidden" name="recrm_attachment[]" id="recrm_attachment_' . esc_attr( $file ) . '" value="' . esc_html( $file ) . '">';
						echo wp_get_attachment_image( $file, array( 120, 120 ) );
						echo '</a>';
						echo '</div>';

					}
				}

				echo '<div class="file_display_wrapper_temp">';
				echo '<span class="dashicons dashicons-no recrm_delete_list_temp"></span>';
				echo '<a download href="">';
				echo '<img src="" >';
				echo '</a>';
				echo '</div>';
				?>

                <br>
                <input type="hidden" id="recrm_attachment" value="">
                <a href="#" class="recrm_file_button"><?php esc_html_e( 'Add File', 'real-estate-crm' ) ?></a>
            </div>
			<?php

		}

		public function show_enquiries_in_contact() {

			/**
			 *  Show enquires in contact post type
			 */

			$enq_args = array(
				'post_type'      => 'enquiry',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					array(
						'key'     => 'recrm_contact_enquiry_id',
						'value'   => get_the_ID(),
						'compare' => '=',
					)
				)
			);

			$get_posts = get_posts( $enq_args );
			if ( $get_posts ) {
				?>
                <div class="recrm_contact_enquiry_container">
                    <h2 class="recrm_enquiry_title"><?php esc_html_e( 'Enquiries', 'real-estate-crm' ) ?></h2>

					<?php
					foreach ( $get_posts as $get_post ) {
						setup_postdata( $get_post );
						$get_enquiry_status      = get_post_meta( $get_post->ID, 'recrm_enquiry_status', true );
						$get_enquiry_property_id = get_post_meta( $get_post->ID, 'recrm_enquiry_property_id', true );
						$get_agent_id            = get_post_meta( $get_post->ID, 'recrm_enquiry_agent_id', true );
						$get_author_id           = get_post_meta( $get_post->ID, 'recrm_enquiry_author_id', true );
						$content                 = $get_post->post_content;

						$enqyiry_negotiator_id = '';
						$author_avatar         = false;

						if ( ! empty( $get_enquiry_property_id ) ) {
							$enqyiry_negotiator_id = $get_enquiry_property_id;
							$form_source           = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry For ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_permalink( $enqyiry_negotiator_id ) ) . ' " >' . get_the_title( $enqyiry_negotiator_id ) . '</a></span>';
						} elseif ( ! empty( $get_author_id ) ) {
							$author_avatar = true;
							$form_source   = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry To ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_author_posts_url( $get_author_id ) ) . ' " >' . esc_html( get_the_author_meta( 'display_name', $get_author_id ) ) . '</a></span>';
						} elseif ( ! empty( $get_agent_id ) ) {
							$enqyiry_negotiator_id = $get_agent_id;
							$form_source           = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry To ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_permalink( $enqyiry_negotiator_id ) ) . ' " >' . get_the_title( $enqyiry_negotiator_id ) . '</a></span>';
						} else {
							$form_source = '<span class="recrm_contact_source contact_form">' . wp_kses( __( 'Enquiry Via <span>Contact Form</span>', 'real-estate-crm' ), array( 'span' => array() ) ) . '</span>';
						}

						?>
                        <div class="recrm_contact_enquiry_box">
                            <div class="recrm_contact_enquiry_box_inner">
								<?php

								if ( $author_avatar == true && ! empty( $get_author_id ) ) {
									?>
                                    <div class="enquiry_thumb_box">
                                        <a target="_blank"
                                           href="<?php echo esc_url( get_author_posts_url( $get_author_id ) ) ?>">
											<?php
											echo get_avatar( get_the_author_meta( 'user_email', $get_author_id ), 80 );
											?>
                                        </a>
                                    </div>
									<?php
								} elseif ( ! empty( $enqyiry_negotiator_id ) ) {
									?>
                                    <div class="enquiry_thumb_box">
                                        <a target="_blank"
                                           href="<?php echo esc_url( get_permalink( $enqyiry_negotiator_id ) ); ?>">
											<?php
											echo get_the_post_thumbnail( $enqyiry_negotiator_id, array( 80, 80 ) );
											?>
                                        </a>
                                    </div>
								<?php } ?>
                                <div class="enquiry_meta_box">
									<?php
									echo $form_source;
									?>
                                    <div class="meta_info">
                                        <div class="meta_info_inner">
										<span
                                                class="enquired_by"><?php echo esc_html( sprintf( __( 'Enquired %1$s  ago', 'real-estate-crm' ), human_time_diff( get_the_time( 'U', $get_post->ID ), current_time( 'timestamp' ) ) ) ) ?></span>
                                            <span><?php echo esc_html( sprintf( __( 'Status: %1$s', 'real-estate-crm' ), $get_enquiry_status ) ) ?></span>
                                        </div>
                                        <a class="vew_enquiry_detail_button"
                                           href="<?php echo admin_url( 'post.php?post=' . esc_html( $get_post->ID ) ) . '&action=edit' ?>"><?php esc_html_e( 'View Enquiry Details', 'real-estate-crm' ) ?></a>
                                    </div>

                                </div>
                            </div>

                            <span class="recrm_toggle_show dashicons dashicons-arrow-down-alt2"></span>

                            <div class="recrm_enquiry_toggle toggle_off">

                                <div class="recrm_enquiry_toggle_contents">
									<?php

									if ( ! empty( $get_enquiry_property_id ) && ! empty( $get_agent_id ) ) {
										?>
                                        <h4><?php esc_html_e( 'Enquiry To ', 'real-estate-crm' ) ?> <a target="_blank"
                                                                                                       href="<?php echo esc_url( get_permalink( $get_agent_id ) ) ?>"> <?php echo get_the_title( $get_agent_id ) ?></a>
                                        </h4>
										<?php

									} elseif ( ! empty( $get_author_id ) && ! empty( $get_enquiry_property_id ) ) {
										?>
                                        <h4><?php esc_html_e( 'Enquiry To ', 'real-estate-crm' ); ?><a target="_blank"
                                                                                                       href="<?php echo esc_url( get_author_posts_url( $get_author_id ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $get_author_id ) ); ?></a>
                                        </h4>
										<?php
									} else {
										?>
                                        <h4><?php esc_html_e( 'Enquiry', 'real-estate-crm' ) ?></h4>

										<?php
									}
									?>

									<?php echo wpautop( $content, true ); ?>
                                </div>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>
				<?php
			}
		}


		public function render_communication_metabox() {


			$get_current_user = wp_get_current_user();


			echo '<table class="recrm_table recrm_table_communication">';
			echo '<tr>';
			echo '<td class="meta-fields">';
			echo '<div class="recrm_notes_wrapper">';
			echo '<h2 class="recrm_enquiry_title">' . esc_html__( 'Notes', 'real-estate-crm' ) . '</h2>';
			echo '<div class="recrm_communication_table_container">';
			echo '<label for="comment_meta_box">' . esc_html__( 'New Note', 'real-estate-crm' ) . '</label>';
			echo '<div class="recrm_note_fields">';
			echo '<textarea name="comment_meta_box" id="comment_meta_box" rows="5"></textarea>';
			echo '<input type="hidden" name="recrm_current_user" id="recrm_current_user" value="' . $get_current_user->user_nicename . '">';
			echo '<input type="hidden" name="recrm_current_time" id="recrm_current_time" value="' . current_time( 'mysql' ) . '">';
			echo '<input type="hidden" name="recrm_current_post_id" id="recrm_current_post_id" value="' . get_the_ID() . '">';
			echo '<input type="hidden" name="recrm_current_user_avatar" id="recrm_current_user_avatar" value="' . get_avatar_url( $get_current_user->user_email ) . '"> ';
			echo '<input type="submit" id="submit-note" value="' . esc_html__( 'Save Note', 'real-estate-crm' ) . '" >';
			echo '<img class="recrm_ajax_loader recrm_hide" src="' . esc_url( get_site_url() ) . '/wp-includes/js/tinymce/skins/lightgray/img/loader.gif' . '" >';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>';
			echo '<div class="recrm_note_list_wrapper">';


			$args         = array(
				'post_id' => get_the_ID(),

			);
			$get_comments = get_comments( $args );


			if ( ! empty( $get_comments ) && is_array( $get_comments ) ) {

				foreach ( $get_comments as $comment ) {
					if ( $comment->user_id != 0 ) {

						?>

                        <div class="recrm_wrapper_note_stream">
                            <div class="recrm_note_head">
                                <div class="note_thumb">
									<span class="note_gravatar">
										<?php
										echo get_avatar( $comment->user_email, 40 );
										?>
									</span>
                                    <h4><?php echo esc_html( $comment->comment_author ) ?></h4>
                                </div>
                                <div class="note_time">
									<?php
									echo '<span class="recrm_note_date">' . sprintf( __( 'Added note %s ago', 'real-estate-crm' ), human_time_diff( strtotime( $comment->comment_date_gmt, current_time( 'timestamp' ) ) ) ) . '</span>';
									?>
                                </div>
                            </div>
                            <div class="recrm_note_content">
								<?php echo wpautop( esc_html( $comment->comment_content ) ); ?>
                            </div>
							<?php
							echo '<input type="hidden" name="recrm_note_id" value="' . $comment->comment_ID . '">';

							echo '<span class="recrm_delete_note" title="' . esc_attr__( 'Delete', 'real-estate-crm' ) . '"><span class="dashicons dashicons-trash"></span></span>';

							?>
                        </div>

						<?php

					}
				}
			}

			echo '</div>';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
		}


		public function render_contact_metabox_fields( $post ) {

			// Add nonce for security and authentication.
			wp_nonce_field( 'custom_nonce_action', 'custom_nonce_contact' );

			$custom_meta_fields = $this->set_contact_meta_box_fields();


			// Contact ID field

			?>
            <div class="recrm_meta_box_wrapper-outer">
                <div class="recrm_meta_box_wrapper">
                    <ul id="recrm_tabs">
                        <li><a class="current"
                               href="#recrm_card_view"><?php esc_html_e( 'View', 'real-estate-crm' ) ?></a></li>
                        <li><a href="#recrm_card_edit"><?php esc_html_e( 'Edit', 'real-estate-crm' ) ?></a></li>
                    </ul>

                    <div class="recrm_card_details">
                        <div id="recrm_card_view" class="recrm_tab_contents recrm_info_card active">

                            <div class="recrm_card_head">


                                <div class="recrm_head_thumb">
									<?php
									$card_email = get_post_meta( get_the_ID(), 'recrm_contact_email', true );

									if ( has_post_thumbnail() ) {
										the_post_thumbnail();
									} else {
										if ( ! empty( $card_email ) ) {
											echo get_avatar( $card_email, 130 );
										} else {
											echo get_avatar( 'empty@email.com', 130 );
										}
									}
									?>
                                </div>

                                <div class="recrm_head_meta">
                                    <h2><?php the_title(); ?></h2>
									<?php

									if ( ! empty( $card_email ) ) {
										?>
                                        <span class="email"><span
                                                    class="email-svg"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/email.svg'; ?></span><a
                                                    href="mailto:<?php echo esc_attr( antispambot( $card_email ) ); ?>"><?php echo esc_html( antispambot( $card_email ) ); ?></a></span>
										<?php
									}

									$card_phone = get_post_meta( get_the_ID(), 'recrm_contact_mobile', true );
									if ( ! empty( $card_phone ) ) {
										?>
                                        <span class="phone"><span
                                                    class="phone-svg"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/phone.svg'; ?></span><?php echo esc_html( $card_phone ); ?></span>
										<?php
									}

									$twitter_id  = get_post_meta( get_the_ID(), 'recrm_contact_twitter_id', true );
									$facebook_id = get_post_meta( get_the_ID(), 'recrm_contact_facebook_id', true );
									$linkedin_id = get_post_meta( get_the_ID(), 'recrm_contact_linkedin_id', true );

									if ( ! empty( $twitter_id ) || ! empty( $facebook_id ) || ! empty( $linkedin_id ) ) {
										?>

                                        <span class="card_socials">
							<?php
							if ( ! empty( $twitter_id ) ) {
								?>
                                <a target="_blank" class="twitter_id"
                                   href="<?php echo esc_url( $twitter_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/twitter.svg'; ?></a>
								<?php
							}
							if ( ! empty( $facebook_id ) ) {
								?>
                                <a target="_blank" class="fb_id"
                                   href="<?php echo esc_url( $facebook_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/facebook.svg'; ?></a>
								<?php
							}
							if ( ! empty( $linkedin_id ) ) {
								?>
                                <a target="_blank" class="linkedin_id"
                                   href="<?php echo esc_url( $linkedin_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/linkedin.svg'; ?></a>
								<?php
							}
							?>
							</span>

									<?php } ?>
                                </div>

                            </div> <!-- Card Head Ends-->


                            <div class="recrm_card_meta_info">

								<?php

								$meta_array = array(
									'first-name' => array(
										'label' => esc_html__( 'First Name', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_first_name', true ),
									),

									'last-name' => array(
										'label' => esc_html__( 'Last Name', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_last_name', true ),
									),

									'address' => array(
										'label' => esc_html__( 'Address', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_address', true ),
									),

									'city' => array(
										'label' => esc_html__( 'City', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_city', true ),
									),

									'state' => array(
										'label' => esc_html__( 'State', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_state', true ),
									),

									'postal-code' => array(
										'label' => esc_html__( 'Zip/Postal Code', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_zip_code', true ),
									),

									'mobile' => array(
										'label' => esc_html__( 'Mobile', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_mobile', true ),
									),

									'home' => array(
										'label' => esc_html__( 'Home', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_home_phone', true ),
									),

									'work' => array(
										'label' => esc_html__( 'Work', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_work_phone', true ),
									),

									'id' => array(
										'label' => esc_html__( 'Contact ID', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_id', true ),
									),

									'status' => array(
										'label' => esc_html__( 'Status', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_status', true ),
									),

									'source' => array(
										'label' => esc_html__( 'Source', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_contact_source', true ),
									),


								);

								$meta_array = apply_filters( 'recrm_contact_card_details_filters', $meta_array );

								if ( is_array( $meta_array ) && ! empty( $meta_array ) ) {
									echo '<table class="recrm_card_info_table">';
									foreach ( $meta_array as $values ) {

										?>
                                        <tr>
                                            <td class="label"><?php echo $values['label'] ?></td>
                                            <td class="value"><?php echo $values['value'] ? $values['value'] : esc_html__( '-', 'real-estate-crm' ); ?></td>

                                        </tr>

										<?php

									}
									echo '</table>';

								}

								$get_private_note = get_post_meta( get_the_ID(), 'recrm_private_note', true );

								if ( ! empty( $get_private_note ) ) {

									$private_note = apply_filters( 'recrm_contact_card_private_note_title_filters', esc_html__( 'Private Note', 'real-estate-crm' ) );
									?>
                                    <div class="recrm_private_note_display">
                                        <h4><?php esc_html_e( $private_note ) ?></h4>
                                        <p><?php echo wpautop( $get_private_note ); ?></p>
                                    </div>
									<?php
								}
								?>


								<?php
								$get_files = get_post_meta( get_the_ID(), 'recrm_attachments', true );
								if ( ! empty( $get_files ) && is_array( $get_files ) ) {
									$attachments = apply_filters( 'recrm_contact_card_attachments_title_filters', esc_html__( 'Attachments', 'real-estate-crm' ) );
									?>
                                    <div class="recrm_attachment_display">
                                        <h4><?php esc_html_e( $attachments ) ?></h4>
										<?php
										foreach ( $get_files as $file ) {

											echo '<div class="file_display_wrapper">';
											echo '<a download href="' . wp_get_attachment_url( $file ) . '" title="' . get_the_title( $file ) . '">';
											echo wp_get_attachment_image( $file, array( 120, 120 ) );
											echo '</a>';
											echo '</div>';

										}
										?>
                                    </div>
									<?php
								}
								?>
                            </div>
                        </div>

                        <div id="recrm_card_edit" class="recrm_tab_contents recrm_table_wrapper">
                            <table class="form-table recrm_table">
								<?php
								// Begin the field table and loop
								if ( is_array( $custom_meta_fields ) && ! empty( $custom_meta_fields ) ) {

									foreach ( $custom_meta_fields as $field ) {
										// get value of this field if it exists for this post
										$meta = get_post_meta( $post->ID, $field['id'], true );

										$readonly = '';
										if ( isset( $field['readonly'] ) && $field['readonly'] == 'readonly' ) {
											$readonly = $field['readonly'];
										}
										$description = '';
										if ( isset( $field['desc'] ) ) {
											$description = '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
										}
										// begin a table row with

										echo '<tr>';
										echo '<td class="meta-fields"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
										switch ( $field['type'] ) {
											// case items will go here
											case 'text':
												if ( empty( $readonly ) ) {
													echo '<input type="text" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $meta ) . '" size="30" /><br>';
												} elseif ( ! empty( $readonly ) && $field['contact-id'] == true ) {
													echo '<input type="hidden" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . get_the_ID() . '" size="30" />';
													echo '<p class="field-value">' . get_the_ID() . '</p>';
												}
												echo $description;
												break;
											// textarea
											case 'textarea':
												echo '<textarea name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" cols="60" rows="4">' . $meta . '</textarea><br>';
												echo $description;
												break;
											// select
											case 'select':
												echo '<select name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '">';
												foreach ( $field['options'] as $option ) {
													echo '<option ' . ( $meta == $option ? 'selected' : ' ' ) . '  value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</option>';
												}
												echo $description;
												break;
										} //end switch
										echo '</td>';

										echo '</tr>';

									} // end foreach
								}

								echo '<tr>';
								echo '<td>';

								//File Attachment Function
								$this->recrm_file_attachment_field();

								echo '</td></tr>';
								//								echo '<tr><td>' . . '</td></tr>';
								?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="recrm_communication_wrapper">
                    <div class="recrm_communication_inner">
						<?php $this->show_enquiries_in_contact(); ?>
						<?php $this->render_communication_metabox(); ?>
                    </div>
                </div>


            </div>


			<?php

			echo recrm_feedback_request_message();
		}

		public function save_contact_metabox( $post_id ) {

			$custom_meta_fields = $this->set_contact_meta_box_fields();


			// Check if nonce is set.
			$nonce_name   = isset( $_POST['custom_nonce_contact'] ) ? $_POST['custom_nonce_contact'] : '';
			$nonce_action = 'custom_nonce_action';

			if ( ! isset( $nonce_name ) ) {
				return;
			}

			// Check if nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}
			// Check if user has permissions to save data.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}


			if ( is_array( $custom_meta_fields ) || is_object( $custom_meta_fields ) ) {
				foreach ( $custom_meta_fields as $field ) {

					$old = get_post_meta( $post_id, $field['id'], true );
					$new = $_POST[ $field['id'] ];
					if ( $new && $new != $old ) {
						update_post_meta( $post_id, $field['id'], $new );
					} elseif ( '' == $new && $old ) {
						delete_post_meta( $post_id, $field['id'], $old );
					}
				} // end foreach

			}


			if ( ! empty( $_POST['recrm_attachment'] ) && is_array( $_POST['recrm_attachment'] ) ) {

				$get_file = $_POST['recrm_attachment'];

				$get_file = array_filter( $get_file );

				update_post_meta( $post_id, 'recrm_attachments', $get_file );
			}

		}

		public function save_communication() {

			check_ajax_referer( 'custom_nonce_communication', 'security' );

			$get_comment = '';
			if ( isset( $_POST['comment_note'] ) ) {
				$get_comment = $_POST['comment_note'];
			}

			$get_post_id = '';
			if ( isset( $_POST['post_Id'] ) ) {
				$get_post_id = $_POST['post_Id'];
			}

			if ( ! empty( $get_comment ) ) {
				$get_current_user = wp_get_current_user();

				$time = current_time( 'mysql' );
				$data = array(
					'comment_post_ID'      => $get_post_id,
					'comment_author'       => $get_current_user->user_nicename,
					'comment_author_email' => $get_current_user->user_email,
					'comment_content'      => $get_comment,
					'user_id'              => $get_current_user->ID,
					'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
					'comment_date'         => $time,
					'comment_approved'     => 1,
				);

				// Insert the comment into the database
				wp_insert_comment( $data );

				global $wpdb;
				$lastid = $wpdb->insert_id;
				echo $lastid;

				wp_die();
			}

		}


		public function remove_note() {

			//Remove Comment By ID

			check_ajax_referer( 'custom_nonce_delete', 'security_delete' );

			$get_id = $_POST['post_Id'];

			wp_delete_comment( $get_id );
		}


		public function add_enquiry_metabox() {

			$metabox_title = apply_filters( 'recrm_enquiry_details_meta_box_title_filter', esc_html__( 'Enquiry Details', 'real-estate-crm' ) );

			add_meta_box(
				'recrm-enquiry-detail-metabox',
				$metabox_title,
				array( $this, 'render_enquiry_metabox_fields' ),
				'enquiry'
			);

		}


		public function set_enquiry_meta_box_fields() {

			$contact_source    = self::select_options(
				self::get_option( 'recrm_contact_source_settings', 'recrm_settings', esc_html__( 'Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ) )
			);
			$enquiry_status    = self::select_options(
				self::get_option( 'recrm_enquiry_status_settings', 'recrm_settings', esc_html__( 'Open, Close', 'real-estate-crm' ) )
			);
			$negotiator_source = self::select_negotiator_options(
				self::get_option( 'recrm_enquiry_negotiator_settings', 'recrm_settings', 'user' ), esc_html__( 'None', 'real-estate-crm' )
			);

			$prefix = 'recrm_';

			$fields = array(


				'source' => array(
					'label'   => esc_html__( 'Source', 'real-estate-crm' ),
					'id'      => $prefix . 'enquiry_source',
					'desc'    => esc_html__( 'i.e Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ),
					'type'    => 'select',
					'options' => $contact_source
				),

				'status' => array(
					'label'   => esc_html__( 'Status', 'real-estate-crm' ),
					'id'      => $prefix . 'enquiry_status',
					'desc'    => esc_html__( 'i.e Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ),
					'type'    => 'select',
					'options' => $enquiry_status
				),


				'negotiator' => array(
					'label'   => esc_html__( 'Agent/Negotiator', 'real-estate-crm' ),
					'id'      => $prefix . 'enquiry_negotiator',
					'desc'    => esc_html__( 'Select an agent', 'real-estate-crm' ),
					'type'    => 'select',
					'options' => $negotiator_source,
				),

				'private-note' => array(
					'label' => esc_html__( 'Private Note', 'real-estate-crm' ),
					'id'    => $prefix . 'private_enquiry_note',
					'type'  => 'textarea'
				),


			);

			$fields = apply_filters( 'recrm_set_enquiry_meta_box_fields_filters', $fields );

			return $fields;

		}

		public function show_enquiry( $post ) {
			?>
            <div class="recrm_contact_enquiry_container">
                <h2 class="recrm_enquiry_title"><?php esc_html_e( 'Enquiry', 'real-estate-crm' ) ?></h2>
				<?php
				$get_enquiry_property_id = get_post_meta( get_the_ID(), 'recrm_enquiry_property_id', true );
				$get_enquiry_status      = get_post_meta( get_the_ID(), 'recrm_enquiry_status', true );
				$get_agent_id            = get_post_meta( get_the_ID(), 'recrm_enquiry_agent_id', true );
				$get_author_id           = get_post_meta( $post->ID, 'recrm_enquiry_author_id', true );
				$content                 = $post->post_content;
				$enqyiry_negotiator_id   = '';
				$author_avatar           = false;

				if ( ! empty( $get_enquiry_property_id ) ) {
					$enqyiry_negotiator_id = $get_enquiry_property_id;
					$form_source           = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry For ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_permalink( $enqyiry_negotiator_id ) ) . ' " >' . get_the_title( $enqyiry_negotiator_id ) . '</a></span>';
				} elseif ( ! empty( $get_author_id ) ) {
					$author_avatar = true;
					$form_source   = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry To ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_author_posts_url( $get_author_id ) ) . ' " >' . esc_html( get_the_author_meta( 'display_name', $get_author_id ) ) . '</a></span>';
				} elseif ( ! empty( $get_agent_id ) ) {
					$enqyiry_negotiator_id = $get_agent_id;
					$form_source           = '<span class="recrm_contact_source">' . esc_html__( 'Enquiry To ', 'real-estate-crm' ) . '<a class="enquiry_property_title" target="_blank" href=" ' . esc_url( get_permalink( $enqyiry_negotiator_id ) ) . ' " >' . get_the_title( $enqyiry_negotiator_id ) . '</a></span>';
				} else {
					$form_source = '<span class="recrm_contact_source contact_form">' . wp_kses( __( 'Enquiry Via <span>Contact Form</span>', 'real-estate-crm' ), array( 'span' => array() ) ) . '</span>';
				}

				?>

                <div class="recrm_contact_enquiry_box">
                    <div class="recrm_contact_enquiry_box_inner">
						<?php
						if ( $author_avatar == true && ! empty( $get_author_id ) ) {
							?>
                            <div class="enquiry_thumb_box">
                                <a target="_blank"
                                   href="<?php echo esc_url( get_author_posts_url( $get_author_id ) ) ?>">
									<?php
									echo get_avatar( get_the_author_meta( 'user_email', $get_author_id ), 80 );
									?>
                                </a>
                            </div>
							<?php
						} elseif ( ! empty( $enqyiry_negotiator_id ) ) {
							?>
                            <div class="enquiry_thumb_box">
                                <a target="_blank"
                                   href="<?php echo esc_url( get_permalink( $enqyiry_negotiator_id ) ); ?>">
									<?php
									echo get_the_post_thumbnail( $enqyiry_negotiator_id, array( 80, 80 ) );
									?>
                                </a>
                            </div>
						<?php } ?>
                        <div class="enquiry_meta_box">
							<?php
							echo $form_source;
							?>
                            <div class="meta_info">
                                <div class="meta_info_inner">
										<span
                                                class="enquired_by"><?php echo esc_html( sprintf( __( 'Enquired %1$s  ago', 'real-estate-crm' ), human_time_diff( get_the_time( 'U', get_the_ID() ), current_time( 'timestamp' ) ) ) ) ?></span>
                                    <span><?php echo esc_html( sprintf( __( 'Status: %1$s', 'real-estate-crm' ), $get_enquiry_status ) ) ?></span>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="recrm_enquiry_toggle">

                        <div class="recrm_enquiry_toggle_contents">

							<?php

							if ( ! empty( $get_enquiry_property_id ) && ! empty( $get_agent_id ) ) {
								?>
                                <h4><?php esc_html_e( 'Enquiry To ', 'real-estate-crm' ) ?> <a target="_blank"
                                                                                               href="<?php echo esc_url( get_permalink( $get_agent_id ) ) ?>"> <?php echo get_the_title( $get_agent_id ) ?></a>
                                </h4>
								<?php

							} elseif ( ! empty( $get_author_id ) && ! empty( $get_enquiry_property_id ) ) {
								?>
                                <h4><?php esc_html_e( 'Enquiry To ', 'real-estate-crm' ); ?><a target="_blank"
                                                                                               href="<?php echo esc_url( get_author_posts_url( $get_author_id ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $get_author_id ) ); ?></a>
                                </h4>
								<?php
							}
							?>


							<?php echo wpautop( $content, true ); ?>
                        </div>
                    </div>
                </div>

            </div>
			<?php
		}


		public function render_enquiry_metabox_fields( $post ) {

			// Add nonce for security and authentication.
			wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

			$custom_meta_fields = $this->set_enquiry_meta_box_fields();

			// Contact ID field
			?>
            <div class="recrm_meta_box_wrapper-outer">
                <div class="recrm_meta_box_wrapper">
                    <ul id="recrm_tabs">
                        <li><a class="current"
                               href="#recrm_card_view"><?php esc_html_e( 'View', 'real-estate-crm' ) ?></a></li>
                        <li><a href="#recrm_card_edit"><?php esc_html_e( 'Edit', 'real-estate-crm' ) ?></a></li>
                    </ul>
                    <div class="recrm_card_details">
                        <div id="recrm_card_view" class="recrm_tab_contents recrm_info_card active">
                            <div class="recrm_card_head">
                                <div class="recrm_head_thumb">
									<?php
									$card_email        = get_post_meta( get_the_ID(), 'recrm_enquiry_email', true );
									$get_enquirer_name = get_post_meta( get_the_ID(), 'recrm_enquiry_name', true );
									if ( has_post_thumbnail() ) {
										the_post_thumbnail();
									} else {
										if ( ! empty( $card_email ) ) {
											echo get_avatar( $card_email, 130 );
										} else {
											echo get_avatar( 'empty@email.com', 130 );
										}
									}
									?>
                                </div>
                                <div class="recrm_head_meta">
                                    <h2><?php echo esc_html( $get_enquirer_name ); ?></h2>
									<?php

									if ( ! empty( $card_email ) ) {
										?>
                                        <span class="email"><span
                                                    class="email-svg"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/email.svg'; ?></span><a
                                                    href="mailto:<?php echo esc_attr( antispambot( $card_email ) ); ?>"><?php echo esc_html( antispambot( $card_email ) ); ?></a></span>
										<?php
									}

									$card_phone = get_post_meta( get_the_ID(), 'recrm_enquiry_phone', true );
									if ( ! empty( $card_phone ) ) {
										?>
                                        <span class="phone"><span
                                                    class="phone-svg"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/phone.svg'; ?></span><?php echo esc_html( $card_phone ); ?></span>
										<?php
									}

									$twitter_id  = get_post_meta( get_the_ID(), 'recrm_contact_twitter_id', true );
									$facebook_id = get_post_meta( get_the_ID(), 'recrm_contact_facebook_id', true );
									$linkedin_id = get_post_meta( get_the_ID(), 'recrm_contact_linkedin_id', true );

									if ( ! empty( $twitter_id ) || ! empty( $facebook_id ) || ! empty( $linkedin_id ) ) {
										?>

                                        <span class="card_socials">
							<?php
							if ( ! empty( $twitter_id ) ) {
								?>
                                <a target="_blank" class="twitter_id"
                                   href="<?php echo esc_url( $twitter_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/twitter.svg'; ?></a>
								<?php
							}
							if ( ! empty( $facebook_id ) ) {
								?>
                                <a target="_blank" class="fb_id"
                                   href="<?php echo esc_url( $facebook_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/facebook.svg'; ?></a>
								<?php
							}
							if ( ! empty( $linkedin_id ) ) {
								?>
                                <a target="_blank" class="linkedin_id"
                                   href="<?php echo esc_url( $linkedin_id ) ?>"><?php include plugin_dir_path( __DIR__ ) . 'images/svg/linkedin.svg'; ?></a>
								<?php
							}
							?>
							</span>

									<?php } ?>
                                </div>

                            </div>
                            <div class="recrm_card_meta_info">

								<?php

								$get_contact_enqiry_id = get_post_meta( get_the_ID(), 'recrm_contact_enquiry_id', true );

								$get_contact_enqiry_title = get_the_title( $get_contact_enqiry_id );

								$get_contact_enquiry_edit_admin_url = admin_url( 'post.php?post=' . esc_html( $get_contact_enqiry_id ) ) . '&action=edit';

								$get_negotiator  = get_post_meta( get_the_ID(), 'recrm_enquiry_negotiator', true );
								$get_agent_id    = get_post_meta( get_the_ID(), 'recrm_enquiry_agent_id', true );
								$get_author_name = get_post_meta( get_the_ID(), 'recrm_enquiry_author_name', true );
								$get_author_id = get_post_meta( get_the_ID(), 'recrm_enquiry_author_id', true );


								if ( ! empty( $get_negotiator ) && $get_negotiator != "None" ) {
									$get_enquiry_source = $get_negotiator;
								} elseif ( ! empty( $get_agent_id ) ) {
									$get_enquiry_source = get_the_title( $get_agent_id );
								} elseif ( ! empty( $get_author_id ) ) {
									$get_enquiry_source = get_the_author_meta( 'display_name', $get_author_id );
								} else {
									$get_enquiry_source = esc_html__( 'None', 'real-estate-crm' );
								}


								$meta_array = array(

									'id' => array(
										'label' => esc_html__( 'ID', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_enquiry_id', true ),
									),


									'contact' => array(
										'label'     => esc_html__( 'Contact', 'real-estate-crm' ),
										'value'     => $get_contact_enqiry_title,
										'type'      => 'url',
										'permalink' => $get_contact_enquiry_edit_admin_url,
									),

									'status' => array(
										'label' => esc_html__( 'Status', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_enquiry_status', true ),
									),


									'Property' => array(
										'label'     => esc_html__( 'Property', 'real-estate-crm' ),
										'value'     => get_post_meta( get_the_ID(), 'recrm_enquiry_property_title', true ),
										'type'      => 'url',
										'permalink' => get_post_meta( get_the_ID(), 'recrm_enquiry_property_url', true ),
										'target'    => 'blank'
									),


									'negotiator' => array(
										'label' => esc_html__( 'Negotiator', 'real-estate-crm' ),
										'value' => esc_html( $get_enquiry_source ),
									),


									'source' => array(
										'label' => esc_html__( 'Source', 'real-estate-crm' ),
										'value' => get_post_meta( get_the_ID(), 'recrm_enquiry_source', true ),
									),


								);

								$meta_array = apply_filters( 'recrm_enquiry_card_details_filters', $meta_array );

								if ( is_array( $meta_array ) && ! empty( $meta_array ) ) {
									echo '<table class="recrm_card_info_table">';
									foreach ( $meta_array as $values ) {

										?>
                                        <tr>
                                            <td class="label"><?php echo esc_html( $values['label'] ) ?></td>
                                            <td class="value">

												<?php
												if ( array_key_exists( 'type', $values ) && ! empty( $values['permalink'] ) ) {
													?>
                                                    <a
														<?php
														if ( array_key_exists( 'target', $values ) ) {
															echo 'target="_blank"';
														}
														?>
                                                            href="<?php echo esc_attr( $values['permalink'] ) ?>">
														<?php echo $values['value'] ? esc_html( $values['value'] ) : esc_html__( '-', 'real-estate-crm' ); ?>
                                                    </a>
													<?php

												} else {
													echo $values['value'] ? esc_html( $values['value'] ) : esc_html__( '-', 'real-estate-crm' );
												}

												?>
                                            </td>
                                        </tr>

										<?php

									}
									echo '</table>';

								}

								$get_private_note = get_post_meta( get_the_ID(), 'recrm_private_enquiry_note', true );

								if ( ! empty( $get_private_note ) ) {
									$private_enquiry_note = apply_filters( 'recrm_enquiry_card_private_note_title_filters', esc_html__( 'Private Note', 'real-estate-crm' ) );
									?>
                                    <div class="recrm_private_note_display">
                                        <h4><?php esc_html_e( $private_enquiry_note ) ?></h4>
                                        <p><?php echo wpautop( $get_private_note ); ?></p>
                                    </div>
									<?php
								}
								?>

                            </div>

                        </div>
                        <div id="recrm_card_edit" class="recrm_tab_contents recrm_table_wrapper">
							<?php
							echo '<table class="form-table recrm_table">';

							// Begin the field table and loop
							if ( ! empty( $custom_meta_fields ) && is_array( $custom_meta_fields ) ) {
								foreach ( $custom_meta_fields as $field ) {
									// get value of this field if it exists for this post
									$get_meta = get_post_meta( $post->ID, $field['id'], true );
									$meta     = '';
									if ( ! empty( $get_meta ) ) {
										$meta = $get_meta;
									}

									$readonly = '';
									if ( isset( $field['readonly'] ) ) {
										$readonly = $field['readonly'];
									}
									$description = '';
									if ( isset( $field['desc'] ) ) {
										$description = '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
									}
									// begin a table row with
									echo '<tr>';
									echo '<td class="meta-fields"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
									switch ( $field['type'] ) {
										// case items will go here
										case 'text':
											echo '<input type="hidden" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $meta ) . '" size="30" ' . $readonly . ' />';
											if ( ! empty( $meta ) ) {
												echo '<p class="field-value">' . esc_html( $meta ) . '</p>';
											} else {
												echo '<p class="field-value">' . esc_html__( 'NA', 'real-estate-crm' ) . '</p>';
											}
											echo $description;
											break;
										// textarea
										case 'textarea':
											echo '<textarea name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" cols="60" rows="4">' . esc_html( $meta ) . '</textarea>';
											echo $description;
											break;
										// select
										case 'select':
											echo '<select name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '">';
											foreach ( $field['options'] as $option ) {
												echo '<option ' . ( $meta == $option ? 'selected' : ' ' ) . ' value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</option>';
											}
											echo $description;
											break;

										case 'url':
											if ( ! empty( $meta ) ) {
												echo '<input type="hidden" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '"  value="' . esc_attr( $meta ) . '">';
												if ( isset ( $field['edit-capability'] ) &&
												     ( $field['edit-capability'] == 'true' ) &&
												     ! empty( $get_meta )
												) {
													echo '<a href=" ' . admin_url( 'post.php?post=' . esc_html( $meta ) ) . '&action=edit">' . get_the_title( $meta ) . '</a>';

												} elseif ( ! empty( $get_meta ) ) {
													echo '<a class="enquiry-property-url" href="' . esc_url( $meta ) . '">' . esc_url( $meta ) . '</a>';
												} else {
													echo '<p class="field-value">' . esc_html( $meta ) . '</p>';
												}
											} else {
												esc_html_e( 'NA', 'real-estate-crm' );
											}
											break;

										case 'file':

											break;
									} //end switch
									echo '</td>';

									echo '</tr>';


								} // end foreach
							}
							echo '</table>';

							?>
                        </div>
                    </div>

                </div>
                <div class="recrm_communication_wrapper">
                    <div class="recrm_communication_inner">
						<?php $this->show_enquiry( $post ); ?>
						<?php $this->render_communication_metabox(); ?>
                    </div>
                </div>
            </div>
			<?php
			echo recrm_feedback_request_message();
		}

		public function save_enquiry_metabox( $post_id ) {

			$custom_meta_fields = $this->set_enquiry_meta_box_fields();


			// Check if nonce is set.
			$nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
			$nonce_action = 'custom_nonce_action';

			if ( ! isset( $nonce_name ) ) {
				return;
			}

			// Check if nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}
			// Check if user has permissions to save data.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}

			// loop through fields and save the data


			if ( is_array( $custom_meta_fields ) || is_object( $custom_meta_fields ) ) {
				foreach ( $custom_meta_fields as $field ) {

					if ( $field ) {
						$old = get_post_meta( $post_id, $field['id'], true );
						if ( isset( $_POST[ $field['id'] ] ) ) {
							$new = $_POST[ $field['id'] ];
						}
						if ( isset( $new ) && $new != $old ) {
							update_post_meta( $post_id, $field['id'], $new );
						} elseif ( '' == $new && $old ) {
							delete_post_meta( $post_id, $field['id'], $old );
						}

					}

				} // end foreach

			}

		}

	}


	new RECRM_meta_boxes();
}

