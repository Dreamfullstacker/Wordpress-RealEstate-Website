<?php
/**
 * Class Property_Additional_Fields Responsible for the property new additional fields
 */

class Property_Additional_Fields {

	protected static $instance;

	function __construct() {

		// Add "Property Additional Fields" settings page
		add_filter( 'mb_settings_pages', array( $this, 'inspiry_additional_fields_page' ) );

		// Add "Property Additional Fields" settings page options fields
		add_filter( 'rwmb_meta_boxes', array( $this, 'inspiry_property_additional_fields' ) );

		// Add additional fields to the property meta box
		add_filter( 'rwmb_meta_boxes', array( $this, 'inspiry_add_property_mb_additional_fields' ), 20 );

		// Regsiter additional fields to the translation with WPML.
		add_action( 'rwmb_inspiry_additional_fields_list_after_save_field', array( $this, 'register_additional_fields_for_translation' ), 999, 3 );

		// Add property additional fields to its detail page
		add_action( 'inspiry_additional_property_meta_fields', array(
			$this,
			'inspiry_property_single_additional_fields'
		) );

		// Add property additional fields to the advance search form
		add_action( 'inspiry_additional_search_fields', array( $this, 'inspiry_search_additional_fields' ) );

		// Add property additional fields filter to the search meta query
		add_filter( 'inspiry_real_estate_meta_search', array( $this, 'inspiry_search_additional_fields_filter' ) );

		// Add property additional fields to the property submit/edit page
		add_action( 'inspiry_additional_edit_property_fields', array(
			$this,
			'inspiry_property_submit_additional_fields'
		) );
		add_action( 'inspiry_additional_submit_property_fields', array(
			$this,
			'inspiry_property_submit_additional_fields'
		) );

		// Update property additional fields values on submit/edit page
		add_action( 'inspiry_after_property_submit', array(
			$this,
			'inspiry_property_submit_additional_fields_update'
		) );
		add_action( 'inspiry_after_property_update', array(
			$this,
			'inspiry_property_submit_additional_fields_update'
		) );
	}

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function inspiry_additional_fields_page( $settings_pages ) {
		/**
		 * Create "Property Additional Fields" settings page under "Easy Real Estate" dashboard parent menu
		 */
		$settings_pages[] = array(
			'id'          => 'inspiry_property_additional_fields_page',
			'option_name' => 'inspiry_property_additional_fields',
			'menu_title'  => esc_html__( 'New Fields Builder', 'easy-real-estate' ),
			'parent'      => 'easy-real-estate',
			'columns'     => 1,
		);

		return $settings_pages;
	}

