<?php

class RHEA_Important_note extends \Elementor\Base_Control {

	public function get_type() {
		return 'rhea-important-note';
	}


	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}
	public function content_template() {
		?>
		<div class="rhea-note-control-wrapper">
			<p style="color: red; line-height: 18px" class="rhea-note-control">{{{ data.label }}}</p>
		</div>
		<?php
	}

}