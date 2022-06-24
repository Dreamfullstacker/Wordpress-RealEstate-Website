<?php
if ( class_exists( 'RWMB_Field' ) ) {
	/**
	 * Class RWMB_Sorter_Field
	 */
	class RWMB_Sorter_Field extends RWMB_Field {

		public static function html( $meta, $field ) {

			ob_start();

			RWMB_Sorter_Field::embed_js( $field['id'] );
			RWMB_Sorter_Field::embed_css();
			$ordered_sections = RWMB_Sorter_Field::sections_ordered_array( $meta, $field['options'] );
			?>
			<div id="sections_<?php echo esc_attr( $field['id'] ); ?>" class="inspiry_home_sections_sortable clearfix">
				<?php
				foreach ( $ordered_sections as $key => $value ) {
					echo '<div class="section draggable" draggable="true" ><span data-value="' . $key . '">' . $value . '</span></div>';
				}
				?>
			</div>
			<input id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $field['field_name'] ); ?>" class="sorting-db" type="text" value="<?php echo esc_attr( $meta ); ?>">
			<?php

			return ob_get_clean();
		}

		public static function sections_ordered_array( $value, $options ) {
			$saved_order    = explode( ',', $value );
			$sections_order = RWMB_Sorter_Field::clean_ordered_array( $saved_order, $options );

			return array_merge( array_flip( $sections_order ), $options );
		}


		public static function clean_ordered_array( $order, $options ) {

			$sections_order = array();

			foreach ( $order as $section ) {
				if ( array_key_exists( $section, $options ) ) {
					$sections_order[] = $section;
				}
			}

			return $sections_order;
		}

		public static function embed_js( $section_id ) {
			?>
			<script>
				$ = jQuery;
				$(document).ready(function(){
					var container = $('.inspiry_home_sections_sortable');
					if(container) {
						var home_sections = container.find('.section');

						set_dragging_effect(home_sections); // Set dragging effect on homepage sections fields.

						// Handling section dragging field drop in its container.
						container.on('dragover', function(event){
							event.preventDefault();

							var getDropBeforeField = getDropBeforeSection( container, event.clientY );
							var dragging = $('.section.dragging');

							if ( getDropBeforeField == undefined ) {
								$(this).append(dragging);
							} else {
								dragging.insertBefore(getDropBeforeField);
							}

							// Save the new order of the homepage sections.
							var optionTexts = [];
							jQuery('<?php echo '#sections_' . esc_html( $section_id ); ?> .section').each(function () {
								optionTexts.push(jQuery(this).children('span').data('value'))
							});

							var quotedCSV = optionTexts.join(',');
							var db_input = jQuery("<?php echo '#' . esc_html( $section_id ); ?>");
							db_input.val(quotedCSV);
						});

						// Return field to drop dragging field before.
						function getDropBeforeSection(container, y) {

							var draggableClasses = [...container.find('.section.draggable:not(.dragging)')];

							return draggableClasses.reduce(function(closest, child){
								var box = child.getBoundingClientRect();
								var offset = y - box.top - box.height / 2;

								if( offset < 0 && offset > -110) {
									return {offset: offset, element: child};
								} 
								else {
									return closest;
								}

							}, {offset: Number.NEGATIVE_INFINITY}).element;
						}

					}

					// Set dragging effect.
					function set_dragging_effect(home_sections){
						home_sections.each(function(){
							$(this).on('dragstart', function(e){
								$(this).addClass('dragging');
								e.originalEvent.dataTransfer.setDragImage(this, 8, 25);
							});

							$(this).on('dragend', function(){
								$(this).removeClass('dragging');
							});
						});
					}
				});
			</script>
			<?php

		}

		public static function embed_css() {
			?>
			<style>
				.section {
					height: auto;
					padding: 15px 0;
					width: 100%;
					float: left;
					border: 1px solid #cccccc;
					background-color: #fff;
					margin-bottom: 5px;
					text-align: center;
					font-weight: 700;
					cursor: move;
				}

				.section.dragging {
					border: 1px dashed #000;
					background-color: rgba(0, 133, 186, 0.31);
				}

				.sorting-db {
					display: none;
				}

				.clearfix::after {
					content: "";
					clear: both;
					display: table;
				}
			</style>
			<?php
		}
	}
}
