<?php

class RHEA_Heading_Divider extends \Elementor\Base_Control {

	public function get_type() {
		return 'rhea-heading-divider';
	}


	public function enqueue() {

		wp_enqueue_style( 'rhea-heading-divider', RHEA_PLUGIN_URL . 'elementor/css/heading-divider.css', array(), RHEA_VERSION, 'all' );

	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}
	public function content_template() {
		?>
        <div class="rhea_header_divider">
            <h3 class="rhea-control-title">{{{ data.label }}}</h3>
        </div>
		<?php
	}

}