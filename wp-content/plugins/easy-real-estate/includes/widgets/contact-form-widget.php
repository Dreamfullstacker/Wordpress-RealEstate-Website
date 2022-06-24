<?php
/**
 * Widget: ERE_Widget_Contact_Form class
 *
 * @package easy_real_estate
 * @subpackage Widgets
 * @since 0.5.1
 */
class ERE_Widget_Contact_Form extends WP_Widget {

	/**
	 * Sets up a new Contact Form widget instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'ere_widget_contact_form',
			'description'                 => esc_html__( 'This widget displays contact form.', 'easy-real-estate' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'ERE_Widget_Contact_Form', esc_html__( 'RealHomes - Contact Form', 'easy-real-estate' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current Contact Form widget instance.
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Contact Form widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$widget_id = $args['widget_id'];
		$to_email  = isset( $instance['to_email'] ) ? is_email( $instance['to_email'] ) : false;
		if ( $to_email ) {
			$form_fields = array(
				'name'      => array(
					'type'  => 'text',
					'label' => ! empty( $instance['name'] ) ? $instance['name'] : esc_html__( 'Name', 'easy-real-estate' ),
					'class' => 'required',
					'title' => esc_html__( '* Please provide your name', 'easy-real-estate' )
				),
				'email'     => array(
					'type'  => 'text',
					'label' => ! empty( $instance['email'] ) ? $instance['email'] : esc_html__( 'Email', 'easy-real-estate' ),
					'class' => 'email required',
					'title' => esc_html__( '* Please provide a valid email address', 'easy-real-estate' )
				),
				'number'    => array(
					'type'  => 'text',
					'label' => ! empty( $instance['number'] ) ? $instance['number'] : esc_html__( 'Phone Number', 'easy-real-estate' ),
				),
				'message'   => array(
					'type'  => 'textarea',
					'label' => ! empty( $instance['message'] ) ? $instance['message'] : esc_html__( 'Message', 'easy-real-estate' ),
					'class' => 'required',
					'title' => esc_html__( '* Please provide your message', 'easy-real-estate' )
				),
				'gdpr'      => array(
					'type' => 'gdpr',
				),
				'recaptcha' => array(
					'type' => 'recaptcha',
				),
			);
			$form_fields = apply_filters( 'ere_widget_contact_form_fields', $form_fields, $widget_id );
			?>
            <div class="ere-contact-form-container">
                <form class="ere-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
					<?php
					if ( ! empty( $form_fields ) && is_array( $form_fields ) ) {

						foreach ( $form_fields as $field_name => $field ) {

							$id         = $field_name . "_" . $widget_id;
							$field_item = '';

							$label = '';
							if ( isset( $field['label'] ) && ! empty( $field['label'] ) ) {
								$label = sprintf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $field['label'] ) );
							}

							$field_type = '';
							if ( isset( $field['type'] ) && ! empty( $field['type'] ) ) {
								$field_type = $field['type'];
							}

							$class_html = '';
							if ( isset( $field['class'] ) && ! empty( $field['class'] ) ) {
								$class_html = sprintf( 'class="%s"', esc_attr( $field['class'] ) );
							}

							$title_html = '';
							if ( isset( $field['title'] ) && ! empty( $field['title'] ) ) {
								$title_html = sprintf( 'title="%s"', esc_attr( $field['title'] ) );
							}

							if ( 'gdpr' === $field_type ) {
								ere_gdpr_agreement( array(
									'id'              => 'inspiry-gdpr',
									'container'       => 'p',
									'container_class' => 'rh_inspiry_gdpr',
									'title_class'     => 'gdpr-checkbox-label'
								) );
							} elseif ( 'recaptcha' === $field_type ) {
								if ( ere_is_reCAPTCHA_configured() ) {
									$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
									?>
                                    <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"></div>
                                    </div>
									<?php
								}
							} elseif ( 'textarea' === $field_type ) {
								$field_item = sprintf( '<textarea name="%s" id="%s" %s %s cols="40" rows="5"></textarea>', esc_attr( $field_name ), esc_attr( $id ), $class_html, $title_html );
							}elseif ( 'text' === $field_type ) {
								$field_item = sprintf( '<input type="%s" name="%s" id="%s" %s %s>', esc_attr( $field_type ), esc_attr( $field_name ), esc_attr( $id ), $class_html, $title_html );
							}

							if ( ! empty( $field_item ) ) {
								printf( '<p>%s%s</p>', $label, $field_item );
							}
						}
					}

					$submit_button = ! empty( $instance['submit'] ) ? $instance['submit'] : esc_html__( 'Send Message', 'easy-real-estate' )
					?>
                    <div class="ere-submit-button-container">
                        <input type="submit" name="submit" value="<?php echo esc_attr( $submit_button ); ?>" class="submit-button rh_btn rh_btn--primary">
                        <input type="hidden" name="action" value="send_message">
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'send_message_nonce' ) ); ?>">
                        <input type="hidden" name="ere_cf_widget_target_email" value="<?php echo antispambot( $to_email ); ?>">
	                    <?php if ( is_singular( 'property' ) ) : ?>
                            <input type="hidden" name="property_title" value="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"/>
                            <input type="hidden" name="property_permalink" value="<?php echo esc_url_raw( get_permalink( get_the_ID() ) ); ?>"/>
	                    <?php endif; ?>
                        <div class="ere_widget_contact_form_loader"><div></div><div></div><div></div><div></div></div>
                    </div>
                    <div class="error-container"></div>
                    <div class="message-container"></div>
                </form>
            </div>
			<?php
		}else{
			printf( '<div class="ere-contact-form-container">%s</div>', esc_html__( 'Please provide the \'Target Email\' address in the widget settings to show the contact form.', 'easy-real-estate' ) );
        }
		echo $args['after_widget'];
	}

	/**
	 * Outputs the settings form for the Contact Form widget.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'    => esc_html__('Contact Us', 'easy-real-estate' ),
			'to_email' => get_option( 'admin_email' ),
			'name'     => '',
			'email'    => '',
			'number'   => '',
			'message'  => '',
			'submit'   => '',
		) );
		$title    = $instance['title'];
		$to_email = $instance['to_email'];
		$name     = $instance['name'];
		$email    = $instance['email'];
		$number   = $instance['number'];
		$message  = $instance['message'];
		$submit   = $instance['submit'];
		?>
		<p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Widget Title:', 'easy-real-estate' ); ?>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'to_email' ); ?>"><?php esc_html_e('Target Email:', 'easy-real-estate' ); ?>
                <input class="widefat" id="<?php echo $this->get_field_id( 'to_email' ); ?>" name="<?php echo $this->get_field_name( 'to_email' ); ?>" type="text" value="<?php echo esc_attr( $to_email ); ?>" />
            </label>
        </p>
		<h4><?php esc_html_e('Customize Contact Form Labels', 'easy-real-estate' ); ?></h4>
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php esc_html_e('Name Field Label:', 'easy-real-estate' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php esc_html_e('Email Field Label:', 'easy-real-estate' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e('Phone Number Field Label:', 'easy-real-estate' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'message' ); ?>"><?php esc_html_e('Message Field Label:', 'easy-real-estate' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'message' ); ?>" name="<?php echo $this->get_field_name( 'message' ); ?>" type="text" value="<?php echo esc_attr( $message ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submit' ); ?>"><?php esc_html_e('Submit Button Label:', 'easy-real-estate' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'submit' ); ?>" name="<?php echo $this->get_field_name( 'submit' ); ?>" type="text" value="<?php echo esc_attr( $submit ); ?>" />
			</label>
		</p>
		<?php
	}

	/**
	 * Handles updating settings for the current Contact Form widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$new_instance         = wp_parse_args(
			(array) $new_instance, array(
			'title'    => '',
			'to_email' => '',
			'name'     => '',
			'email'    => '',
			'number'   => '',
			'message'  => '',
			'submit'   => '',
		) );
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['to_email'] = sanitize_email( $new_instance['to_email'] );
		$instance['name']     = sanitize_text_field( $new_instance['name'] );
		$instance['email']    = sanitize_text_field( $new_instance['email'] );
		$instance['number']   = sanitize_text_field( $new_instance['number'] );
		$instance['message']  = sanitize_text_field( $new_instance['message'] );
		$instance['submit']   = sanitize_text_field( $new_instance['submit'] );

		return $instance;
	}
}

if ( ! function_exists( 'register_ere_contact_form_widget' ) ) {
	/**
	 * Registers the Contact Form widget
	 *
	 * @package easy_real_estate
	 * @subpackage Widgets
	 * @since 0.5.1
	 */
	function register_ere_contact_form_widget() {
		register_widget( 'ERE_Widget_Contact_Form' );
	}

	add_action( 'widgets_init', 'register_ere_contact_form_widget' );
}