<?php
/**
 * Displays agency info for agency detail page.
 *
 * @package    realhomes
 * @subpackage modern
 */
global $post;
$agency_id = get_the_ID();

/* Agent Contact Info */
$agency_mobile       = get_post_meta( $agency_id, 'REAL_HOMES_mobile_number', true );
$agency_whatsapp     = get_post_meta( $agency_id, 'REAL_HOMES_whatsapp_number', true );
$agency_office_phone = get_post_meta( $agency_id, 'REAL_HOMES_office_number', true );
$agency_office_fax   = get_post_meta( $agency_id, 'REAL_HOMES_fax_number', true );
$agency_email        = get_post_meta( $agency_id, 'REAL_HOMES_agency_email', true );
$agency_address      = get_post_meta( $agency_id, 'REAL_HOMES_address', true );
$listed_properties   = 0;

if ( function_exists( 'ere_get_agency_properties_count' ) ) {
	$listed_properties = ere_get_agency_properties_count( $agency_id );
}
?>
<div class="rh_agent_profile">
    <article class="rh_agent_card">
        <div class="rh_agent_card__wrap">
            <div class="rh_agent_card__head">
				<?php if ( has_post_thumbnail( $agency_id ) ) : ?>
                    <figure class="rh_agent_card__dp">
                        <a title="<?php the_title_attribute(); ?>" href="<?php echo get_permalink( $agency_id ); ?>">
							<?php echo get_the_post_thumbnail( $agency_id, 'agent-image' ); ?>
                        </a>
                    </figure>
				<?php endif; ?>
                <div class="rh_agent_card__name">
                    <h4 class="name"><?php echo get_the_title( $agency_id ); ?></h4><!-- /.name -->
					<?php 
					$rh_agency_properties_count = get_option('inspiry_agencies_properties_count', 'show');
					if('show' === $rh_agency_properties_count) {?>
                    <div class="rh_agent_card__listings rh_agent_card__listings-inline">
                        <span class="count"><?php echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0; ?></span>
                        <span class="head"><?php ( 1 === $listed_properties ) ? esc_html_e( 'Listed Property', 'framework' ) : esc_html_e( 'Listed Properties', 'framework' ); ?></span>
                    </div>
					<?php } ?> 
                </div>
                <div class="social single-agent-profile-social social-networks-brand-color">
	                <?php
	                $facebook_url = get_post_meta( $agency_id, 'REAL_HOMES_facebook_url', true );
	                if ( ! empty( $facebook_url ) ) {
		                ?><a class="facebook" target="_blank" href="<?php echo esc_url( $facebook_url ); ?>"><i class="fab fa-facebook fa-lg"></i></a><?php
	                }

	                $twitter_url = get_post_meta( $agency_id, 'REAL_HOMES_twitter_url', true );
	                if ( ! empty( $twitter_url ) ) {
		                ?><a class="twitter" target="_blank" href="<?php echo esc_url( $twitter_url ); ?>"><i class="fab fa-twitter fa-lg"></i></a><?php
	                }

	                $linked_in_url = get_post_meta( $agency_id, 'REAL_HOMES_linked_in_url', true );
	                if ( ! empty( $linked_in_url ) ) {
		                ?><a class="linkedin" target="_blank" href="<?php echo esc_url( $linked_in_url ); ?>"><i class="fab fa-linkedin fa-lg"></i></a><?php
	                }

	                $instagram_url = get_post_meta( $agency_id, 'inspiry_instagram_url', true );
	                if ( ! empty( $instagram_url ) ) {
		                ?><a class="instagram" target="_blank" href="<?php echo esc_url( $instagram_url ); ?>"><i class="fab fa-instagram fa-lg"></i></a><?php
	                }

	                $agency_website = get_post_meta( $agency_id, 'REAL_HOMES_website', true );
	                if ( ! empty( $agency_website ) ) {
		                ?><a class="website-icon" target="_blank" href="<?php echo esc_url( $agency_website ); ?>"><i class="fas fa-globe fa-lg"></i></a><?php
	                }

	                $youtube_url = get_post_meta( $agency_id, 'inspiry_youtube_url', true );
	                if ( ! empty( $youtube_url ) ) {
		                ?><a class="youtube" target="_blank" href="<?php echo esc_url( $youtube_url ); ?>"><i class="fab fa-youtube-square fa-lg"></i></a><?php
	                }

	                $pinterest_url = get_post_meta( $agency_id, 'inspiry_pinterest_url', true );
	                if ( ! empty( $pinterest_url ) ) {
		                ?><a class="pinterest" target="_blank" href="<?php echo esc_url( $pinterest_url ); ?>"><i class="fab fa-pinterest fa-lg"></i></a><?php
	                }
	                ?>
                </div>
            </div>

            <div class="rh_content rh_agent_profile__excerpt">
				<?php the_content(); ?>
            </div>

            <div class="rh_agent_card__details">
                <div class="rh_agent_card__contact">
                    <div class="rh_agent_card__contact_wrap">
						<?php
						if ( ! empty( $agency_office_phone ) ) {
							?><p class="contact office"><?php esc_html_e( 'Office', 'framework' ); ?>: <a href="tel:<?php echo esc_attr( $agency_office_phone ); ?>"><?php echo esc_html( $agency_office_phone ); ?></a></p><?php
						}
						if ( ! empty( $agency_mobile ) ) {
							?><p class="contact mobile"><?php esc_html_e( 'Mobile', 'framework' ); ?>: <a href="tel:<?php echo esc_attr( $agency_mobile ); ?>"><?php echo esc_html( $agency_mobile ); ?></a></p><?php
						}
						if ( ! empty( $agency_office_fax ) ) {
							?><p class="contact fax"><?php esc_html_e( 'Fax', 'framework' ); ?>: <a href="tel:<?php echo esc_attr( $agency_office_fax ); ?>"><?php echo esc_html( $agency_office_fax ); ?></a></p><?php
						}
						if ( ! empty( $agency_whatsapp ) ) {
							?><p class="contact whatsapp"><?php esc_html_e( 'WhatsApp', 'framework' ); ?>: <a href="https://wa.me/<?php echo esc_attr( $agency_whatsapp ); ?>"><?php echo esc_html( $agency_whatsapp ); ?></a></p><?php
						}
						if ( ! empty( $agency_email ) ) {
							?><p class="contact email"><?php esc_html_e( 'Email', 'framework' ); ?>: <a href="mailto:<?php echo esc_attr( antispambot( $agency_email ) ); ?>"><?php echo esc_html( antispambot( $agency_email ) ); ?></a></p><?php
						}
						if ( ! empty( $agency_address ) ) {
							?><p class="contact address"><?php esc_html_e( 'Address', 'framework' ); ?>: <span><?php echo esc_html( $agency_address ); ?></span></p><?php
						}
						?>
                    </div>
                </div>
            </div>

            <div class="horizontal-border"></div>

            <div class="rh_agent_profile__contact_form">
	            <?php get_template_part( 'assets/modern/partials/agency/single/contact-form' ); ?>
            </div>
        </div>
    </article>
</div>