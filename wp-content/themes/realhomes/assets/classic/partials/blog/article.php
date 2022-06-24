<?php
/**
 * Blog Article
 *
 * Article on the main blog loop.
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;
$format = get_post_format();
if ( false === $format ) {
	$format = 'standard';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="post-header">
	    <?php if ( is_sticky() && is_home() ) : ?>
            <svg class="sticky-pin" viewBox="0 0 21 32" width="20px" height="20px">
                <path d="M8.571 15.429v-8q0-0.25-0.161-0.411t-0.411-0.161-0.411 0.161-0.161 0.411v8q0 0.25 0.161 0.411t0.411 0.161 0.411-0.161 0.161-0.411zM20.571 21.714q0 0.464-0.339 0.804t-0.804 0.339h-7.661l-0.911 8.625q-0.036 0.214-0.188 0.366t-0.366 0.152h-0.018q-0.482 0-0.571-0.482l-1.357-8.661h-7.214q-0.464 0-0.804-0.339t-0.339-0.804q0-2.196 1.402-3.955t3.17-1.759v-9.143q-0.929 0-1.607-0.679t-0.679-1.607 0.679-1.607 1.607-0.679h11.429q0.929 0 1.607 0.679t0.679 1.607-0.679 1.607-1.607 0.679v9.143q1.768 0 3.17 1.759t1.402 3.955z"></path>
            </svg>
	    <?php endif; ?>
        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </header>

	<?php get_template_part( "assets/classic/partials/blog/post-formats/$format" ); ?>

    <div class="post-meta">
        <span class="posted-on"><?php the_time( get_option( 'date_format' ) ); ?></span>
        <?php if ( get_the_category_list() ) : ?>
            <span class="posted-in">
                <?php esc_html_e( 'in', 'framework' ); ?>
                <?php the_category( ', ' ); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="post-summary">
	    <?php the_excerpt(); ?>
    </div>

    <footer class="post-footer clearfix">
        <div class="post-footer-left">
            <span class="byline">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, null, get_the_author(), array( 'class' => 'img-circle', ) ); ?>
                <span class="by"><?php esc_html_e( 'By', 'framework' ) ?></span>
                <span class="author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>'"><?php echo get_the_author(); ?></a></span>
            </span>
        </div>
        <div class="post-footer-right">
            <a class="real-btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'framework' ); ?></a>
        </div>
    </footer>
</article>