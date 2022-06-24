<?php
/**
 * Agent Contact Form
 *
 * @since 2.7.0
 * @package realhomes/classic
 */

$author_id ='';
$agent_id = '';
if ( is_singular( 'agent' ) ) {
    global $post;
    $agent_email = get_post_meta( $post->ID, 'REAL_HOMES_agent_email', true );
	$agent_id = get_the_ID();
} elseif ( is_author() ) {
    global $current_author;
    $agent_email = $current_author->user_email;
    $author_id = $current_author->ID;
}

$agent_email = is_email( $agent_email );

if ( inspiry_get_agent_custom_form() ) { ?>
    <hr/>
    <h5><?php esc_html_e( 'Send a Message', 'framework' ); ?></h5>
    <?php
	inspiry_agent_custom_form();
} elseif  ( $agent_email ) {
    ?>
    <hr/>
    <h5><?php esc_html_e( 'Send a Message', 'framework' ); ?></h5>
    <form id="agent-single-form" class="" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">

        <div class="row-fluid">
            <div class="span6">
                <input type="text" name="name" id="name" placeholder="<?php esc_attr_e( 'Name', 'framework' ); ?>" class="required" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
            </div>

            <div class="span6">
                <input type="text" name="email" id="email" placeholder="<?php esc_attr_e( 'Email', 'framework' ); ?>" class="email required" title="<?php esc_attr_e( '* Please provide valid email address', 'framework' ); ?>">
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6">
                <input type="text" name="phone" id="phone" placeholder="<?php esc_attr_e( 'Phone', 'framework' ); ?>" class="digits required" title="<?php esc_attr_e( '* Please provide valid phone number', 'framework' ); ?>">
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <textarea  name="message" id="comment" class="required" placeholder="<?php esc_attr_e( 'Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
            </div>
        </div>

	    <?php
	    if ( function_exists( 'ere_gdpr_agreement' ) ) {
		    ere_gdpr_agreement( array(
			    'container'       => 'p',
			    'container_class' => 'gdpr-agreement',
			    'title_class'     => 'gdpr-checkbox-label'
		    ) );
	    }
	    ?>

        <div class="row-fluid">
            <div class="span12 agent-recaptcha">
                <?php
                /* Display reCAPTCHA if enabled and configured from customizer settings */
                get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' ); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
                <input type="hidden" name="target" value="<?php echo esc_attr( antispambot( $agent_email ) ); ?>">
                <input type="hidden" name="action" value="send_message_to_agent" />
                <input type="hidden" name="agent_id" value="<?php echo esc_attr($agent_id)?>">
                <input type="hidden" name="author_id" value="<?php echo esc_attr($author_id)?>">
                <input type="submit" id="submit-button" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>"  name="submit" class="real-btn">
                <img src="<?php echo esc_attr( INSPIRY_DIR_URI ); ?>/images/ajax-loader.gif" id="ajax-loader" alt="Loading...">
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div id="error-container"></div>
                <div id="message-container">&nbsp;</div>
            </div>
        </div>

    </form>
    <?php
}