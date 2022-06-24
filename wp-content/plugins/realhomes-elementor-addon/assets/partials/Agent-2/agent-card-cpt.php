<?php
global $settings;
global $agent;
$agent_id     = intval( $agent['rhea_select_agent'] );
$agent_mobile = get_post_meta( $agent_id, 'REAL_HOMES_mobile_number', true );
$agent_email  = get_post_meta( $agent_id, 'REAL_HOMES_agent_email', true );

?>
<article class="rhea_agent_two">
    <div class="rhea_agent_two_wrap">
		<?php
		if ( has_post_thumbnail( $agent_id ) ) {
			?>
            <div class="rhea_agent_two_thumbnail">
                <a href="<?php echo get_the_permalink( $agent_id ); ?>">
					<?php
					echo get_the_post_thumbnail( $agent_id, 'agent-image' );
					?>
                </a>
            </div>
			<?php
		}
		?>
        <div class="rhea_agent_two_details">

			<?php if ( $agent_id ) { ?>
                <h3 class="rhea_agent_two_title"><a
                            href="<?php echo get_the_permalink( $agent_id ); ?>"><?php echo get_the_title( $agent_id ); ?></a>
                </h3>
			<?php } ?>
			<?php
			if ( $agent['rhea_agent_sub_title'] ) {
				?>
                <span class="rhea_agent_designation"><?php echo esc_html( $agent['rhea_agent_sub_title'] ); ?></span>
				<?php
			}
			if ( 'yes' == $agent['show_social_icons'] ) {
				$facebook_url  = get_post_meta( $agent_id, 'REAL_HOMES_facebook_url', true );
				$twitter_url   = get_post_meta( $agent_id, 'REAL_HOMES_twitter_url', true );
				$linked_in_url = get_post_meta( $agent_id, 'REAL_HOMES_linked_in_url', true );
				$instagram_url = get_post_meta( $agent_id, 'inspiry_instagram_url', true );
				$pintrest_url  = get_post_meta( $agent_id, 'inspiry_pinterest_url', true );
				$youtube_url   = get_post_meta( $agent_id, 'inspiry_youtube_url', true );

				if ( ! empty( $facebook_url ) ||
				     ! empty( $twitter_url ) ||
				     ! empty( $linked_in_url ) ||
				     ! empty( $pintrest_url ) ||
				     ! empty( $youtube_url ) ||
				     ! empty( $instagram_url ) ) {

					?>
                    <ul class="rhea_agent_two_socials">
						<?php
						if ( ! empty( $facebook_url ) ) {
							?>
                            <li class="rhea_item_facebook"><a target="_blank" href="<?php echo esc_url( $facebook_url ); ?>"><i
                                            class="fab fa-facebook fa-lg"></i></a></li>
							<?php
						}
						if ( ! empty( $twitter_url ) ) {
							?>
                            <li class="rhea_item_twitter"><a target="_blank" href="<?php echo esc_url( $twitter_url ); ?>"><i
                                            class="fab fa-twitter fa-lg"></i></a></li>
							<?php
						}
						if ( ! empty( $linked_in_url ) ) {
							?>
                            <li class="rhea_item_linkedin"><a target="_blank" href="<?php echo esc_url( $linked_in_url ); ?>"><i
                                            class="fab fa-linkedin fa-lg"></i></a></li>
							<?php
						}
						if ( ! empty( $instagram_url ) ) {
							?>
                            <li class="rhea_item_instagram"><a target="_blank" href="<?php echo esc_url( $instagram_url ); ?>"><i
                                            class="fab fa-instagram fa-lg"></i></a></li>
							<?php
						}
						if ( ! empty( $pintrest_url ) ) {
							?>
                            <li class="rhea_item_pinterest"><a target="_blank" href="<?php echo esc_url( $pintrest_url ); ?>"><i
                                            class="fab fa-pinterest fa-lg"></i></a></li>
							<?php
						}
						if ( ! empty( $youtube_url ) ) {
							?>
                            <li class="rhea_item_youtube"><a target="_blank" href="<?php echo esc_url( $youtube_url ); ?>"><i
                                            class="fab fa-youtube fa-lg"></i></a></li>
							<?php
						}
						?>
                    </ul>
					<?php
				}
			}
			if ( 'yes' == $agent['show_excerpt'] ) {
				if ( $agent['rhea_agent_excerpt'] && ! empty( $agent['rhea_agent_excerpt'] ) ) {
					?>
                    <p class="rhea_agent_two_excerpt"><?php echo esc_html( $agent['rhea_agent_excerpt'] ); ?></p>
					<?php
				} elseif (($agent_id) && ! empty( get_the_excerpt( $agent_id ) ) ) {
					?>
                    <p class="rhea_agent_two_excerpt"><?php echo rhea_get_framework_excerpt_by_id( $agent_id, $agent['excerpt_length'] ); ?></p>
					<?php
				}
			}
			if ( 'yes' == $agent['show_phone_number'] ) {
				if ( ! empty( $agent_mobile ) ) {
					?>
                    <div class="rhe_agent_two_phone">
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:<?php echo esc_html( $agent_mobile ); ?>"><?php echo esc_html( $agent_mobile ); ?></a>
                    </div>

					<?php
				}
			}
			if ( 'yes' == $agent['show_email_id'] ) {
				if ( ! empty( $agent_email ) ) {
					?>
                    <div class="rhea_agent_two_email">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo esc_attr( antispambot( $agent_email ) ); ?>">
							<?php echo esc_html( antispambot( $agent_email ) ); ?>
                        </a>
                    </div>
					<?php
				}
			}
			?>

        </div>
    </div>
</article>