	public function inspiry_property_additional_fields( $meta_boxes ) {
		/**
		 * Add "Property Additional Fields" page options fields
		 */

		$meta_boxes[] = array(
			'id'             => 'inspiry_property_additional_fields_settings',
			'title'          => esc_html__( 'Add New Property Fields', 'easy-real-estate' ),
			'settings_pages' => 'inspiry_property_additional_fields_page',
			'fields'         => array(
				array(
					'id'            => 'inspiry_additional_fields_list',
					'type'          => 'group',
					'clone'         => true,
					'sort_clone'    => true,
					'collapsible'   => true,
					'group_title'   => '{field_name}',
					'default_state' => 'collapsed',
					'fields'        => array(
						array(
							'name' => esc_html__( 'Field Name', 'easy-real-estate' ),
							'desc' => esc_html__( 'Keep it short and unique. Do not use any special Characters. Example: First Additional Field', 'easy-real-estate' ),
							'id'   => 'field_name',
							'type' => 'text',
						),
						array(
							'name'    => esc_html__( 'Field Type', 'easy-real-estate' ),
							'id'      => 'field_type',
							'type'    => 'select',
							'std'     => 'text',
							'options' => array(
								'text'          => esc_html__( 'Text', 'easy-real-estate' ),
								'textarea'      => esc_html__( 'Text Multiple Line', 'easy-real-estate' ),
								'select'        => esc_html__( 'Select', 'easy-real-estate' ),
								'checkbox_list' => esc_html__( 'Checkbox List', 'easy-real-estate' ),
								'radio'         => esc_html__( 'Radio', 'easy-real-estate' ),
							)
						),
						array(
							'name'    => esc_html__( 'Field Options', 'easy-real-estate' ),
							'desc'    => esc_html__( 'Please add comma separated options. Example: One, Two, Three', 'easy-real-estate' ),
							'id'      => 'field_options',
							'type'    => 'textarea',
							'visible' => array( 'field_type', 'in', array( 'select', 'checkbox_list', 'radio' ) )
						),
						array(
							'name' => esc_html__( 'Field Icon', 'easy-real-estate' ),
							'desc' => sprintf( esc_html__( 'You can use the %s. You just need to add the icon class like %s ', 'easy-real-estate' ), '<a target="_blank" href="https://fontawesome.com/icons?d=gallery&p=2&m=free">' . esc_html__( 'Font Awesome Icons', 'easy-real-estate' ) . '</a>', '<strong>far fa-star</strong>' ),
							'id'   => 'field_icon',
							'type' => 'text',
						),
						array(
							'name'    => esc_html__( 'Where do you want to display this field?', 'easy-real-estate' ),
							'id'      => 'field_display',
							'type'    => 'checkbox_list',
							'options' => array(
								'search' => esc_html__( 'Advance Search Form', 'easy-real-estate' ),
								'submit' => esc_html__( 'Property Submit Page', 'easy-real-estate' ),
								'single' => esc_html__( 'Property Single Page', 'easy-real-estate' ),
							),
						),
					),
				),
			),
		);

		return $meta_boxes;
	}

