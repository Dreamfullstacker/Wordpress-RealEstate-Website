<div class="dashboard-tab-content form-fields" data-content-title="<?php esc_html_e( 'Vacation Rentals', 'framework' ); ?>">
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <p>
                <label for="rvr_guests_capacity"><?php esc_html_e( 'Guests Capacity', 'framework' ); ?> <span><?php esc_html_e( 'Example: 4', 'framework' ); ?></span></label>
                <input id="rvr_guests_capacity" name="rvr_guests_capacity" type="text" value="<?php
                if ( realhomes_dashboard_edit_property() ) {
	                global $post_meta_data;
	                if ( isset( $post_meta_data['rvr_guests_capacity'] ) ) {
		                echo esc_attr( $post_meta_data['rvr_guests_capacity'][0] );
	                }
                } elseif ( isset( $_GET['rvr_guests_capacity'] ) && ! empty( $_GET['rvr_guests_capacity'] ) ) {
	                echo esc_attr( $_GET['rvr_guests_capacity'] );
                }
				?>"/>
            </p>
        </div>
        <div class="col-md-6 col-lg-4">
            <p>
                <label for="rvr_min_stay"><?php esc_html_e( 'Minimum Number of Nights to Stay', 'framework' ); ?> <span><?php esc_html_e( 'Example: 1', 'framework' ); ?></span></label>
                <input id="rvr_min_stay" name="rvr_min_stay" type="text" value="<?php
				if ( realhomes_dashboard_edit_property() ) {
					global $post_meta_data;
					if ( isset( $post_meta_data['rvr_min_stay'] ) ) {
						echo esc_attr( $post_meta_data['rvr_min_stay'][0] );
					}
				}
				?>"/>
            </p>
        </div>
        <div class="col-md-6 col-lg-4">
            <p>
                <label for="rvr_govt_tax"><?php esc_html_e( 'Percentage of Govt Tax', 'framework' ); ?> <span><?php esc_html_e( 'Example: 16', 'framework' ); ?></span></label>
                <input id="rvr_govt_tax" name="rvr_govt_tax" type="text" value="<?php
				if ( realhomes_dashboard_edit_property() ) {
					global $post_meta_data;
					if ( isset( $post_meta_data['rvr_govt_tax'] ) ) {
						echo esc_attr( $post_meta_data['rvr_govt_tax'][0] );
					}
				}
				?>"/>
            </p>
        </div>
        <div class="col-md-6 col-lg-4">
            <p>
                <label for="rvr_service_charges"><?php esc_html_e( 'Percentage of Service Charges', 'framework' ); ?> <span><?php esc_html_e( 'Example: 3', 'framework' ); ?></span></label>
                <input id="rvr_service_charges" name="rvr_service_charges" type="text" value="<?php
				if ( realhomes_dashboard_edit_property() ) {
					global $post_meta_data;
					if ( isset( $post_meta_data['rvr_service_charges'] ) ) {
						echo esc_attr( $post_meta_data['rvr_service_charges'][0] );
					}
				}
				?>"/>
            </p>
        </div>
        <div class="col-md-6 col-lg-4">
            <p>
                <label for="rvr_property_owner"><?php esc_html_e( 'Owner', 'framework' ); ?></label>
                <select name="rvr_property_owner" id="rvr_property_owner" class="inspiry_select_picker_trigger show-tick"
                        title="<?php esc_attr_e( 'None', 'framework' ) ?>">
					<?php
					if ( realhomes_dashboard_edit_property() ) {
						global $post_meta_data;
						if ( isset( $post_meta_data['rvr_property_owner'] ) ) {
							generate_posts_list( 'owner', $post_meta_data['rvr_property_owner'] );
						} else {
							generate_posts_list( 'owner' );
						}
					} else {
						generate_posts_list( 'owner' );
					}
					?>
                </select>
            </p>
        </div>
    </div>

    <div class="inspiry-repeater-wrapper">
        <label class="label-boxed"><?php esc_html_e( 'Outdoor Features', 'framework' ); ?></label>
        <div id="inspiry-repeater-container-rvr-outdoor-features" class="inspiry-repeater-container">
			<?php
			$rvr_outdoor_features_fields = array( array( 'name' => 'rvr_outdoor_features[]' ) );

			if ( realhomes_dashboard_edit_property() ) {
				global $target_property;

				$rvr_outdoor_features = get_post_meta( $target_property->ID, 'rvr_outdoor_features', true );
				if ( ! empty( $rvr_outdoor_features ) ) {
					// Remove empty values.
					$rvr_outdoor_features = array_filter( $rvr_outdoor_features );
				}

				if ( ! empty( $rvr_outdoor_features ) ) {
					foreach ( $rvr_outdoor_features as $key => $rvr_outdoor_feature ) {
						$rvr_outdoor_features_fields[0]['value'] = $rvr_outdoor_feature;
						inspiry_repeater_group( $rvr_outdoor_features_fields, false, $key );
					}
				} else {
					inspiry_repeater_group( $rvr_outdoor_features_fields );
				}
			} else {
				inspiry_repeater_group( $rvr_outdoor_features_fields );
			}
			?>
        </div>
        <button class="inspiry-repeater-add-field-btn btn btn-primary"><i class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="inspiry-repeater-wrapper">
                <label class="label-boxed"><?php esc_html_e( 'What is included', 'framework' ); ?></label>
                <div id="inspiry-repeater-container-rvr-included" class="inspiry-repeater-container">
					<?php
					$rvr_included_fields = array( array( 'name' => 'rvr_included[]' ) );

					if ( realhomes_dashboard_edit_property() ) {
						global $target_property;

						$rvr_included = get_post_meta( $target_property->ID, 'rvr_included', true );
						if ( ! empty( $rvr_included ) ) {
							// Remove empty values.
							$rvr_included = array_filter( $rvr_included );
						}

						if ( ! empty( $rvr_included ) ) {
							foreach ( $rvr_included as $key => $rvr_included_field ) {
								$rvr_included_fields[0]['value'] = $rvr_included_field;
								inspiry_repeater_group( $rvr_included_fields, false, $key );
							}
						} else {
							inspiry_repeater_group( $rvr_included_fields );
						}
					} else {
						inspiry_repeater_group( $rvr_included_fields );
					}
					?>
                </div>
                <button class="inspiry-repeater-add-field-btn btn btn-primary"><i class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="inspiry-repeater-wrapper">
                <label class="label-boxed"><?php esc_html_e( 'What is not included', 'framework' ); ?></label>
                <div id="inspiry-repeater-container-rvr-not-included" class="inspiry-repeater-container">
					<?php
					$rvr_not_included_fields = array( array( 'name' => 'rvr_not_included[]' ) );

					if ( realhomes_dashboard_edit_property() ) {
						global $target_property;

						$rvr_not_included = get_post_meta( $target_property->ID, 'rvr_not_included', true );
						if ( ! empty( $rvr_not_included ) ) {
							// Remove empty values.
							$rvr_not_included = array_filter( $rvr_not_included );
						}

						if ( ! empty( $rvr_not_included ) ) {
							foreach ( $rvr_not_included as $key => $rvr_not_included_field ) {
								$rvr_not_included_fields[0]['value'] = $rvr_not_included_field;
								inspiry_repeater_group( $rvr_not_included_fields, false, $key );
							}
						} else {
							inspiry_repeater_group( $rvr_not_included_fields );
						}
					} else {
						inspiry_repeater_group( $rvr_not_included_fields );
					}
					?>
                </div>
                <button class="inspiry-repeater-add-field-btn btn btn-primary"><i class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
            </div>
        </div>
    </div>

    <div class="inspiry-repeater-wrapper">
        <label class="label-boxed"><?php esc_html_e( 'Property Surroundings', 'framework' ); ?></label>
        <div class="inspiry-repeater-header">
            <p class="title"><?php esc_html_e( 'Point of Interest', 'framework' ); ?></p>
            <p class="value"><?php esc_html_e( 'Distance or How to approach', 'framework' ); ?></p>
        </div>
        <div id="inspiry-repeater-container-rvr-surroundings" class="inspiry-repeater-container">
			<?php
			$rvr_surroundings_fields = array(
				array( 'name' => 'rvr_surroundings[0][rvr_surrounding_point]' ),
				array( 'name' => 'rvr_surroundings[0][rvr_surrounding_point_distance]' )
			);

			if ( realhomes_dashboard_edit_property() ) {
				global $target_property;

				$rvr_surroundings = get_post_meta( $target_property->ID, 'rvr_surroundings', true );
				if ( ! empty( $rvr_surroundings ) ) {
					// Remove empty values.
					$rvr_surroundings = array_filter( $rvr_surroundings );
				}

				if ( ! empty( $rvr_surroundings ) ) {
					foreach ( $rvr_surroundings as $key => $rvr_surrounding ) {
						$rvr_surroundings_fields[0]['name']  = 'rvr_surroundings[' . $key . '][rvr_surrounding_point]';
						$rvr_surroundings_fields[0]['value'] = $rvr_surrounding['rvr_surrounding_point'];
						$rvr_surroundings_fields[1]['name']  = 'rvr_surroundings[' . $key . '][rvr_surrounding_point_distance]';
						$rvr_surroundings_fields[1]['value'] = $rvr_surrounding['rvr_surrounding_point_distance'];
						inspiry_repeater_group( $rvr_surroundings_fields, false, $key );
					}
				} else {
					inspiry_repeater_group( $rvr_surroundings_fields );
				}
			} else {
				inspiry_repeater_group( $rvr_surroundings_fields );
			}
			?>
        </div>
        <button class="inspiry-repeater-add-field-btn btn btn-primary"><i class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
    </div>

    <div class="inspiry-repeater-wrapper">
        <label class="label-boxed"><?php esc_html_e( 'Property Policies or Rules', 'framework' ); ?></label>
        <div class="inspiry-repeater-header">
            <p class="title"><?php esc_html_e( 'Policy Text', 'framework' ); ?></p>
            <p class="value"><?php esc_html_e( 'Font Awesome Icon (i.e far fa-star)', 'framework' ); ?></p>
        </div>
        <div id="inspiry-repeater-container-rvr-policies" class="inspiry-repeater-container">
			<?php
			$rvr_policies_fields = array(
				array( 'name' => 'rvr_policies[0}][rvr_policy_detail]' ),
				array( 'name' => 'rvr_policies[0}][rvr_policy_icon]' )
			);

			if ( realhomes_dashboard_edit_property() ) {
				global $target_property;

				$rvr_policies = get_post_meta( $target_property->ID, 'rvr_policies', true );
				if ( ! empty( $rvr_policies ) ) {
					// Remove empty values.
					$rvr_policies = array_filter( $rvr_policies );
				}

				if ( ! empty( $rvr_policies ) ) {
					foreach ( $rvr_policies as $key => $rvr_policy ) {
						$rvr_policies_fields[0]['name']  = 'rvr_policies[' . $key . '][rvr_policy_detail]';
						$rvr_policies_fields[0]['value'] = $rvr_policy['rvr_policy_detail'];
						$rvr_policies_fields[1]['name']  = 'rvr_policies[' . $key . '][rvr_policy_icon]';
						$rvr_policies_fields[1]['value'] = $rvr_policy['rvr_policy_icon'];
						inspiry_repeater_group( $rvr_policies_fields, false, $key );
					}
				} else {
					inspiry_repeater_group( $rvr_policies_fields );
				}
			} else {
				inspiry_repeater_group( $rvr_policies_fields );
			}
			?>
        </div>
        <button class="inspiry-repeater-add-field-btn btn btn-primary"><i class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
    </div>

</div>
