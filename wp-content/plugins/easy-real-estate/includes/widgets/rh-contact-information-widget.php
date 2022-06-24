<?php
/**
 * Widget: RealHomes Contact Information
 */
if ( ! class_exists( 'RH_Contact_Information' ) ) :

	/**
	 * RH_Contact_Information.
	 *
	 * Contact Information widget for RealHomes.
	 *
	 * @since 3.0.0
	 */
	class RH_Contact_Information extends WP_Widget {

		/**
		 * Method: Constructor.
		 *
		 * @since 3.0.0
		 */
		function __construct() {
			$widget_ops = array(
				'classname'                   => 'RH_Contact_Information',
				'description'                 => esc_html__( 'Displays general contact information.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'RH_Contact_Information', esc_html__( 'RealHomes - Contact Information', 'easy-real-estate' ), $widget_ops );
		}

		/**
		 * Method: Widget Front-End Display.
		 *
		 * @param array $args - contains the argument of the widget.
		 * @param array $instance - contains the parameters of the widget.
		 *
		 * @since 3.0.0
		 */
		function widget( $args, $instance ) {
		    
			$title        = ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? $instance['title'] : false;
			$address      = ( isset( $instance['address'] ) && ! empty( $instance['address'] ) ) ? $instance['address'] : false;
			$number       = ( isset( $instance['number'] ) && ! empty( $instance['number'] ) ) ? $instance['number'] : false;
			$email        = ( isset( $instance['email'] ) && is_email( $instance['email'] ) ) ? $instance['email'] : false;
			$icon         = ( isset( $instance['icon'] ) && ! empty( $instance['icon'] ) ) ? '1' : '0';

			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			$number_icon = 'phone';
			if ( $icon ) {
				$number_icon = 'whatsapp';
			}

			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'target' => array(),
				),
				'br'     => array(),
				'strong' => array(),
				'i'      => array(),
			);

			echo $args['before_widget'];
			?>
			<div class="rh_contact_widget">
				<?php if ( ! empty( $title ) ) : ?>
                    <h3 class="title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $address ) ) : ?>
                    <div class="rh_contact_widget__item rh_contact_widget--alignBaseline">
                        <p class="icon"><?php include( ERE_PLUGIN_DIR . '/images/icons/icon-marker.svg' ); ?></p>
                        <p class="content"><?php echo wp_kses( $address, $allowed_html ); ?></p>
                    </div>
				<?php endif; ?>

				<?php if ( ! empty( $number ) ) : ?>
                    <div class="rh_contact_widget__item rh_contact_widget--alignBaseline">
                        <p class="icon"><?php include( ERE_PLUGIN_DIR . '/images/icons/icon-' . esc_html( $number_icon ) . '.svg' ); ?></p>
                        <?php
                        if ( $number_icon == 'whatsapp' ) {
                            $number_href = 'https://api.whatsapp.com/send?phone=';
                        }else{
	                        $number_href = 'tel:';
                        }
                        ?>
                        <a class="content" href="<?php echo esc_url($number_href.$number ); ?>"><?php echo esc_html( $number ); ?></a>

                    </div>
				<?php endif; ?>

                <?php if ( ! empty( $email ) ) : ?>
                    <div class="rh_contact_widget__item rh_contact_widget--alignBaseline">
                        <p class="icon"><?php include( ERE_PLUGIN_DIR . '/images/icons/icon-mail.svg' ); ?></p>
                        <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" class="content"><?php
                            echo esc_html( antispambot( $email ) );
                            ?></a>
                    </div>
				<?php endif; ?>
			</div><!-- /.rh_contact_widget -->
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Method: Widget Form.
		 *
		 * @param array $instance - contains the parameters of the widget.
		 *
		 * @since 3.0.0
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array(
				'title'   => '',
				'address' => esc_html__( '3015 Grand Ave, Coconut Grove, Merrick Way, FL 12345', 'easy-real-estate' ),
				'number'  => esc_html__( '+123-456-789', 'easy-real-estate' ),
				'email'   => esc_html__( 'robot@inspirythemes.com', 'easy-real-estate' ),
			) );

			$title    = $instance['title'];
			$address  = $instance['address'];
			$number   = $instance['number'];
			$email    = $instance['email'];
			$icon     = isset( $instance['icon'] ) ? (bool) $instance['icon'] : false;
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'easy-real-estate' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Contact Address', 'easy-real-estate' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>"/>
			</p>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Phone Number', 'easy-real-estate' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>"/>
			</p>
            <p>
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>"<?php checked( $icon ); ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Use WhatsApp icon for the phone number?', 'easy-real-estate' ); ?></label>
            </p>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'easy-real-estate' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>"/>
            </p>
			<?php
		}
	}
endif;

if ( ! function_exists( 'register_contact_widget' ) ) {
	/**
	 * Register Contact Widget
	 */
	function register_contact_widget() {
		register_widget( 'RH_Contact_Information' );
	}
}
add_action( 'widgets_init', 'register_contact_widget' );