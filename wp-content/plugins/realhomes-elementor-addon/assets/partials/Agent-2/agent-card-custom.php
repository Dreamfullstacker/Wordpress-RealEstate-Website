<?php
global $agent;
?>
<article class="rhea_agent_two">
    <div class="rhea_agent_two_wrap">

		<?php if ( $agent['rhea_agent_image'] ) { ?>
            <div class="rhea_agent_two_thumbnail">
				<?php
				if ( $agent['rhea_agent_url']['url'] && ! empty( $agent['rhea_agent_url']['url'] ) ) {
					$agent_target            = $agent['rhea_agent_url']['is_external'] ? ' target="_blank"' : '';
					$agent_nofollow          = $agent['rhea_agent_url']['nofollow'] ? ' rel="nofollow"' : '';
					$agent_custom_attributes = $agent['rhea_agent_url']['custom_attributes'] ? $agent['rhea_agent_url']['custom_attributes'] : ' ';

					?>
                    <a class="rhea_agent_two_thumb" href="<?php echo esc_url( $agent['rhea_agent_url']['url'] ) ?>"
						<?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>>
						<?php
						echo wp_get_attachment_image( $agent['rhea_agent_image']['id'], 'agent-image' );
						?>
                    </a>
					<?php
				} else {
					?>
                    <span class="rhea_agent_two_thumb">
		            <?php
		            echo wp_get_attachment_image( $agent['rhea_agent_image']['id'], 'agent-image' );
		            ?>
                    </span>
					<?php
				}
				?>
            </div>
			<?php
		}
		?>

        <div class="rhea_agent_two_details">

			<?php if ( $agent['rhea_agent_title'] ) { ?>
                <h3 class="rhea_agent_two_title">
					<?php
					if ( $agent['rhea_agent_url']['url'] && ! empty( $agent['rhea_agent_url']['url'] ) ) {
						$agent_title_target            = $agent['rhea_agent_url']['is_external'] ? ' target="_blank"' : '';
						$agent_title_nofollow          = $agent['rhea_agent_url']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_title_custom_attributes = $agent['rhea_agent_url']['custom_attributes'] ? $agent['rhea_agent_url']['custom_attributes'] : ' ';

						?>
                        <a href="<?php echo esc_url( $agent['rhea_agent_url']['url'] ) ?>"
							<?php echo esc_attr( $agent_title_target ) . ' ' . esc_attr( $agent_title_nofollow ) . ' ' . esc_attr( $agent_title_custom_attributes ); ?>>
							<?php echo esc_html( $agent['rhea_agent_title'] ); ?>
                        </a>
						<?php
					} else {
						?>
                        <span><?php echo esc_html( $agent['rhea_agent_title'] ); ?></span>
						<?php
					}
					?>
                </h3>
				<?php
			}
			if ( $agent['rhea_agent_sub_title'] ) {
				?>
                <span class="rhea_agent_designation"><?php echo esc_html( $agent['rhea_agent_sub_title'] ); ?></span>
				<?php
			}

			if ( $agent['rhea_agent_facebook']['url'] ||
			     $agent['rhea_agent_twitter']['url'] ||
			     $agent['rhea_agent_linkedin']['url'] ||
			     $agent['rhea_agent_instagram']['url'] ||
			     $agent['rhea_agent_pinterest']['url'] ||
			     $agent['rhea_agent_youtube']['url']

			) {
				?>
                <ul class="rhea_agent_two_socials">
					<?php
					if ( $agent['rhea_agent_facebook']['url'] ) {
						$agent_fb_target            = $agent['rhea_agent_facebook']['is_external'] ? ' target="_blank"' : '';
						$agent_fb_nofollow          = $agent['rhea_agent_facebook']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_fb_custom_attributes = $agent['rhea_agent_facebook']['custom_attributes'] ? $agent['rhea_agent_facebook']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_facebook">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_facebook']['url'] ); ?>"
								<?php echo esc_attr( $agent_fb_target ) . ' ' . esc_attr( $agent_fb_nofollow ) . ' ' . esc_attr( $agent_fb_custom_attributes ); ?>>
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					if ( $agent['rhea_agent_twitter']['url'] ) {
						$agent_twitter_target            = $agent['rhea_agent_twitter']['is_external'] ? ' target="_blank"' : '';
						$agent_twitter_nofollow          = $agent['rhea_agent_twitter']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_twitter_custom_attributes = $agent['rhea_agent_twitter']['custom_attributes'] ? $agent['rhea_agent_twitter']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_twitter">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_twitter']['url'] ); ?>"
								<?php echo esc_attr( $agent_twitter_target ) . ' ' . esc_attr( $agent_twitter_nofollow ) . ' ' . esc_attr( $agent_twitter_custom_attributes ); ?>>
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					if ( $agent['rhea_agent_linkedin']['url'] ) {
						$agent_in_target            = $agent['rhea_agent_linkedin']['is_external'] ? ' target="_blank"' : '';
						$agent_in_nofollow          = $agent['rhea_agent_linkedin']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_in_custom_attributes = $agent['rhea_agent_linkedin']['custom_attributes'] ? $agent['rhea_agent_linkedin']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_linkedin">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_linkedin']['url'] ); ?>"
								<?php echo esc_attr( $agent_in_target ) . ' ' . esc_attr( $agent_in_nofollow ) . ' ' . esc_attr( $agent_in_custom_attributes ); ?>>
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					if ( $agent['rhea_agent_instagram']['url'] ) {
						$agent_insta_target            = $agent['rhea_agent_instagram']['is_external'] ? ' target="_blank"' : '';
						$agent_insta_nofollow          = $agent['rhea_agent_instagram']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_insta_custom_attributes = $agent['rhea_agent_instagram']['custom_attributes'] ? $agent['rhea_agent_instagram']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_instagram">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_instagram']['url'] ); ?>"
								<?php echo esc_attr( $agent_insta_target ) . ' ' . esc_attr( $agent_insta_nofollow ) . ' ' . esc_attr( $agent_insta_custom_attributes ); ?>>
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					if ( $agent['rhea_agent_pinterest']['url'] ) {
						$agent_pi_target            = $agent['rhea_agent_pinterest']['is_external'] ? ' target="_blank"' : '';
						$agent_pi_nofollow          = $agent['rhea_agent_pinterest']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_pi_custom_attributes = $agent['rhea_agent_pinterest']['custom_attributes'] ? $agent['rhea_agent_pinterest']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_pinterest">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_pinterest']['url'] ); ?>"
								<?php echo esc_attr( $agent_pi_target ) . ' ' . esc_attr( $agent_pi_nofollow ) . ' ' . esc_attr( $agent_pi_custom_attributes ); ?>>
                                <i class="fab fa-pinterest fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					if ( $agent['rhea_agent_youtube']['url'] ) {
						$agent_yt_target            = $agent['rhea_agent_youtube']['is_external'] ? ' target="_blank"' : '';
						$agent_yt_nofollow          = $agent['rhea_agent_youtube']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_yt_custom_attributes = $agent['rhea_agent_youtube']['custom_attributes'] ? $agent['rhea_agent_youtube']['custom_attributes'] : ' ';
						?>
                        <li class="rhea_item_youtube">
                            <a target="_blank" href="<?php echo esc_url( $agent['rhea_agent_youtube']['url'] ); ?>"
								<?php echo esc_attr( $agent_yt_target ) . ' ' . esc_attr( $agent_yt_nofollow ) . ' ' . esc_attr( $agent_yt_custom_attributes ); ?>>
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                        </li>
						<?php
					}
					?>
                </ul>

				<?php
			}
			if ( $agent['rhea_agent_excerpt'] ) {
				?>
                <p class="rhea_agent_two_excerpt"><?php echo esc_html( $agent['rhea_agent_excerpt'] ); ?></p>

				<?php
			}
			if ( $agent['rhea_agent_phone'] && ! empty( $agent['rhea_agent_phone'] ) ) {

				?>
                <div class="rhe_agent_two_phone">
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:<?php echo esc_attr( $agent['rhea_agent_phone'] ); ?>">
						<?php echo esc_html( $agent['rhea_agent_phone'] ); ?>
                    </a>
                </div>

				<?php
			}
			if ( $agent['rhea_agent_email'] && ! empty( $agent['rhea_agent_email'] ) ) {
				?>
                <div class="rhea_agent_two_email">
                    <i class="fas fa-envelope"></i><a
                            href="mailto:<?php echo esc_attr( antispambot( $agent['rhea_agent_email'] ) ); ?>">
						<?php echo esc_html( antispambot( $agent['rhea_agent_email'] ) ); ?>
                    </a>
                </div>
			<?php } ?>

        </div>
    </div>
</article>