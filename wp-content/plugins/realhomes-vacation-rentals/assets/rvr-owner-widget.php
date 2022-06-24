<?php
/**
 * Widget: RVR Owner Widget
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/assets
 */

if ( ! class_exists( 'RVR_Owner_Widget' ) ) {

	class RVR_Owner_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array(
				'classname'   => 'RVR_Owner_Widget',
				'description' => esc_html__( 'This widget displays rental owner information and can be used only on property single page.', 'realhomes-vacation-rentals' ),
			);
			parent::__construct( 'rvr_owner_widget', esc_html__( 'RVR - Owner Information Widget', 'realhomes-vacation-rentals' ), $widget_ops );
		}

		public function widget( $args, $instance ) {

			extract( $args );
			$owner_id = get_post_meta( get_the_ID(), 'rvr_property_owner', true );

			if ( ! is_singular( 'property' ) ) {
				echo $before_widget;
				echo '<p class="warning-message">' . esc_html__( 'Owner information widget can be used only on property single page.', 'realhomes-vacation-rentals' ) . '</p>';
				echo $after_widget;
			} else if ( ! empty( $owner_id ) ) {

				echo $before_widget;

				$rvr_settings = get_option( 'rvr_settings' );
				$rvr_enabled  = $rvr_settings['rvr_activation'];

				if ( $rvr_enabled ) {

					$name_prefix  = esc_html( $instance['name_prefix'] );
					$owner_name   = get_the_title( $owner_id );
					$info_display = $instance['info_display'] ? true : false;

					?>
                    <div class="property-owner <?php echo INSPIRY_DESIGN_VARIATION; ?>">
						<?php
						if ( ! empty( $owner_name ) && INSPIRY_DESIGN_VARIATION === 'classic' ) {
							?>
                            <h3 class="title property-agent-title"><?php echo $name_prefix . ' - ' . $owner_name; ?></h3><?php
						}
						?>
                        <div class="agent-info clearfix">
							<?php
							if ( has_post_thumbnail( $owner_id ) ) {
								echo get_the_post_thumbnail( $owner_id, 'agent-image' );
							}

							if ( $info_display ) {

								$owner_meta     = get_post_custom( $owner_id );
								$owner_email    = isset( $owner_meta['rvr_owner_email'][0] ) ? $owner_meta['rvr_owner_email'][0] : '';
								$owner_mobile   = isset( $owner_meta['rvr_owner_mobile'][0] ) ? $owner_meta['rvr_owner_mobile'][0] : '';
								$owner_phone    = isset( $owner_meta['rvr_owner_office_phone'][0] ) ? $owner_meta['rvr_owner_office_phone'][0] : '';
								$owner_fax      = isset( $owner_meta['rvr_owner_fax'][0] ) ? $owner_meta['rvr_owner_fax'][0] : '';
								$owner_whatsapp = isset( $owner_meta['rvr_owner_whatsapp'][0] ) ? $owner_meta['rvr_owner_whatsapp'][0] : '';
								$owner_address  = isset( $owner_meta['rvr_owner_address'][0] ) ? $owner_meta['rvr_owner_address'][0] : '';

								if (
									$owner_email
									|| $owner_mobile
									|| $owner_phone
									|| $owner_fax
									|| $owner_whatsapp
									|| $owner_address
								) {

									if ( INSPIRY_DESIGN_VARIATION === 'classic' ) {
										?>
                                        <ul class="contacts-list">
										<?php
										if ( $owner_phone ) {
											?>
                                            <li class="office">
												<?php include INSPIRY_THEME_DIR . '/images/icon-phone.svg';
												esc_html_e( 'Office', 'realhomes-vacation-rentals' ); ?>
                                                : <?php echo esc_html( $owner_phone ); ?>
                                            </li>
											<?php
										}
										if ( $owner_mobile ) {
											?>
                                            <li class="mobile">
												<?php include INSPIRY_THEME_DIR . '/images/icon-mobile.svg';
												esc_html_e( 'Mobile', 'realhomes-vacation-rentals' ); ?>
                                                : <?php echo esc_html( $owner_mobile ); ?>
                                            </li>
											<?php
										}
										if ( $owner_fax ) {
											?>
                                            <li class="fax">
												<?php include INSPIRY_THEME_DIR . '/images/icon-printer.svg';
												esc_html_e( 'Fax', 'realhomes-vacation-rentals' ); ?>
                                                : <?php echo esc_html( $owner_fax ); ?>
                                            </li>
											<?php
										}
										if ( $owner_whatsapp ) {
											?>
                                            <li class="whatsapp">
												<?php include INSPIRY_THEME_DIR . '/images/icon-whatsapp.svg';
												esc_html_e( 'WhatsApp', 'realhomes-vacation-rentals' ); ?>
                                                : <?php echo esc_html( $owner_whatsapp ); ?>
                                            </li>
											<?php
										}
										if ( $owner_email ) {
											?>
                                            <li class="email">
												<?php include INSPIRY_THEME_DIR . '/images/icon-mail.svg';
												esc_html_e( 'Email', 'realhomes-vacation-rentals' ); ?>
                                                :
                                                <a href="mailto:<?php echo sanitize_email( $owner_email ); ?>"><?php echo antispambot( sanitize_email( $owner_email ) ); ?></a>
                                            </li>
											<?php
										}
										if ( $owner_address ) {
											?>
                                            <li class="address"><?php include INSPIRY_THEME_DIR . '/images/icon-map.svg';
												esc_html_e( 'Address', 'realhomes-vacation-rentals' ); ?>
                                                : <?php echo esc_html( $owner_address ); ?></li>
											<?php
										}
										?>
                                        </ul><?php
									} else {
										if ( ! empty( $owner_name ) ) {
											?>
                                            <h3 class="rvr_property_owner_title"><?php echo esc_html( $owner_name ); ?></h3>
                                            <p class="rvr_widget_owner_label"><?php echo esc_html( $name_prefix ); ?></p>
											<?php
										}
										?>
                                        <div class="rvr_property_owner_agent_info">
											<?php
											if ( ! empty( $owner_phone ) ) {
												?>
                                                <p class="contact office">
                                                    <i class="fas fa-phone-alt"></i>
                                                    <a href="tel:<?php echo esc_attr( $owner_phone ) ?>" class="value"><?php echo esc_html( $owner_phone ) ?></a>
                                                </p>
												<?php
											}

											if ( $owner_mobile ) {
												?>
                                                <p class="contact mobile">
                                                    <i class="fas fa-mobile-alt"></i>
                                                    <a href="tel:<?php echo esc_attr( $owner_mobile ); ?>" class="value"><?php echo esc_html( $owner_mobile ); ?></a>
                                                </p>
												<?php
											}

											if ( $owner_fax ) {
												?>
                                                <p class="contact fax">
                                                    <i class="fas fa-fax"></i>
                                                    <span class="value"><?php echo esc_html( $owner_fax ) ?></span>
                                                </p>
												<?php
											}

											if ( $owner_whatsapp ) {
												?>
                                                <p class="contact whatsapp">
                                                    <i class="fab fa-whatsapp"></i>
                                                    <a href="https://wa.me/<?php echo esc_attr( $owner_whatsapp ) ?>" class="value"><?php echo esc_html( $owner_whatsapp ) ?></a>
                                                </p>
												<?php
											}

											if ( $owner_email ) {
												?>
                                                <p class="contact email">
                                                    <i class="fas fa-envelope"></i>
                                                    <a href="mailto:<?php sanitize_email( $owner_email ); ?>" class="value"><?php echo antispambot( sanitize_email( $owner_email ) ); ?></a>
                                                </p>
												<?php
											}
											?>
                                        </div>
										<?php
									}

								} else {
									?>
                                    <h3 class="rh_property_agent__title"><?php esc_html_e( 'Something went wrong!', 'realhomes-vacation-rentals' ); ?></h3>
									<?php
								}
							} elseif ( ! empty( $owner_name ) && INSPIRY_DESIGN_VARIATION === 'modern' ) {
								?>
                                <h3 class="rvr_property_owner_title"><?php echo esc_html( $owner_name ); ?></h3>
                                <p class="rvr_widget_owner_label"><?php echo esc_html( $name_prefix ); ?></p>
								<?php

							} else {
								?>
                                <h3 class="rh_property_agent__title"><?php esc_html_e( 'Something went wrong!', 'realhomes-vacation-rentals' ); ?></h3>
								<?php
							}


							?>
                            <div class="rvr_owner_content_area">
								<?php
								$page_data = get_post( $owner_id );
								if ( $page_data ) {
									echo $page_data->post_content;
								}

								?>
                            </div>
							<?php

							$rvr_owner_twitter   = isset( $owner_meta['rvr_owner_twitter'][0] ) ? $owner_meta['rvr_owner_twitter'][0] : '';
							$rvr_owner_facebook  = isset( $owner_meta['rvr_owner_facebook'][0] ) ? $owner_meta['rvr_owner_facebook'][0] : '';
							$rvr_owner_instagram = isset( $owner_meta['rvr_owner_instagram'][0] ) ? $owner_meta['rvr_owner_instagram'][0] : '';
							$rvr_owner_linkedin  = isset( $owner_meta['rvr_owner_linkedin'][0] ) ? $owner_meta['rvr_owner_linkedin'][0] : '';
							$rvr_owner_pinterest = isset( $owner_meta['rvr_owner_pinterest'][0] ) ? $owner_meta['rvr_owner_pinterest'][0] : '';
							$rvr_owner_youtube   = isset( $owner_meta['rvr_owner_youtube'][0] ) ? $owner_meta['rvr_owner_youtube'][0] : '';

							if (
								$rvr_owner_twitter
								|| $rvr_owner_facebook
								|| $rvr_owner_instagram
								|| $rvr_owner_linkedin
								|| $rvr_owner_pinterest
								|| $rvr_owner_youtube
							) {
								?>
                                <div class="rvr_owner_social_icons_wrapper">
                                    <ul>
										<?php
										if ( $rvr_owner_twitter ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_twitter ); ?>">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
											<?php
										}
										if ( $rvr_owner_facebook ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_facebook ); ?>">
                                                    <i class="fab fa-facebook-square"></i>
                                                </a>
                                            </li>
											<?php
										}
										if ( $rvr_owner_instagram ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_instagram ); ?>">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
											<?php
										}
										if ( $rvr_owner_linkedin ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_linkedin ); ?>">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            </li>
											<?php
										}
										if ( $rvr_owner_pinterest ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_pinterest ); ?>">
                                                    <i class="fab fa-pinterest-square"></i>
                                                </a>
                                            </li>
											<?php
										}
										if ( $rvr_owner_youtube ) {
											?>
                                            <li>
                                                <a target="_blank" href="<?php echo esc_url( $rvr_owner_youtube ); ?>">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
											<?php
										}
										?>
                                    </ul>
                                </div>
								<?php
							}
							?>
                        </div>
                    </div>
					<?php
				} else {
					echo '<p class="warning-message"><strong>' . esc_html__( 'Note: ', 'realhomes-vacation-rentals' ) . '</strong>' . esc_html__( 'Please activate the RVR from its settings to display Property Owner information.', 'realhomes-vacation-rentals' ) . '</p>';
				}

				echo $after_widget;

			}

		}


		public function form( $instance ) {
			$instance     = wp_parse_args(
				(array) $instance, array(
					'name_prefix'  => esc_html__( 'Owner', 'realhomes-vacation-rentals' ),
					'info_display' => esc_html__( 'off', 'realhomes-vacation-rentals' ),
				)
			);
			$name_prefix  = esc_attr( $instance['name_prefix'] );
			$info_display = esc_attr( $instance['info_display'] );
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'name_prefix' ) ); ?>"><?php esc_html_e( 'Owner Name Prefix', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'name_prefix' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'name_prefix' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $name_prefix ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'info_display' ) ); ?>"><?php esc_html_e( 'Display Owner Contact Information?', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'info_display' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'info_display' ) ); ?>" type="checkbox"
					<?php checked( $info_display, 'on' ); ?>/>
            </p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance                 = $old_instance;
			$instance['name_prefix']  = strip_tags( $new_instance['name_prefix'] );
			$instance['info_display'] = strip_tags( $new_instance['info_display'] );

			return $instance;
		}

	}
}