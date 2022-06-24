<?php
/**
 * My Properties Page
 *
 * Page template for my properties page.
 *
 * @since 2.7.0
 * @package realhomes/classic
 */

get_header(); ?>

<!-- Page Head -->
<?php get_template_part( 'assets/classic/partials/banners/default' ); ?>

<!-- Content -->
<div class="container contents single my-properties">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="row">
        <div class="span12 main-wrap">

			<?php
			if ( isset( $_GET['deleted'] ) && ( 1 == intval( $_GET['deleted'] ) ) ) {
				alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Property removed.', 'framework' ) );
			} elseif ( isset( $_GET['property-added'] ) && ( true == $_GET['property-added'] ) ) {
				alert( esc_html__( 'Success:', 'framework' ), inspiry_kses( get_option( 'theme_submit_message' ) ) );
			} elseif ( isset( $_GET['property-updated'] ) && ( true == $_GET['property-updated'] ) ) {
				alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Property Updated.', 'framework' ) );
			} elseif ( isset( $_GET['payment'] ) && ( 'paid' == $_GET['payment'] ) ) {
				alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Payment Submitted.', 'framework' ) );
			} elseif ( isset( $_GET['payment'] ) && ( 'failed' == $_GET['payment'] ) ) {
				alert( esc_html__( 'Error:', 'framework' ), esc_html__( 'Payment Failed.', 'framework' ) );
			}


			if ( class_exists( 'IMS_Helper_Functions' ) && is_user_logged_in() ) {

				// Membership enable option.
				$ims_helper_functions  = IMS_Helper_Functions();
				$is_memberships_enable = $ims_helper_functions::is_memberships();

				if ( ! empty( $is_memberships_enable ) ) {

					// Get current user.
					$ims_user = wp_get_current_user();

					// Get property numbers.
					$ims_membership = get_user_meta( $ims_user->ID, 'ims_current_membership', true );
					$ims_properties = get_user_meta( $ims_user->ID, 'ims_current_properties', true );
					$ims_featured   = get_user_meta( $ims_user->ID, 'ims_current_featured_props', true );

					$available_properties_heading          = esc_html__( 'Number of properties that you can publish:', 'framework' );
					$available_featured_properties_heading = esc_html__( 'Number of properties that can be marked as featured:', 'framework' );

					if ( ! empty( $ims_membership ) && ! empty( $ims_properties ) ) {
						$notices = array(
							'0' => array(
								'heading' => $available_properties_heading,
								'message' => $ims_properties,
							),
							'1' => array(
								'heading' => $available_featured_properties_heading,
								'message' => $ims_featured,
							),
						);
						display_notice( $notices );
					} elseif ( ! empty( $ims_membership ) && empty( $ims_properties ) ) {
						$notices = array(
							'0' => array(
								'heading' => $available_properties_heading,
								'message' => '',
							),
							'1' => array(
								'heading' => $available_featured_properties_heading,
								'message' => $ims_featured,
							),
						);
						display_notice( $notices );
					} elseif ( ! empty( $ims_membership ) && empty( $ims_featured ) ) {
						$notices = array(
							'0' => array(
								'heading' => $available_properties_heading,
								'message' => $ims_properties,
							),
							'1' => array(
								'heading' => $available_featured_properties_heading,
								'message' => '',
							),
						);
						display_notice( $notices );
					} elseif ( ! empty( $ims_membership ) && empty( $ims_properties ) && empty( $ims_featured ) ) {
						$notices = array(
							'0' => array(
								'heading' => $available_properties_heading,
								'message' => '',
							),
							'1' => array(
								'heading' => $available_featured_properties_heading,
								'message' => '',
							),
						);
						display_notice( $notices );
					} elseif ( empty( $ims_membership ) ) {
						alert( esc_html__( 'Please subscribe a membership package to start publishing properties.', 'framework' ) );
					}
				}
			}

			global $post;
			$title_display = get_post_meta( $post->ID, 'REAL_HOMES_page_title_display', true );
			if ( 'hide' !== $title_display ) {
				?>
                <h3><span><?php the_title(); ?></span></h3>
				<?php
			}
			?>

            <!-- Main Content -->
            <div class="main">
				<?php

				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();

						$content            = get_the_content();
						$page_content_class = '';
						if ( ! get_the_content() ) {
							$page_content_class = 'rh_mp_content_empty';
						}
						?>
                        <div class="inner-wrapper my-properties-wrapper <?php echo esc_attr( $page_content_class ); ?>">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
                            </article>
                        </div>
                        <!-- /.inner-wrapper -->
					<?php
					endwhile;
				endif;

				if ( is_user_logged_in() ) {

					global $paged;

					// Get current user.
					$current_user = wp_get_current_user();

					// My properties arguments.
					$my_props_args = array(
						'post_type'      => 'property',
						'posts_per_page' => 10,
						'paged'          => $paged,
						'post_status'    => array( 'pending', 'draft', 'publish', 'future' ),
						'author'         => $current_user->ID,
					);

					// Add searched parameter
					$my_properties_search = get_option( 'inspiry_my_properties_search', 'show' );
					$prop_searched        = false;
					if ( isset( $_GET['prop_search'] ) && 'show' == $my_properties_search ) {
						$my_props_args['s'] = sanitize_text_field( $_GET['prop_search'] );
						$prop_searched      = true;
					}

					$my_properties_query = new WP_Query( apply_filters( 'realhomes_my_properties', $my_props_args ) );

					if ( ( $my_properties_query->have_posts() && 'show' == $my_properties_search ) || true == $prop_searched ) {
						?>
                        <div id="my-properties-search-wrap">
                            <form id="my-properties-search" class="clearfix">
								<?php
								$prop_search = '';
								if ( isset( $_GET['prop_search'] ) ) {
									$prop_search = $_GET['prop_search'];
								}
								?>
                                <input type="text" name="prop_search" placeholder="<?php esc_html_e( 'Search in your properties', 'framework' ); ?>" value="<?php echo esc_attr( $prop_search ); ?>">
                                <input type="submit" value="<?php esc_html_e( 'Search', 'framework' ); ?>">
                            </form>
							<?php
							if ( isset( $_GET['prop_search'] ) && ! empty( $_GET['prop_search'] ) ) {
								?><h3><?php
								esc_html_e( 'Search results for: ', 'framework' );
								?><strong><?php echo esc_html( $_GET['prop_search'] ); ?></strong>
                                </h3><?php
							}
							?>
                        </div>
						<?php
					}

					if ( $my_properties_query->have_posts() ) :

						while ( $my_properties_query->have_posts() ) :

							$my_properties_query->the_post();
							?>
                            <div class="my-property clearfix">

                                <div class="property-thumb cell">
									<?php
									if ( has_post_thumbnail( $post->ID ) ) {
										the_post_thumbnail( 'property-thumb-image' );
									} else {
										inspiry_image_placeholder( 'property-thumb-image' );
									}
									?>
                                </div>

                                <div class="property-title cell">
                                    <h5><?php echo wp_trim_words( get_the_title(), 5 ); ?></h5>
                                </div>

                                <div class="property-date cell">
                                    <div class="cell-content">
                                        <i class="far fa-calendar-alt"></i>&nbsp;<?php esc_html_e( 'Posted on:', 'framework' ); ?>
                                        &nbsp;<?php the_time( get_option( 'date_format' ) ); ?></div>
                                </div>

                                <div class="property-publish-status cell">
                                    <div class="cell-content">
										<?php
										$property_statuses = get_post_statuses();
										$property_status   = get_post_status();
										echo esc_html( $property_statuses[ $property_status ] );
										?>
                                    </div>
                                </div>

                                <div class="property-controls">
									<?php
									/* Edit Post Link */
									$submit_url = inspiry_get_submit_property_url();
									if ( ! empty( $submit_url ) ) {
										$edit_link = esc_url( add_query_arg( 'edit_property', $post->ID, $submit_url ) );
										?>
                                        <a href="<?php echo esc_url( $edit_link ); ?>"><i class="fas fa-pencil-alt"></i></a>
										<?php
									}

									/* Preview Post Link */
									if ( current_user_can( 'edit_posts' ) ) {
										$preview_link = set_url_scheme( get_permalink( $post->ID ) );
										$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
										if ( ! empty( $preview_link ) ) {
											?>
                                            <a target="_blank" href="<?php echo esc_url( $preview_link ); ?>"><i class="fas fa-eye"></i></a>
											<?php
										}
									}

									/* Remove Property */
									if ( current_user_can( 'delete_posts' ) ) {
										?>
                                        <a class="remove-my-property"
                                           data-property-id="<?php the_ID(); ?>"
                                           href="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
                                           title="<?php esc_attr_e( 'Remove This Property', 'framework' ); ?>">
                                            <i class="fas fa-times remove"></i>
                                            <i class="fas fa-spinner fa-spin loader"></i>
                                        </a>
										<?php
									}
									?>
                                </div>

                                <div class="property-payment cell">
									<?php

									// Payment Status.
									$payment_status = get_post_meta( $post->ID, 'payment_status', true );

									if ( 'Completed' === $payment_status ) {
										echo '<h5>';
										esc_html_e( 'Payment Completed', 'framework' );
										echo '</h5>';
									} elseif ( ! class_exists( 'IMS_Helper_Functions' ) ) {

										// PayPal Payment Button.
										if ( function_exists( 'rpp_paypal_button' ) ) {
											rpp_paypal_button( get_the_ID() );
										}

										// Stripe Payment Button.
										if ( function_exists( 'isp_stripe_button' ) ) {
											isp_stripe_button( get_the_ID() );
										}

										/**
										 * This action hook is used to add more payment options
										 * for property submission.
										 *
										 * @since 2.6.4
										 */
										do_action( 'inspiry_property_payments', get_the_ID() );
									}
									?>
                                    <div class="ajax-response"></div>
                                </div>

                            </div>
						<?php

						endwhile;

						wp_reset_postdata();

					else :
						alert( esc_html__( 'Note:', 'framework' ), esc_html__( 'No Properties Found!', 'framework' ) );
					endif;

					theme_pagination( $my_properties_query->max_num_pages );

				} else {
					alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please, Login to view your properties!', 'framework' ) );
				}

				?>

            </div><!-- End Main Content -->

        </div> <!-- End span12 -->

    </div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>
