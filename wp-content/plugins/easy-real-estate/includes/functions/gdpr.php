<?php
if ( ! function_exists( 'ere_is_gdpr_enabled' ) ) {
	/**
	 * Check if GDPR is enabled
	 *
	 * @return bool
	 */
	function ere_is_gdpr_enabled() {

		if ( intval( get_option( 'inspiry_gdpr', '0' ) ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'ere_gdpr_agreement' ) ) {
	/**
	 * Render GDPR Agreement markup
	 *
	 * @param array $args
	 */
	function ere_gdpr_agreement( $args = array() ) {

		if ( ere_is_gdpr_enabled() ) {

			global $gdpr_id;

			$defaults = array(
				'id'              => 'ere-gdpr-checkbox',
				'container'       => 'div',
				'container_class' => 'ere-gdpr-agreement',
				'title_class'     => 'ere-gdpr-label'
			);

			$args       = wp_parse_args( $args, $defaults );
			$html       = '';
			$gdpr_label = get_option( 'inspiry_gdpr_label', esc_html__( 'GDPR Agreement', 'easy-real-estate' ) );
			$validation = get_option( 'inspiry_gdpr_validation_text', esc_html__( '* Please accept GDPR agreement', 'easy-real-estate' ) );
			$gdpr_text  = get_option( 'inspiry_gdpr_text', esc_html__( 'I consent to having this website store my submitted information so they can respond to my inquiry.', 'easy-real-estate' ) );

			if ( ! empty( $gdpr_label ) ) {
				$html .= '<span class="' . esc_attr( $args['title_class'] ) . '">' . esc_html( $gdpr_label ) . ' <span class="required-label">*</span></span>';
			}

			if ( ! empty( $gdpr_text ) ) {
				$html .= '<input type="checkbox" name="gdpr" id="' . esc_attr( $args['id'] ) . $gdpr_id . '" class="required" value="' . strip_tags( $gdpr_text ) . '" title="' . esc_attr( $validation ) . '">';
				$html .= '<label for="' . esc_attr( $args['id'] ) . $gdpr_id . '">' . wp_kses( $gdpr_text, array(
						'a'      => array(
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'title'  => array()
						),
						'br'     => array(),
						'em'     => array(),
						'strong' => array(),
					) ) . '</label>';
				++ $gdpr_id;
			}

			printf( '<%1$s class="%2$s clearfix">%3$s</%1$s>', esc_html( $args['container'] ), esc_attr( $args['container_class'] ), $html );
		}
	}
}