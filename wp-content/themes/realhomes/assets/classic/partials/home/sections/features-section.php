<?php
/**
 * Template: `Homepage Features`
 *
 * @package realhomes/classic
 * @since   2.6.2
 */

/**
 * Features Section Title and Description.
 */
$features_section_title = get_post_meta( get_the_ID(), 'inspiry_features_section_title', true );
$features_section_desc  = get_post_meta( get_the_ID(), 'inspiry_features_section_desc', true );
$features_list          = get_post_meta( get_the_ID(), 'inspiry_features', true );
?>

<div class="container">

	<div class="row">

		<div class="span12">

			<div class="main">

				<section class="home-features-section">

					<div class="home-features-bg">

						<div class="headings">

							<?php
							if ( ! empty( $features_section_title ) ) {
								echo '<h2 id="features-title">' . esc_html( $features_section_title ) . '</h2>';
							}
							if ( ! empty( $features_section_desc ) ) {
								echo '<p id="features-desc">' . wp_kses( $features_section_desc, inspiry_allowed_html() ) . '</p>';
							}
							?>

						</div>
						<!-- /.headings -->

						<div class="features-wrapper clearfix">

							<?php
							if ( ! empty( $features_list ) && is_array( $features_list ) ) {
	                            foreach ( $features_list as $feature ) {
		                            if ( ! empty( $feature['inspiry_feature_name'] ) || ! empty( $feature['inspiry_feature_icon'] ) || ! empty( $feature['inspiry_feature_desc'] ) ) : ?>

                                        <div class="span3 features-single">

				                            <?php if ( ! empty( $feature['inspiry_feature_icon'] ) ) : ?>
                                                <div class="feature-img">
						                            <?php if ( ! empty( $feature['inspiry_feature_link'] ) ) : ?>
                                                        <a href="<?php echo esc_url( $feature['inspiry_feature_link'] ); ?>">
                                                            <img src="<?php echo esc_url( wp_get_attachment_url( $feature['inspiry_feature_icon'][0] ) ); ?>"
                                                                 alt="<?php echo esc_html( $feature['inspiry_feature_name'] ); ?>"/>
                                                        </a>
						                            <?php else : ?>
                                                        <img src="<?php echo esc_url( wp_get_attachment_url( $feature['inspiry_feature_icon'][0] ) ); ?>"
                                                             alt="<?php echo esc_html( $feature['inspiry_feature_name'] ); ?>"/>
						                            <?php endif; ?>
                                                </div>
                                                <!-- /.feature-img -->
				                            <?php endif; ?>

                                            <div class="feature-content">
					                            <?php
					                            if ( ! empty( $feature['inspiry_feature_name'] ) ) {
						                            if ( ! empty( $feature['inspiry_feature_link'] ) ) {
							                            echo '<a href="' . esc_url( $feature['inspiry_feature_link'] ) . '"><h4>' . esc_html( $feature['inspiry_feature_name'] ) . '</h4></a>';
						                            } else {
							                            echo '<h4>' . esc_html( $feature['inspiry_feature_name'] ) . '</h4>';
						                            }
					                            }
					                            if ( ! empty( $feature['inspiry_feature_desc'] ) ) {
						                            echo '<p>' . wp_kses( $feature['inspiry_feature_desc'], inspiry_allowed_html() ) . '</p>';
					                            }
					                            ?>
                                            </div>
                                            <!-- /.feature-content -->

                                        </div>
                                        <!-- /.features-single -->

		                            <?php endif;
	                            }
                            }
							?>
						</div>
						<!-- /.features-wrapper -->

					</div>
					<!-- /.home-features-bg -->

				</section>
				<!-- /.home-features-section -->

			</div>
			<!-- /.main -->

		</div>
		<!-- /.span12 -->

	</div>
	<!-- /.row -->

</div>
<!-- /.container -->