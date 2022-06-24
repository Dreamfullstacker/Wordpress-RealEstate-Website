<?php
if ( ! class_exists( 'Inspiry_Separator_Control' ) )
	return NULL;

/**
 * Class Inspiry_Separator_Control
 *
 * Custom control to display separator
 */
class Inspiry_Separator_Control extends WP_Customize_Control
{
	public function render_content(){
		?>
		<label>
			<br>
			<hr>
			<br>
		</label>
		<?php
	}
}
