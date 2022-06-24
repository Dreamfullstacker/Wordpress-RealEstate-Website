<?php
/**
 * Displays contact template related stuff.
 *
 * @package realhomes
 */

get_header();

$header_variation = get_option( 'inspiry_contact_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}
?>
    <section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="rh_page">

			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
                <div class="rh_page__head">
                    <h2 class="rh_page__title"><?php the_title(); ?></h2>
                </div>
			<?php endif; ?>

            <div class="rh_page__contact">
				<?php
				// Retrieve Contact Page Meta
				$page_meta = get_post_custom( get_the_ID() );

				$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

				if ( $get_content_position !== '1' ) {

					if ( have_posts() ) :
						?>
                        <div class="rh_blog rh_blog__single">
							<?php while ( have_posts() ) : ?><?php the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" class="rh_blog__post">
                                    <div class="rh_content entry-content"><?php the_content(); ?></div>
                                </article>
							<?php endwhile; ?>
                        </div>
						<?php
					endif;
				}
				?>

                <div class="rh_contact">

                    <div class="rh_contact__wrap">

                        <div class="rh_contact__form">
							<?php
							/**
							 * Contact Form
							 */
							if ( isset( $page_meta['inspiry_contact_form_shortcode'] ) && ! empty( $page_meta['inspiry_contact_form_shortcode'][0] ) ) {

								/* Contact Form Shortcode */
								echo do_shortcode( $page_meta['inspiry_contact_form_shortcode'][0] );

							} else {

								// Default Contact Form.
								if ( isset( $page_meta['theme_contact_email'] ) && ! empty( $page_meta['theme_contact_email'][0] ) ) {
									$name_label                 = isset( $page_meta['theme_contact_form_name_label'] ) ? $page_meta['theme_contact_form_name_label'][0] : '';
									$email_label                = isset( $page_meta['theme_contact_form_email_label'] ) ? $page_meta['theme_contact_form_email_label'][0] : '';
									$number_label               = isset( $page_meta['theme_contact_form_number_label'] ) ? $page_meta['theme_contact_form_number_label'][0] : '';
									$message_label              = isset( $page_meta['theme_contact_form_message_label'] ) ? $page_meta['theme_contact_form_message_label'][0] : '';
									$contact_form_name_label    = empty( $name_label ) ? esc_html__( 'Name', 'framework' ) : $name_label;
									$contact_form_email_label   = empty( $email_label ) ? esc_html__( 'Email', 'framework' ) : $email_label;
									$contact_form_number_label  = empty( $number_label ) ? esc_html__( 'Phone Number', 'framework' ) : $number_label;
									$contact_form_message_label = empty( $message_label ) ? esc_html__( 'Message', 'framework' ) : $message_label;
									?>
                                    <section id="contact-form">
                                        <form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                                            <p class="rh_contact__input rh_contact__input_text">
                                                <label for="name"><?php echo esc_html( $contact_form_name_label ); ?></label>
                                                <input type="text" name="name" id="name" class="required" placeholder="<?php esc_attr_e( 'Your Name', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
                                            </p>

                                            <p class="rh_contact__input rh_contact__input_text">
                                                <label for="email"><?php echo esc_html( $contact_form_email_label ); ?></label>
                                                <input type="text" name="email" id="email" class="email required" placeholder="<?php esc_attr_e( 'Your Email', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide a valid email address', 'framework' ); ?>">
                                            </p>

                                            <p class="rh_contact__input rh_contact__input_text">
                                                <label for="number"><?php echo esc_html( $contact_form_number_label ); ?></label>
                                                <input type="text" name="number" id="number" placeholder="<?php esc_attr_e( 'Your Phone', 'framework' ); ?>">
                                            </p>

                                            <p class="rh_contact__input rh_contact__input_textarea">
                                                <label for="message"><?php echo esc_html( $contact_form_message_label ); ?></label>
                                                <textarea cols="40" rows="6" name="message" id="message" class="required" placeholder="<?php esc_attr_e( 'Your Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
                                            </p>

											<?php
											if ( function_exists( 'ere_gdpr_agreement' ) ) {
												ere_gdpr_agreement( array(
													'id'              => 'inspiry-gdpr',
													'container'       => 'p',
													'container_class' => 'rh_inspiry_gdpr',
													'title_class'     => 'gdpr-checkbox-label'
												) );
											}

											if ( class_exists( 'Easy_Real_Estate' ) ) {
												/* Display reCAPTCHA if enabled and configured from customizer settings */
												if ( ere_is_reCAPTCHA_configured() ) {
													$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
													?>
                                                    <div class="rh_contact__input rh_contact__input_recaptcha inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                                        <div class="inspiry-google-recaptcha"></div>
                                                    </div>
													<?php
												}
											}
											?>

                                            <p class="rh_contact__input rh_contact__submit">
                                                <input type="submit" id="submit-button" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>" class="rh_btn rh_btn--primary" name="submit">
                                                <span id="ajax-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>
                                                <input type="hidden" name="action" value="send_message"/>
                                                <input type="hidden" name="the_id" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
                                                <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'send_message_nonce' ) ); ?>"/>
                                            </p>

                                            <div id="error-container"></div>
                                            <div id="message-container"></div>
                                        </form>
                                    </section>
									<?php
								}
							}
							?>
                        </div>
                        <!-- /.rh_contact__form -->

						<?php
						$show_details = isset( $page_meta['theme_show_details'] ) ? $page_meta['theme_show_details'][0] : '';
						if ( $show_details ) {
							$contact_address       = stripslashes( isset( $page_meta['theme_contact_address'] ) ? $page_meta['theme_contact_address'][0] : '' );
							$contact_cell          = isset( $page_meta['theme_contact_cell'] ) ? $page_meta['theme_contact_cell'][0] : '';
							$contact_phone         = isset( $page_meta['theme_contact_phone'] ) ? $page_meta['theme_contact_phone'][0] : '';
							$contact_fax           = isset( $page_meta['theme_contact_fax'] ) ? $page_meta['theme_contact_fax'][0] : '';
							$contact_display_email = isset( $page_meta['theme_contact_display_email'] ) ? $page_meta['theme_contact_display_email'][0] : '';
							?>
                            <div class="rh_contact__details">

								<?php if ( ! empty( $contact_phone ) ) : ?>
                                    <div class="rh_contact__item">
                                        <div class="icon"><?php inspiry_safe_include_svg( '/images/icons/icon-phone.svg' ); ?></div>
                                        <p class="content">
                                            <span class="label"><?php esc_html_e( 'Phone', 'framework' ); ?></span><a
                                                    href="tel:<?php echo esc_html( $contact_phone ); ?>"><?php echo esc_html( $contact_phone ); ?>
                                            </a>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_cell ) ) : ?>
                                    <div class="rh_contact__item">
                                        <div class="icon"><?php inspiry_safe_include_svg( '/images/icons/icon-mobile.svg' ); ?></div>
                                        <p class="content">
                                            <span class="label"><?php esc_html_e( 'Mobile', 'framework' ); ?></span><a
                                                    href="tel:<?php echo esc_html( $contact_cell ); ?>"><?php
												echo esc_html( $contact_cell );
												?>
                                            </a>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_fax ) ) : ?>
                                    <div class="rh_contact__item">
                                        <div class="icon"><?php inspiry_safe_include_svg( '/images/icons/icon-fax.svg' ); ?></div>
                                        <p class="content">
                                            <span class="label"><?php esc_html_e( 'Fax', 'framework' ); ?></span><a
                                                    href="fax:<?php echo esc_html( $contact_fax ); ?>"><?php
												echo esc_html( $contact_fax );
												?>
                                            </a>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_display_email ) ) : ?>
                                    <div class="rh_contact__item">
                                        <div class="icon"><?php inspiry_safe_include_svg( '/images/icons/icon-mail.svg' ); ?></div>
                                        <p class="content">
											<span class="label"><?php
												esc_html_e( 'Email', 'framework' );
												?></span><a href="mailto:<?php echo esc_attr( antispambot( $contact_display_email ) ); ?>"><?php
												echo esc_html( antispambot( $contact_display_email ) );
												?></a>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_address ) ) : ?>
                                    <div class="rh_contact__item">
                                        <div class="icon"><?php inspiry_safe_include_svg( '/images/icons/icon-marker.svg' ); ?></div>
                                        <p class="content">
                                            <span class="label"><?php esc_html_e( 'Address', 'framework' ); ?></span><?php echo inspiry_kses( $contact_address ); ?>
                                        </p>
                                    </div>
								<?php endif; ?>

                            </div><!-- /.rh_contact__details -->
							<?php
						}


						/*
						 * Contact Map
						 */
						$show_contact_map = isset( $page_meta['theme_show_contact_map'] ) ? $page_meta['theme_show_contact_map'][0] : '';

						if ( $show_contact_map ) {
							?>
                            <!-- Map Container -->
                            <div class="rh_contact__map">
                                <!-- Works for Both Google Maps and Open Street Maps -->
                                <div id="map_canvas"></div>
                            </div><!-- /.rh_contact__map -->
							<?php
						}
						?>

                    </div><!-- /.rh_contact__wrap -->

                </div><!-- /.rh_contact -->

            </div><!-- /.rh_page__contact -->

        </div><!-- /.rh_page -->
		<?php

		if ( '1' === $get_content_position ) {

			if ( have_posts() ) :
				?>
                <div class="rh_blog rh_blog__single">
					<?php while ( have_posts() ) : ?><?php the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" class="rh_blog__post">
                            <div class="rh_content entry-content"><?php the_content(); ?></div>
                        </article>
					<?php endwhile; ?>
                </div>
				<?php
			endif;
		}
		?>

    </section><!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