	public function inspiry_add_property_mb_additional_fields( $meta_boxes ) {
		/**
		 * Add property additional fields to the property meta box
		 */

		$additional_fields = $this->get_additional_fields();

		if ( ! empty( $additional_fields ) ) {

			foreach ( $meta_boxes as $index => $meta_box ) {

				// Edit property metabox fields only
				if ( isset( $meta_box['id'] ) && 'property-meta-box' == $meta_box['id'] ) {

					// Add new tab information
					$meta_boxes[ $index ]['tabs']['inspiry_additional_tabs']['label'] = esc_html__( 'Additional Fields', 'easy-real-estate' );
					$meta_boxes[ $index ]['tabs']['inspiry_additional_tabs']['icon']  = 'fas fa-bars';

					// Add additional fields to the new tab
					foreach ( $additional_fields as $field ) {

						$build = array(
							'name'    => $field['field_name'],
							'id'      => $field['field_key'],
							'type'    => $field['field_type'],
							'tab'     => 'inspiry_additional_tabs',
							'inline'  => false,
							'columns' => 6,
						);

						if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
							$build['name'] = apply_filters( 'wpml_translate_single_string', $field['field_name'], 'Additional Fields', $field['field_name'] . ' Label', ICL_LANGUAGE_CODE );
						}

						// If field is a select set its options.
						if ( in_array( $field['field_type'], array( 'select', 'checkbox_list', 'radio' ) ) ) {

							// If WPML languages are configured then check for the field options translation.
							if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
								$options = explode( ',', apply_filters( 'wpml_translate_single_string', implode( ',', $field['field_options'] ), 'Additional Fields', $field['field_name'] . ' Value', ICL_LANGUAGE_CODE ) );
								$options = array_combine( $options, $options );
							} else {
								$options = $field['field_options'];
							}

							if ( $field['field_type'] == 'select' || $field['field_type'] == 'radio' ) {
								$build['options'] = array( '' => esc_html__( 'None', 'easy-real-estate' ) ) + $options;
							} else {
								$build['options'] = $options;
							}
						}

						// Add final build of the field to the new tab
						$meta_boxes[ $index ]['fields'][] = $build;
					}
				}
			}
		}

		// Return edited meta boxes
		return $meta_boxes;
	}

	/**
	 * Regsiter additional fields to the translation with WPML.
	 *
	 * @param null   $null Not being used.
	 * @param object $field Filed that's being updated.
	 * @param array  $new_fields Array of new fields added via field builder.
	 */
	public function register_additional_fields_for_translation( $null, $field, $new_fields ) {

		foreach ( $new_fields as $field ) {
			do_action( 'wpml_register_single_string', 'Additional Fields', $field['field_name'] . ' Label', $field['field_name'] );
			if ( 'checkbox_list' === $field['field_type'] || 'select' === $field['field_type'] || 'radio' === $field['field_type'] ) {
				if ( ! empty( $field['field_options'] ) ) {
					do_action( 'wpml_register_single_string', 'Additional Fields', $field['field_name'] . ' Value', $field['field_options'] );
				}
			}
		}
	}

	public function inspiry_property_detail_field_html( $name, $value, $icon ) {
		/**
		 * Display property additional fields html on property detail page
		 */

		$field_class = strtolower( preg_replace( '/\s+/', '-', $name ) );

		if ( 'ultra' === INSPIRY_DESIGN_VARIATION ) {
		    ?>
            <div class="rh_ultra_prop_card__meta <?php echo esc_attr( $field_class ); ?>">
                <div class="rh_ultra_meta_icon_wrapper">
                    <span class="rh-ultra-meta-label">
                        <?php echo esc_html( $name ); ?>
                    </span>
                       <div class="rh-ultra-meta-icon-wrapper">
					<?php if ( ! empty ( $icon ) ) { ?>
                        <span class="rh_ultra_meta_icon">
                        <i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
                        </span>
					<?php } ?>
                    <span class="figure <?php echo empty( $icon ) ? 'no-icon' : ''; ?>">
                      <?php echo esc_html( $value ); ?>
                    </span>
                       </div>
                </div>
            </div>
			<?php

		}elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			?>
            <span class="property-meta-<?php echo esc_attr( $field_class ); ?>" title="<?php echo esc_attr( $name ) ?>">
                <?php if ( ! empty ( $icon ) ) { ?>
                    <i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
                <?php }
                echo esc_html( $value );
                ?>
            </span>
			<?php
		} else {
			?>
            <div class="rh_property__meta <?php echo esc_attr( $field_class ); ?>">
                <span class="rh_meta_titles">
                    <?php echo esc_html( $name ); ?>
                </span>
                <div>
					<?php if ( ! empty ( $icon ) ) { ?>
                        <i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
					<?php } ?>
                    <span class="figure <?php echo empty( $icon ) ? 'no-icon' : ''; ?>">
                      <?php echo esc_html( $value ); ?>
                    </span>
                </div>
            </div>
            <!-- /.rh_property__meta -->
			<?php
		}
	}

	public function inspiry_property_single_additional_fields() {
		/**
		 * Add property additional fields to the property detail page
		 */

		if ( is_singular( 'property' ) ) {
			$additional_fields = $this->get_additional_fields( 'single' );

			if ( ! empty( $additional_fields ) ) {
				foreach ( $additional_fields as $field ) {
					$single_value = true;

					if ( 'checkbox_list' == $field['field_type'] ) {
						$single_value = false;
					}

					$value = get_post_meta( get_the_ID(), $field['field_key'], $single_value );
					if ( ! empty( $value ) ) {

						if ( is_array( $value ) ) {
							$value = implode( ', ', $value );
						}

						if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
							$field['field_name'] = apply_filters( 'wpml_translate_single_string', $field['field_name'], 'Additional Fields', $field['field_name'] . ' Label', ICL_LANGUAGE_CODE );
						}

						$this->inspiry_property_detail_field_html( $field['field_name'], $value, $field['field_icon'] );
					}
				}
			}
		}
	}

	public function inspiry_submit_page_field_html( $key, $name, $type, $options = [] ) {
		/**
		 * Display property additional fields html for the submit/edit page
		 */

		$is_edit_property_page = ( function_exists( 'inspiry_is_edit_property' ) && inspiry_is_edit_property() ) || ( function_exists( 'realhomes_dashboard_edit_property' ) && realhomes_dashboard_edit_property() );

		// Prepare field value
        $value = '';
		if ( $is_edit_property_page ) {
			global $post_meta_data;
			$value = isset( $post_meta_data[ $key ] ) ? ( ( 'checkbox_list' == $type || 'radio' == $type ) ? $post_meta_data[ $key ] : $post_meta_data[ $key ][0] ) : '';
		}

		if ( is_page_template( 'templates/dashboard.php' ) ) {
			if ( 'text' == $type ) {
				?>
                <div class="col-md-6 col-lg-4 additional-text-field-wrapper">
                    <p>
                        <label for="<?php echo esc_attr( $key ); ?>"> <?php echo esc_html( $name ); ?> </label>
                        <input type="<?php echo esc_attr( $type ); ?>"
                               name="<?php echo esc_attr( $key ); ?>"
                               id="<?php echo esc_attr( $key ); ?>"
                               value="<?php echo esc_attr( $value ); ?>"/>
                    </p>
                </div>
				<?php
			} elseif ( 'textarea' == $type ) {
				?>
                <div class="col-12 additional-textarea-field-wrapper">
                    <p>
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <textarea name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" cols="30"
                                  rows="8"><?php echo esc_textarea( $value ); ?></textarea>
                    </p>
                </div>
				<?php
			} elseif ( 'select' == $type ) {
				?>
                <div class="col-md-6 col-lg-4 additional-select-field-wrapper">
                    <p>
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>"
                                class="inspiry_select_picker_trigger inspiry_bs_orange show-tick">
			                <?php
			                // Display default select option
			                $selected = empty( $value ) ? 'selected="selected"' : '';
			                echo '<option ' . $selected . '>' . esc_html__( 'None', 'easy-real-estate' ) . '</option>';

			                // Display all available select options
			                foreach ( $options as $keyword => $option ) {
				                $selected = ( ! empty( $value ) && ( $value == $keyword ) ) ? 'selected="selected"' : '';
				                echo '<option value="' . esc_attr( $keyword ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
			                }
			                ?>
                        </select>
                    </p>
                </div>
				<?php
			} elseif ( 'checkbox_list' == $type ) {
				?>
                <div class="col-md-6 col-lg-4 additional-checkbox-field-wrapper">
                    <div class="fields-wrap">
                        <label><?php echo esc_html( $name ); ?></label>
                        <ul class="list-unstyled">
							<?php
							$counter = 1;
							foreach ( $options as $keyword => $option ) {
								echo '<li class="checkbox-field">';
								$checked = ( $is_edit_property_page && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="checkbox" name="' . esc_attr( $key ) . '[]" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' />';
								echo '<label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '">' . esc_attr( $option ) . '</label>';
								echo '</li>';
								$counter ++;
							}
							?>
                        </ul>
                    </div>
                </div>
				<?php
			} elseif ( 'radio' == $type ) {
				?>
                <div class="col-md-6 col-lg-4 additional-radio-fields-wrapper">
                    <div class="fields-wrap">
                        <label><?php echo esc_html( $name ); ?></label>
                        <ul class="list-unstyled">
							<?php
							echo '<li class="radio-field">';
							$checked = empty( $value ) ? 'checked' : '';
							echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="" ' . $checked . ' />';
							echo '<label for="' . esc_attr( $key ) . '">' . esc_html__( 'None', 'easy-real-estate' ) . '</label>';
							echo '</li>';

							$counter = 1;
							foreach ( $options as $keyword => $option ) {
							    echo '<li class="radio-field">';
								$checked = ( $is_edit_property_page && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' />';
								echo '<label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '">' . esc_html( $option ) . '</label>';
								$counter ++;
								echo '</li>';
							}
							?>
                        </ul>
                    </div>
                </div>
				<?php
			}
		} else {
			if ( 'classic' == INSPIRY_DESIGN_VARIATION ) {
				if ( 'text' == $type ) {
					?>
                    <div class="form-option additional-text-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <input id="<?php echo esc_attr( $key ); ?>"
                               name="<?php echo esc_attr( $key ); ?>"
                               type="<?php echo esc_attr( $type ); ?>"
                               value="<?php echo esc_attr( $value ); ?>"/>
                    </div>
					<?php
				} elseif ( 'textarea' == $type ) {
					?>
                    <div class="form-option additional-textarea-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <textarea name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" cols="30" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
                    </div>
					<?php
				} elseif( 'select' == $type ) {
					?>
                    <div class="form-option additional-select-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <span class="selectwrap">
                        <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="inspiry_select_picker_trigger inspiry_bs_orange show-tick">
                            <?php
                            // Display default select option
                            $selected = empty( $value ) ? 'selected="selected"' : '';
                            echo '<option ' . $selected . '>' . esc_html__( 'None', 'easy-real-estate' ) . '</option>';

                            // Display all available select options
                            foreach ( $options as $keyword => $option ) {
	                            $selected = ( ! empty( $value ) && ( $value === $keyword ) ) ? 'selected="selected"' : '';
	                            echo '<option value="' . esc_attr( $keyword ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
                            }
                            ?>
                        </select>
                    </span>
                    </div>
					<?php
				} elseif ( 'checkbox_list' == $type ) {
					?>
                    <div class="form-option additional-checkbox-field-wrapper">
                        <label><?php echo esc_html( $name ); ?></label>
                        <ul class="features-checkboxes clearfix">
							<?php
							$counter = 1;
							foreach ( $options as $keyword => $option ) {
								echo '<li>';
								$checked = ( inspiry_is_edit_property() && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="checkbox" name="' . esc_attr( $key ) . '[]" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' />';
								echo '<label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '">'. esc_attr( $option ) . '</label>';
								echo '</li>';
								$counter ++;
							}
							?>
                        </ul>
                    </div>
					<?php
				} elseif( 'radio' == $type ) {
					?>
                    <div class="form-option additional-radio-field-wrapper">
                        <label><?php echo esc_html( $name ); ?></label>
                        <ul class="additional-radio-options">
							<?php
							echo '<li>';
							$checked = empty( $value ) ? 'checked' : '';
							echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="" ' . $checked . ' /><label for="' . esc_attr( $key ) . '">' . esc_html__( 'None', 'easy-real-estate' ) . '</label></li>';

							$counter = 1;
							foreach ( $options as $keyword => $option ) {
								echo '<li>';
								$checked = ( inspiry_is_edit_property() && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' /><label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '">' . esc_html( $option ) . '</label></li>';
								$counter ++;
							}
							?>
                        </ul>
                    </div>
					<?php
				}
			} else {
				if ( 'text' == $type ) {
					?>
                    <div class="rh_form__item rh_form--3-column rh_form--columnAlign additional-text-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"> <?php echo esc_html( $name ); ?> </label>
                        <input type="<?php echo esc_attr( $type ); ?>"
                               name="<?php echo esc_attr( $key ); ?>"
                               id="<?php echo esc_attr( $key ); ?>"
                               value="<?php echo esc_attr( $value ); ?>"/>
                    </div>
					<?php
				} elseif ( 'textarea' == $type ) {
					?>
                    <div class="rh_form__item rh_form--3-column rh_form--columnAlign additional-textarea-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <textarea name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" cols="30" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
                    </div>
					<?php
				} elseif ( 'select' == $type ) {
					?>
                    <div class="rh_form__item rh_form--3-column rh_form--columnAlign additional-select-field-wrapper">
                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                        <span class="selectwrap">
                        <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_orange show-tick">
                            <?php
                            // Display default select option
                            $selected = empty( $value ) ? 'selected="selected"' : '';
                            echo '<option ' . $selected . '>' . esc_html__( 'None', 'easy-real-estate' ) . '</option>';

                            // Display all available select options
                            foreach ( $options as $keyword => $option ) {
	                            $selected = ( ! empty( $value ) && ( $value === $keyword ) ) ? 'selected="selected"' : '';
	                            echo '<option value="' . esc_attr( $keyword ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
                            }
                            ?>
                        </select>
                    </span>
                    </div>
					<?php
				} elseif ( 'checkbox_list' == $type ) {
					?>
                    <div class="rh_form__item rh_form--3-column rh_form--columnAlign additional-checkbox-field-wrapper">
                        <label><?php echo esc_html( $name ); ?></label>
                        <ul class="features-checkboxes clearfix">
							<?php
							$counter = 1;
							foreach ( $options as $keyword => $option ) {
								echo '<li class="rh_checkbox">';
								echo '<label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '"><span class="rh_checkbox__title">' . esc_attr( $option ) . '</span>';
								$checked = ( inspiry_is_edit_property() && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="checkbox" name="' . esc_attr( $key ) . '[]" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' />';
								echo '<span class="rh_checkbox__indicator"></span></label>';
								echo '</li>';
								$counter ++;
							}
							?>
                        </ul>
                    </div>
					<?php
				} elseif ( 'radio' == $type ) {
					?>
                    <div class="rh_form__item rh_form--3-column rh_form--columnAlign additional-radio-fields-wrapper">
                        <label><?php echo esc_html( $name ); ?></label>
                        <div class="rh_additional_radio_options">
							<?php

							echo '<label for="' . esc_attr( $key ) . '"><span class="rh_checkbox__title">' . esc_html__( 'None', 'easy-real-estate' ) . '</span>';
							$checked = empty( $value ) ? 'checked' : '';
							echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="" ' . $checked . ' />';
							echo '<span class="control__indicator"></span></label>';

							$counter = 1;
							foreach ( $options as $keyword => $option ) {
								echo '<label for="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '"><span class="rh_checkbox__title">' . esc_html( $option ) . '</span>';
								$checked = ( inspiry_is_edit_property() && ! empty( $value ) && in_array( $option, $value ) ) ? 'checked' : '';
								echo '<input type="radio" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '-' . esc_attr( $counter ) . '" value="' . esc_attr( $option ) . '" ' . $checked . ' />';
								echo '<span class="control__indicator"></span></label>';
								$counter ++;
							}
							?>
                        </div>
                    </div>
					<?php
				}
			}
		}
	}

	public function inspiry_property_submit_additional_fields() {
		/**
		 * Add property additional fields to the property submit/edit page
		 */

		$additional_fields = $this->get_additional_fields( 'submit' );

		if ( ! empty( $additional_fields ) ) {
		    $counter = 0;
			foreach ( $additional_fields as $field ) {

				if( 'classic' == INSPIRY_DESIGN_VARIATION ) {
					if ( $counter % 3 == 0 && $counter > 0 ) {
						echo "<div class='clearfix'></div>";
					}
                }

				if ( 'text' == $field['field_type'] || 'textarea' == $field['field_type'] ) {
					$this->inspiry_submit_page_field_html( $field['field_key'], $field['field_name'], $field['field_type'] );
				} elseif ( 'select' == $field['field_type'] || in_array( $field['field_type'], array(
						'select',
						'checkbox_list',
						'radio'
					) ) ) {
					$this->inspiry_submit_page_field_html( $field['field_key'], $field['field_name'], $field['field_type'], $field['field_options'] );
				}

				$counter++;
			}
		}
	}

	public function inspiry_property_submit_additional_fields_update( $id ) {
		/**
		 * Update property additional fields values on property submit/edit page
		 */

		$additional_fields = $this->get_additional_fields( 'submit' );

		if ( ! empty( $additional_fields ) ) {
			foreach ( $additional_fields as $field ) {
				// Update post meta value if it is available otherwise delete against the current key
				if ( isset( $_POST[ $field['field_key'] ] ) && ! empty( $_POST[ $field['field_key'] ] ) ) {
					if ( 'checkbox_list' == $field['field_type'] ) {
						delete_post_meta( $id, $field['field_key'] );
						foreach ( $_POST[ $field['field_key'] ] as $value ) {
							add_post_meta( $id, $field['field_key'], sanitize_text_field( $value ) );
						}
					} else {
						update_post_meta( $id, $field['field_key'], sanitize_text_field( $_POST[ $field['field_key'] ] ) );
					}
				} else {
					delete_post_meta( $id, $field['field_key'] );
				}
			}
		}
	}

	public function inspiry_search_form_field_html( $key, $name, $type, $options = [] ) {
		/**
		 * Display property additional fields html for the advance search form
		 */

		if ( 'classic' == INSPIRY_DESIGN_VARIATION ) {
			if ( in_array( $type, array( 'text', 'textarea' ) ) ) {
				?>
                <div class="option-bar rh-search-field">
                    <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                    <input type="text"
                           name="<?php echo esc_attr( $key ); ?>"
                           id="<?php echo esc_attr( $key ); ?>"
                           value="<?php echo isset( $_GET[ $key ] ) ? esc_attr( $_GET[ $key ] ) : ''; ?>"
                           placeholder="<?php echo esc_attr( rh_any_text() ); ?>"/>
                </div>
				<?php
			} else {
				?>
                <div class="option-bar rh-search-field large">
                    <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                    <span class="selectwrap">
                        <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="inspiry_select_picker_trigger show-tick">
                            <?php
                            // Display default select option
                            $selected = empty( $_GET[ $key ] ) ? 'selected="selected"' : '';
                            echo '<option value="' . inspiry_any_value() . '" ' . $selected . '>' . esc_html( rh_any_text() ) . '</option>';

                            // Display all available select options
                            foreach ( $options as $keyword => $option ) {
	                            $selected = ( ! empty( $_GET[ $key ] ) && ( $_GET[ $key ] === $keyword ) ) ? 'selected="selected"' : '';
	                            echo '<option value="' . esc_attr( $keyword ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
                            }
                            ?>
                        </select>
                    </span>
                </div>
				<?php
			}
		} else {
			if ( in_array( $type, array( 'text', 'textarea' ) ) ) {
				?>
                <div class="rh_prop_search__option rh_mod_text_field">
                    <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                    <input type="<?php echo esc_attr( $type ); ?>"
                           name="<?php echo esc_attr( $key ); ?>"
                           id="<?php echo esc_attr( $key ); ?>"
                           value="<?php echo isset( $_GET[ $key ] ) ? esc_attr( $_GET[ $key ] ) : ''; ?>"
                           placeholder="<?php echo esc_attr( rh_any_text() ); ?>"/>
                </div>
				<?php
			} else {
				?>
                <div class="rh_prop_search__option rh_prop_search__select inspiry_select_picker_field">
                    <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
                    <span class="rh_prop_search__selectwrap">
                        <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="inspiry_select_picker_trigger inspiry_bs_green show-tick">
                            <?php
                            // Display default select option
                            $selected = empty( $_GET[ $key ] ) ? 'selected="selected"' : '';
                            echo '<option value="' . inspiry_any_value() . '" ' . $selected . '>' . esc_html( rh_any_text() ) . '</option>';

                            // Display all available select options
                            foreach ( $options as $keyword => $option ) {
	                            $selected = ( ! empty( $_GET[ $key ] ) && ( $_GET[ $key ] === $keyword ) ) ? 'selected="selected"' : '';
	                            echo '<option value="' . esc_attr( $keyword ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
                            }
                            ?>
                        </select>
                    </span>
                </div>
				<?php
			}
		}
	}

	public function inspiry_search_additional_fields() {
		/**
		 * Add property additional fields to the advance search form
		 */

		$additional_fields = $this->get_additional_fields( 'search' );

		if ( ! empty( $additional_fields ) ) {
			foreach ( $additional_fields as $field ) {

				if ( in_array( $field['field_type'], array( 'text', 'textarea' ) ) ) {

					if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
						$field['field_name'] = apply_filters( 'wpml_translate_single_string', $field['field_name'], 'Additional Fields', $field['field_name'] . ' Label', ICL_LANGUAGE_CODE );
					}

					$this->inspiry_search_form_field_html( $field['field_key'], $field['field_name'], $field['field_type'] );
				} elseif ( in_array( $field['field_type'], array('select', 'checkbox_list', 'radio' ) ) ) {

					if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
						$options                = explode( ',', apply_filters( 'wpml_translate_single_string', implode( ',', $field['field_options'] ), 'Additional Fields', $field['field_name'] . ' Value', ICL_LANGUAGE_CODE ) );
						$field['field_options'] = array_combine( $options, $options );
						$field['field_name']    = apply_filters( 'wpml_translate_single_string', $field['field_name'], 'Additional Fields', $field['field_name'] . ' Label', ICL_LANGUAGE_CODE );
					}

					$this->inspiry_search_form_field_html( $field['field_key'], $field['field_name'], $field['field_type'], $field['field_options'] );
				}
			}
		}
	}

	public function inspiry_search_additional_fields_filter( $meta_query ) {
		/**
		 * Add property additional fields to the properties meta query
		 */

		$additional_fields = $this->get_additional_fields( 'search' );

		if ( $additional_fields ) {
			foreach ( $additional_fields as $field ) {
				if ( ( ! empty( $_GET[ $field['field_key'] ] ) ) && ( $_GET[ $field['field_key'] ] != inspiry_any_value() ) ) {
					$meta_query[] = array(
						'key'     => $field['field_key'],
						'value'   => $_GET[ $field['field_key'] ],
						'compare' => 'LIKE'
					);
				}
			}
		}

		return $meta_query;
	}

	public function get_additional_fields( $location = 'all' ) {
		/**
		 * Return a valid list of property additional fields
		 */

		$additional_fields = get_option( 'inspiry_property_additional_fields' );
		$build_fields      = array();

		if ( ! empty( $additional_fields['inspiry_additional_fields_list'] ) ) {
			foreach ( $additional_fields['inspiry_additional_fields_list'] as $field ) {

				// Ensure all required values of a field are available then add it to the fields list
				if ( ( $location == 'all' || ( ! empty( $field['field_display'] ) && in_array( $location, $field['field_display'] ) ) ) && ! empty( $field['field_type'] ) && ! empty( $field['field_name'] ) ) {

					// Prepare select field options list
					if ( in_array( $field['field_type'], array( 'select', 'checkbox_list', 'radio' ) ) ) {
						if ( empty( $field['field_options'] ) ) {
							$field['field_type'] = 'text';
						} else {
							$options                = explode( ',', $field['field_options'] );
							$options                = array_filter( array_map( 'trim', $options ) );
							$field['field_options'] = array_combine( $options, $options );
						}
					}

					// Set the field icon and unique key
					$field['field_icon'] = empty( $field['field_icon'] ) ? '' : $field['field_icon'];
					$field['field_key']  = 'inspiry_' . strtolower( preg_replace( '/\s+/', '_', $field['field_name'] ) );

					// Add final field to the fields list
					$build_fields[] = $field;
				}
			}
		}

		// Return additional fields array
		return $build_fields;
	}
}

function Property_Additional_Fields() {
	return Property_Additional_Fields::instance();
}

// Get Property_Additional_Fields Running.
Property_Additional_Fields();
