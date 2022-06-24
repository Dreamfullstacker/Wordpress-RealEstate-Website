<?php
/**
 * Author Head Card
 *
 * Head card for author template.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

// Get Author Information.
$current_author      = $wp_query->get_queried_object();
$current_author_id   = $current_author->ID;
$current_author_meta = get_user_meta( $current_author_id );

$facebook_url 		= ( isset( $current_author_meta['facebook_url'] ) ) ? $current_author_meta['facebook_url'][0] : false;
$twitter_url 		= ( isset( $current_author_meta['twitter_url'] ) ) ? $current_author_meta['twitter_url'][0] : false;
$linked_in_url 		= ( isset( $current_author_meta['linkedin_url'] ) ) ? $current_author_meta['linkedin_url'][0] : false;
$instagram_url 		= ( isset( $current_author_meta['instagram_url'] ) ) ? $current_author_meta['instagram_url'][0] : false;
$youtube_url 		= ( isset( $current_author_meta['youtube_url'] ) ) ? $current_author_meta['youtube_url'][0] : false;
$pinterest_url 		= ( isset( $current_author_meta['pinterest_url'] ) ) ? $current_author_meta['pinterest_url'][0] : false;

/* Agent Contact Info */
$agent_mobile       = ( isset( $current_author_meta['mobile_number'] ) ) ? $current_author_meta['mobile_number'][0] : false;
$agent_office_phone = ( isset( $current_author_meta['office_number'] ) ) ? $current_author_meta['office_number'][0] : false;
$agent_office_fax   = ( isset( $current_author_meta['fax_number'] ) ) ? $current_author_meta['fax_number'][0] : false;
$agent_whatsapp     = ( isset( $current_author_meta['whatsapp_number'] ) ) ? $current_author_meta['whatsapp_number'][0] : false;
$agent_address      = ( isset( $current_author_meta['inspiry_user_address'] ) ) ? $current_author_meta['inspiry_user_address'][0] : false;
$agent_email        = is_email( $current_author->user_email );
?>
<div class="rh_agent_profile">
    <article class="rh_agent_card">
        <div class="rh_agent_card__wrap">
            <div class="rh_agent_card__head">
                <figure class="rh_agent_card__dp picture">
		            <?php
		            // Author profile image.
		            if ( isset( $current_author_meta['profile_image_id'] ) ) {
			            $profile_image_id = intval( $current_author_meta['profile_image_id'][0] );
			            if ( $profile_image_id ) {
				            echo wp_get_attachment_image( $profile_image_id, 'agent-image' );
			            }
		            } elseif ( function_exists( 'get_avatar' ) ) {
			            echo get_avatar( $current_author->user_email, '210' );
		            }
		            ?>
                </figure>
                <div class="rh_agent_card__name">
	                <?php if ( ! empty( $current_author->display_name ) ) : ?>
                        <h3 class="name"><?php echo esc_html( $current_author->display_name ); ?></h3>
	                <?php endif; ?>
	                <?php
	                if ( isset( $current_author_meta['inspiry_user_role'] ) && 'agent' == $current_author_meta['inspiry_user_role'] ) {
		                $listed_properties = 0;
		                $agent_id          = ( isset( $current_author_meta['inspiry_role_post_id'] ) ) ? $current_author_meta['inspiry_role_post_id'][0] : false;
		                if ( function_exists( 'ere_get_agent_properties_count' ) ) {
			                $listed_properties = ere_get_agent_properties_count( $agent_id );
		                }
		                ?>

						<?php 
						$rh_agent_properties_count = get_option( 'inspiry_agent_properties_count', 'show' );
						if ( 'show' === $rh_agent_properties_count ) { ?>
                        <div class="rh_agent_card__listings rh_agent_card__listings-inline">
                            <span class="count"><?php echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0; ?></span>
                            <span class="head"><?php ( 1 === $listed_properties ) ? esc_html_e( 'Listed Property', 'framework' ) : esc_html_e( 'Listed Properties', 'framework' ); ?></span>
                        </div>
		                <?php
						}
	                }
	                ?>
                </div>
                <div class="social single-agent-profile-social">
		            <?php
		            if ( ! empty( $facebook_url ) ) {
			            ?><a target="_blank" href="<?php echo esc_url( $facebook_url ); ?>"><i class="fab fa-facebook fa-lg"></i></a><?php
		            }

		            if ( ! empty( $twitter_url ) ) {
			            ?><a target="_blank" href="<?php echo esc_url( $twitter_url ); ?>" ><i class="fab fa-twitter fa-lg"></i></a><?php
		            }

		            if ( ! empty( $linked_in_url ) ) {
			            ?><a target="_blank" href="<?php echo esc_url( $linked_in_url ); ?>"><i class="fab fa-linkedin fa-lg"></i></a><?php
		            }

		            if ( ! empty( $instagram_url ) ) {
			            ?><a target="_blank" href="<?php echo esc_url( $instagram_url ); ?>"><i class="fab fa-instagram fa-lg"></i></a><?php
		            }

		            if ( ! empty( $youtube_url ) ) {
		                ?><a target="_blank" href="<?php echo esc_url( $youtube_url ); ?>"><i class="fab fa-youtube-square fa-lg"></i></a><?php
		            }

		            if ( ! empty( $pinterest_url ) ) {
		                ?><a target="_blank" href="<?php echo esc_url( $pinterest_url ); ?>"><i class="fab fa-pinterest fa-lg"></i></a><?php
		            }

		            $authordata = get_userdata( $current_author_id );
		            if ( isset( $authordata->user_url ) && ! empty( $authordata->user_url ) ) {
			            ?><a target="_blank" href="<?php echo esc_url( $authordata->user_url ); ?>"><i class="fas fa-globe fa-lg"></i></a><?php
		            }
		            ?>
                </div>
            </div>

	        <?php if ( isset( $current_author_meta['description'] ) ) : ?>
                <div class="rh_content rh_agent_profile__excerpt">
                    <p><?php echo esc_html( $current_author_meta['description'][0] ); ?></p>
                </div>
	        <?php endif; ?>

            <div class="rh_agent_card__details">
                <div class="rh_agent_card__contact">
                    <div class="rh_agent_card__contact_wrap">
	                    <?php if ( ! empty( $agent_office_phone ) ) : ?>
                            <p class="contact office"><?php esc_html_e( 'Office', 'framework' ); ?>: <span><?php echo esc_html( $agent_office_phone ); ?></span></p>
	                    <?php endif; ?>

	                    <?php if ( ! empty( $agent_mobile ) ) : ?>
                            <p class="contact mobile"><?php esc_html_e( 'Mobile', 'framework' ); ?>: <span><?php echo esc_html( $agent_mobile ); ?></span></p>
	                    <?php endif; ?>

	                    <?php if ( ! empty( $agent_office_fax ) ) : ?>
                            <p class="contact fax"><?php esc_html_e( 'Fax', 'framework' ); ?>: <span><?php echo esc_html( $agent_office_fax ); ?></span></p>
	                    <?php endif; ?>

	                    <?php if ( ! empty( $agent_whatsapp ) ) : ?>
                            <p class="contact whatsapp"><?php esc_html_e( 'Whatsapp', 'framework' ); ?>: <a href="https://wa.me/<?php echo esc_url( $agent_whatsapp ); ?>"><?php echo esc_html( $agent_whatsapp ); ?></a></p>
	                    <?php endif; ?>

	                    <?php if ( $agent_email ) : ?>
                            <p class="contact email"><?php esc_html_e( 'Email', 'framework' ); ?>: <a href="mailto:<?php echo antispambot( $agent_email ); ?>"><?php echo antispambot( $agent_email ); ?></a></p>
	                    <?php endif; ?>

	                    <?php if ( ! empty( $agent_address ) ) : ?>
                            <p class="contact address"><?php esc_html_e( 'Address', 'framework' ); ?>: <span><?php echo esc_html( $agent_address ); ?></span></p>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="horizontal-border"></div>

	        <?php if ( $agent_email ) : ?>
                <div class="rh_agent_profile__contact_form">
                    <div class="rh_agent_form">
                        <form id="agent-single-form" class="" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                            <div class="rh_agent_form__field rh_agent_form__text">
                                <label for="name"><?php esc_html_e( 'Name', 'framework' ); ?></label>
                                <input type="text" name="name" id="name" placeholder="<?php esc_attr_e( 'Your Name', 'framework' ); ?>" class="required" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
                            </div>
                            <div class="rh_agent_form__field rh_agent_form__text">
                                <label for="email"><?php esc_html_e( 'Email', 'framework' ); ?></label>
                                <input type="text" name="email" id="email" placeholder="<?php esc_attr_e( 'Your Email', 'framework' ); ?>" class="email required" title="<?php esc_attr_e( '* Please provide valid email address', 'framework' ); ?>">
                            </div>
                            <div class="rh_agent_form__field rh_agent_form__text">
                                <label for="phone"><?php esc_html_e( 'Phone', 'framework' ); ?></label>
                                <input type="text" name="phone" id="phone" placeholder="<?php esc_attr_e( 'Your Phone', 'framework' ); ?>" class="digits required" title="<?php esc_attr_e( '* Please provide valid phone number', 'framework' ); ?>">
                            </div>
                            <div class="rh_agent_form__field rh_agent_form__textarea">
                                <label for="comment"><?php esc_html_e( 'Message', 'framework' ); ?></label>
                                <textarea rows="6" name="message" id="comment" class="required" placeholder="<?php esc_attr_e( 'Your Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
                            </div>
	                        <?php
	                        if ( function_exists( 'ere_gdpr_agreement' ) ) {
		                        ere_gdpr_agreement( array(
			                        'id'              => 'rh_inspiry_gdpr',
			                        'container_class' => 'rh_inspiry_gdpr',
			                        'title_class'     => 'gdpr-checkbox-label'
		                        ) );
	                        }

	                        if ( class_exists( 'Easy_Real_Estate' ) ) {
		                        if ( ere_is_reCAPTCHA_configured() ) {
			                        $recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
			                        ?>
                                    <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"></div>
                                    </div>
			                        <?php
		                        }
	                        }
	                        ?>
                            <div class="rh_agent_form__row">
                                <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
                                <input type="hidden" name="target" value="<?php echo antispambot( $agent_email ); ?>">
                                <input type="hidden" name="action" value="send_message_to_agent" />
						        <?php
						        if ( ! empty( $current_author_id ) ) {
							        ?><input type="hidden" name="author_id" value="<?php echo esc_attr( $current_author_id ) ?>"><?php
						        }
						        ?>
                                <input type="submit" id="submit-button" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>"  name="submit" class="rh_btn rh_btn--primary">
                                <span id="ajax-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>
                            </div>
                            <div class="rh_agent_form__row">
                                <div id="error-container"></div>
                                <div id="message-container"></div>
                            </div>
                        </form>
                    </div>
                </div>
	        <?php endif; ?>
        </div>
    </article>
</div>