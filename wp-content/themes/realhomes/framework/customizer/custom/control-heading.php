<?php
if ( ! class_exists( 'Inspiry_Heading_Customize_Control' ) ) {
	return null;
}

/**
 * Class Inspiry_Heading_Customize_Control
 *
 * Custom control to display heading H1
 */
class Inspiry_Heading_Customize_Control extends WP_Customize_Control
{
	public function render_content(){
		?>
		<label>

			<?php if ( ! empty( $this->label ) ) : ?>
				<h2 class="customize-control-heading" style="background: #fff; padding: 10px;"><?php echo esc_html( $this->label ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

		</label>
		<?php
	}
}
