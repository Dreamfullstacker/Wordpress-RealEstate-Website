<?php
/**
 * Custom Radio Image Control
 */
class Inspiry_Custom_Radio_Image_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 * @var string
	 */
	public $type = 'radio-image';

	/**
	 * Enqueue scripts and styles for the custom control.
	 *
	 * Note, you can also enqueue stylesheets here as well. Stylesheets are hooked
	 * at 'customize_controls_print_styles'.
	 *
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
		$data = "
            (function ($) {
                \"use strict\";
                jQuery(document).ready(function ($) {
                    $(window).on('load', function () {
                      $('[id=\"input_" . esc_attr( $this->id ) . "\"]').buttonset()
                    });
                });
            })(jQuery);
		";
		wp_add_inline_script( 'jquery-ui-button', $data );
	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;
		?>
		<span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span
					class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</span>
		<div id="input_<?php echo esc_attr( $this->id ); ?>" class="image">
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr( $this->id . $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
					<label style="height: auto;padding: 0;border: none; box-shadow: none;" for="<?php echo esc_attr( $this->id . $value ); ?>">
						<img src="<?php echo esc_url( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
					</label>
				</input>
			<?php endforeach; ?>
		</div>
		<?php
	}
}