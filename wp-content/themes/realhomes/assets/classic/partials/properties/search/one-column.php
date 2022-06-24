<section class="listing-layout">
	<div class="list-container inner-wrapper clearfix">
		<?php
			global $search_query;
			if ( $search_query->have_posts() ) :
				while ( $search_query->have_posts() ) :
					$search_query->the_post();

					get_template_part( 'assets/classic/partials/properties/list-card' );

				endwhile;
				wp_reset_postdata();
			else :
				?>
                <div class="alert-wrapper">
					<?php
					$inspiry_search_template_no_result_text = get_option( 'inspiry_search_template_no_result_text' );

					if ( ! empty( $inspiry_search_template_no_result_text ) ) {
						?>
                        <h4><?php echo inspiry_kses( $inspiry_search_template_no_result_text ); ?></h4>
						<?php
					} else {
						?>
                        <h4><?php esc_html_e( 'No Property Found!', 'framework' ); ?></h4>
						<?php
					}
					?>
                </div>
				<?php
			endif;
		?>
	</div>
</section>