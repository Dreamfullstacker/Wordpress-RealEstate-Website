<?php
if ( ! class_exists( 'Inspiry_Dragdrop_Control' ) ) {
	return null;
}

/**
 * Class Inspiry_Dragdrop_Control
 *
 * Custom control to display separator
 */
class Inspiry_Dragdrop_Control extends WP_Customize_Control {

	public function section_id() {
		return 'inspiry-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
	}

	public function render_content() {

		$ordered_sections = $this->sections_ordered_array();
		$section_id       = $this->section_id();
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<div id="sections_<?php echo esc_attr( $section_id ); ?>" class="inspiry_property_sections_sortable">
			<?php
			foreach ( $ordered_sections as $key => $value ) {
				echo '<div class="section draggable" draggable="true" ><span data-value="' . $key . '">' . $value . '</span></div>';
			}
			?>
		</div><input id="<?php echo esc_attr( $section_id ); ?>" class="sorting-db" type="text" <?php $this->link(); ?>>
		<?php
	}

	public function sections_ordered_array() {

		$saved_order    = explode( ',', $this->value() );
		$sections_order = $this->clean_ordered_array( $saved_order, $this->choices );

		return array_merge( array_flip( $sections_order ), $this->choices );
	}

	public function clean_ordered_array( $order, $choices ) {

		$sections_order = array();
		foreach ( $order as $section ) {
			if ( array_key_exists( $section, $choices ) ) {
				$sections_order[] = $section;
			}
		}

		return $sections_order;
	}

	public function enqueue() {
		wp_enqueue_script( 'inspiry-customizer-js', get_theme_file_uri( 'framework/customizer/custom/js/script.js' ), array( 'jquery' ), null, true );
	}
}
