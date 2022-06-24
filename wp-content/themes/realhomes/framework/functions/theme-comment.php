<?php
if ( ! function_exists( 'theme_comment' ) ) {
	/**
	 * Custom comment template
	 *
	 * @param $comment
	 * @param $args
	 * @param $depth
	 */
	function theme_comment( $comment, $args, $depth ) {
		$GLOBALS[ 'comment' ] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="pingback">
					<p><?php esc_html_e( 'Pingback:', 'framework' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'framework' ), ' ' ); ?></p>
				</li>
				<?php
				break;
			default :
				?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>">

					<a href="<?php comment_author_url(); ?>">
						<?php echo get_avatar( $comment, 110 ); ?>
					</a>

					<div class="comment-detail-wrap">

						<span class="comment-detail-wrap-arrow"></span>

						<div class="comment-meta">
							<h5 class="author">
								<?php printf( esc_html__( '%s', 'framework' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</h5>
							<p>
								<span class="commented-on"><?php esc_html_e( 'on', 'framework' ); ?></span>
                                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<time datetime="<?php comment_time( 'c' ); ?>">
										<?php printf( esc_html__( '%1$s at %2$s', 'framework' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
                                <span class="commented"><?php esc_html_e( 'said', 'framework' ); ?></span>&nbsp;&nbsp;
							</p>
						</div>

						<div class="comment-body">
							<?php comment_text(); ?>
							<?php comment_reply_link( array_merge( array( 'before' => '' ), array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
						</div>

					</div>

				</article>
				<!-- end of comment -->
				<?php
				break;
		endswitch;
	}
}
