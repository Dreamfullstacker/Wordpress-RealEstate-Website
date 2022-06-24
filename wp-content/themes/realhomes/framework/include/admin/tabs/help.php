<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quick_links = array(
	'links' => array(
		array(
			'title' => 'Support',
			'link'  => 'https://support.inspirythemes.com/'
		),
	),
);

$documentation_postbox = array(
	'links' => array(
		array(
			'title' => 'Documentation',
			'link'  => 'https://realhomes.io/documentation/'
		)
	),
	'posts_heading' => 'Useful Links',
	'posts' => array(
		array(
			'title' => 'Installation',
			'link'  => 'https://realhomes.io/documentation/installation-and-activation/'
		),
		array(
			'title' => 'Demo Import',
			'link'  => 'https://realhomes.io/documentation/import-demo/'
		),
		array(
			'title' => 'Add New Property',
			'link'  => 'https://realhomes.io/documentation/add-property/'
		),
		array(
			'title' => 'Price Format',
			'link'  => 'https://realhomes.io/documentation/price-format-settings/'
		),
		array(
			'title' => 'Performance',
			'link'  => 'https://realhomes.io/documentation/#few-performance-improvement-tips'
		),
	)
);

$knowledge_base_postbox = array(
	'links' => array(
		array(
			'title' => 'Knowledge Base',
			'link'  => 'https://support.inspirythemes.com/knowledgebase-category/real-homes-theme/'
		)
	),
	'posts_heading' => 'Common Topics',
	'posts' => array(
        array(
			'title' => 'How to Update RealHomes Theme Safely',
			'link'  => 'https://support.inspirythemes.com/knowledgebase/how-to-update-real-homes-theme-safely/',
		),
		array(
			'title' => 'How to Fix SSL Related Problems',
			'link'  => 'https://support.inspirythemes.com/knowledgebase/how-to-fix-ssl-related-problems/ '
		),
		array(
			'title' => 'How to Inspect Element to Change CSS Properties',
			'link'  => 'https://support.inspirythemes.com/knowledgebase/how-to-inspect-element-to-change-css-properties/'
		),
		array(
			'title' => 'How to Translate Your Website',
			'link'  => 'https://support.inspirythemes.com/knowledgebase/how-to-translate-your-theme-to-your-language/'
		),
        array(
	        'title' => 'Extending and Renewing Theme Support',
	        'link'  => 'https://support.inspirythemes.com/knowledgebase/extend-renew-support/'
        ),
	)
);

$how_to_get_help = array(
	'posts_heading' => 'How to Get Support',
	'posts' => array(
		array(
            'description' => 'You need to <a href="https://support.inspirythemes.com/login-register/" target="_blank">register at our support website</a> and <a href="https://support.inspirythemes.com/ask-question/" target="_blank">ask your question</a> over there to get support from Inspiry Themes team.',
		)
	)
);

$extend_support = array(
	'posts_heading' => 'Extend and Renew Theme Support',
	'posts' => array(
		array(
			'description' => sprintf( 'RealHomes comes with 6 months of free support with your purchase. Support can be <a href="%s" target="_blank">extended or renewed</a> via themeforest.', esc_url( 'https://support.inspirythemes.com/knowledgebase/extend-renew-support/' ) )
		),
	)
);
?>
<?php $this->header('help'); ?>
<div class="inspiry-page-inner-wrap inspiry-help-content-wrap">
    <h2 class="inspiry-title"><?php esc_html_e( 'Welcome to Inspiry Help Desk!', 'framework' ); ?></h2>
    <div class="row">
        <div class="col-3">
            <div class="inspiry-postbox postbox">
                <div class="inspiry-postbox-header">
                    <h2 class="title"><span aria-hidden="true" class="dashicons dashicons-book"></span><?php echo esc_html( 'User Guide' ); ?></h2>
                </div>
                <div class="inspiry-postbox-inside inside">
				    <?php $this->inspiry_postbox_posts( $documentation_postbox['posts'], $documentation_postbox['posts_heading'] ); ?>
                </div>
                <div class="inspiry-postbox-footer">
				    <?php $this->inspiry_quick_links( $documentation_postbox['links'] ); ?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="inspiry-postbox postbox">
                <div class="inspiry-postbox-header">
                    <h2 class="title"><span aria-hidden="true" class="dashicons dashicons-book-alt"></span><?php echo esc_html( 'Knowledge Base' ); ?></h2>
                </div>
                <div class="inspiry-postbox-inside inside">
				    <?php $this->inspiry_postbox_posts( $knowledge_base_postbox['posts'], $knowledge_base_postbox['posts_heading'] ); ?>
                </div>
                <div class="inspiry-postbox-footer">
				    <?php $this->inspiry_quick_links( $knowledge_base_postbox['links'] ); ?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="inspiry-postbox postbox">
                <div class="inspiry-postbox-header">
                    <h2 class="title"><span aria-hidden="true" class="dashicons dashicons-sos"></span><?php echo esc_html( 'Get Support' ); ?></h2>
                </div>
                <div class="inspiry-postbox-inside inside">
				    <?php $this->inspiry_postbox_posts( $how_to_get_help['posts'], $how_to_get_help['posts_heading'] ); ?>
				    <?php $this->inspiry_postbox_posts( $extend_support['posts'], $extend_support['posts_heading'] ); ?>
                </div>
                <div class="inspiry-postbox-footer">
				    <?php $this->inspiry_quick_links( $quick_links['links'] ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->footer('help'); ?>