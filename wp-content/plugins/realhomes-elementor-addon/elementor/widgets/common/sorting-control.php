<?php

class RHEA_Sorting_Control extends \Elementor\Base_Control {

	public function get_type() {
		return 'rhea-select-unit-control';
	}

	protected function get_control_uid( $input_type = 'default' ) {
		return 'elementor-control-' . $input_type . '-{{{ data._cid }}}';
	}

	public function enqueue() {

		wp_enqueue_style( 'rhea-search-sorting-control', RHEA_PLUGIN_URL . 'elementor/css/search-sorting-control.css', array(), RHEA_VERSION, 'all' );
		wp_enqueue_script( 'rhea-sortable', RHEA_PLUGIN_URL . 'elementor/js/rhea-sortable.js', array( 'jquery' ), RHEA_VERSION );

	}

	public function content_template() {
		global $sorting_settings;
		$get_stored_order = array(
			'location',
			'status',
			'type',
			'min-max-price',
			'min-beds',
			'min-baths',
			'min-garages',
			'agent',
			'min-max-area',
			'keyword-search',
			'property-id',
		);
		if ( ! is_array( $sorting_settings ) && ! empty( $sorting_settings ) ) {
			$get_stored_order = explode( ',', $sorting_settings );
		}


		$control_uid   = 'rhea_sortable-' . $this->get_control_uid();
		$search_fields = array(
			'location'       => esc_html__( 'Property Location', 'realhomes-elementor-addon' ),
			'status'         => esc_html__( 'Property Status', 'realhomes-elementor-addon' ),
			'type'           => esc_html__( 'Property Type', 'realhomes-elementor-addon' ),
			'min-max-price'  => esc_html__( 'Min and Max Price', 'realhomes-elementor-addon' ),
			'min-beds'       => esc_html__( 'Min Beds', 'realhomes-elementor-addon' ),
			'min-baths'      => esc_html__( 'Min Baths', 'realhomes-elementor-addon' ),
			'min-garages'    => esc_html__( 'Min Garages', 'realhomes-elementor-addon' ),
			'agent'          => esc_html__( 'Agent', 'realhomes-elementor-addon' ),
			'min-max-area'   => esc_html__( 'Min and Max Area', 'realhomes-elementor-addon' ),
			'keyword-search' => esc_html__( 'Keyword Search', 'realhomes-elementor-addon' ),
			'property-id'    => esc_html__( 'Property ID', 'realhomes-elementor-addon' ),

		);


		$additional_fields = get_option( 'inspiry_property_additional_fields' );
		$builder_fields    = array();
		if ( ! empty( $additional_fields['inspiry_additional_fields_list'] ) ) {
			foreach ( $additional_fields['inspiry_additional_fields_list'] as $field ) {
				if ( isset( $field['field_display'] ) && in_array( 'search', $field['field_display'] ) ) {
					$key                    = strtolower( str_replace( " ", "-", $field['field_name'] ) );
					$builder_fields[ $key ] = $field['field_name'];
				}
			}
			$search_fields = array_merge( $search_fields, $builder_fields );
		}


		$search_fields = apply_filters( 'rhea_sort_search_fields', $search_fields );

		if ( ! empty( $get_stored_order ) && is_array( $get_stored_order ) ) {
			$search_fields = array_merge( array_flip( $get_stored_order ), $search_fields );
		}


		?>


        <div class="rhea_sorting_control_wrapper">


            <ul class="the_test_ul rhea-sorting-list-<?php echo esc_attr( $control_uid ); ?>">

            </ul>


            <input type="hidden" class="sort-rhea" id="rhea-sorting-<?php echo esc_attr( $control_uid ); ?>"
                   data-setting="{{{ data.name }}}">

        </div>

        <script type="application/javascript">


            jQuery(document).ready(function () {

                function swapToJson(json){
                    var ret = {};
                    for(var key in json){
                        ret[json[key]] = key;
                    }
                    return ret;
                }

                function generateList(id,fields,stored){

                    var getInputValue = jQuery("#rhea-sorting-<?php echo esc_attr( $control_uid ); ?>").val();

                    var inputArray = getInputValue.split(',');


                    var getStored = stored;

                     var setStored ;

                    if(getInputValue === ''){
                         setStored = getStored;
                    }else{
                        setStored = inputArray;
                    }

                    var swapArray = swapToJson(inputArray);

                    var mergeArray = jQuery.extend(swapArray,fields);



                    var SetFields;
                    if(getInputValue === ''){
                         SetFields = fields
                    }else{
                        SetFields = mergeArray;
                    }
                    jQuery.each(SetFields,function (get_index,element) {


                        if(jQuery.inArray(get_index,setStored)>= 0){
                            var getCheck = 'checked';
                        }else{
                            getCheck = '';
                        }
                        jQuery(id).append('<li><label><input type="checkbox" ' +getCheck+ ' value="'+get_index+'" > '+element+'</label></li>');

                    });

                }

                generateList(".rhea-sorting-list-<?php echo esc_attr( $control_uid ); ?>",<?php echo json_encode($search_fields)?>,<?php echo json_encode($get_stored_order); ?>);

                function RheaTrigerChange() {
                    var checkbox_values = jQuery("<?php echo '.rhea-sorting-list-' . $control_uid ?>").find('input[type="checkbox"]:checked').map(
                        function () {
                            return this.value;
                        }
                    ).get().join(',');

                    //jQuery('#rhea-sorting-<?php //echo esc_attr( $control_uid ); ?>//').val(checkbox_values).trigger('change');
                    jQuery('.rhea_sorting_control_wrapper .sort-rhea').val(checkbox_values).trigger('input');


                }

                jQuery("<?php echo '.rhea-sorting-list-' . $control_uid; ?> input[type='checkbox'] ").on('change', RheaTrigerChange);
                jQuery('.<?php echo 'rhea-sorting-list-' . $control_uid ?>').sortable({
                    // placeholder: "ui-state-highlight",
                    update: RheaTrigerChange

                });



            });

        </script>


		<?php
	}

}