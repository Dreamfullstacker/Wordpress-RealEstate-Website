<?php
/**
 * Field: Additional Details
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--1-column rh_form--columnAlign additional-details-fields-wrapper">

	<div class="inspiry-details-wrapper">

		<?php
		if ( inspiry_is_edit_property() ) {
			global $target_property;
			ere_additional_details_migration( $target_property->ID ); // Migrate property additional details from old metabox key to new key.
		}
		?>

		<label><?php esc_html_e( 'Additional Details', 'framework' ); ?></label>

		<!-- additional details container -->
		<div id="inspiry-additional-details-container">

			<?php
	        if ( inspiry_is_edit_property() ) {
	            global $target_property;

	            $additional_details = get_post_meta( $target_property->ID, 'REAL_HOMES_additional_details_list', true );

	            if ( ! empty( $additional_details ) ) {
	                foreach ( $additional_details as $field => $value ) {
	                    ?>
						<div class="inspiry-detail inputs clearfix">
							<div class="inspiry-detail-control">
								<i class="sort-detail fas fa-bars"></i>
							</div>
							<div class="inspiry-detail-title">
								<input type="text" name="detail-titles[]" value="<?php echo esc_attr( $value[0] ); ?>" />
							</div>
							<div class="inspiry-detail-value">
								<input type="text" name="detail-values[]" value="<?php echo esc_attr( $value[1] ); ?>" />
							</div>
							<div class="inspiry-detail-control">
								<a class="remove-detail" href="#"><i class="fas fa-trash-alt"></i></a>
							</div>
						</div>
						<?php

	                }
	            } else {
		            ?>
					<div class="inspiry-detail inputs clearfix">
						<div class="inspiry-detail-control">
							<i class="sort-detail fas fa-bars"></i>
						</div>
						<div class="inspiry-detail-title">
							<input type="text" name="detail-titles[]" value="" placeholder="<?php esc_attr_e( 'Title', 'framework' ); ?>" />
						</div>
						<div class="inspiry-detail-value">
							<input type="text" name="detail-values[]" value="" placeholder="<?php esc_attr_e( 'Value', 'framework' ); ?>" />
						</div>
						<div class="inspiry-detail-control">
							<a class="remove-detail" href="#"><i class="fas fa-trash-alt"></i></a>
						</div>
					</div>
					<?php
	            }
	        } else {

		        $default_details = apply_filters( 'inspiry_default_property_additional_details', array() );

		        if ( ! empty( $default_details ) ) {

			        foreach( $default_details as $title => $value ) {
				        ?>
				        <div class="inspiry-detail inputs clearfix">
					        <div class="inspiry-detail-control">
						        <i class="sort-detail fas fa-bars"></i>
					        </div>
					        <div class="inspiry-detail-title">
						        <input type="text" name="detail-titles[]" value="<?php echo esc_attr( $title ); ?>" />
					        </div>
					        <div class="inspiry-detail-value">
						        <input type="text" name="detail-values[]" value="<?php echo esc_attr( $value ); ?>" />
					        </div>
					        <div class="inspiry-detail-control">
						        <a class="remove-detail" href="#"><i class="fas fa-trash-alt"></i></a>
					        </div>
				        </div>
				        <?php
			        }

		        } else {
			        ?>
			        <div class="inspiry-detail inputs clearfix">
				        <div class="inspiry-detail-control rh_form--align_start">
					        <i class="sort-detail fas fa-bars"></i>
				        </div>
				        <div class="inspiry-detail-title">
					        <input type="text" name="detail-titles[]" value="" placeholder="<?php esc_attr_e( 'Title', 'framework' ); ?>" />
				        </div>
				        <div class="inspiry-detail-value">
					        <input type="text" name="detail-values[]" value="" placeholder="<?php esc_attr_e( 'Value', 'framework' ); ?>" />
				        </div>
				        <div class="inspiry-detail-control rh_form--align_end">
					        <a class="remove-detail" href="#"><i class="fas fa-trash-alt"></i></a>
				        </div>
			        </div>
			        <?php
		        }
	        }
	        ?>

		</div><!-- end of additional details container -->

		<div class="inspiry-detail clearfix">
			<div class="inspiry-detail-control">
				<a class="add-detail" href="#"><i class="fas fa-plus"></i></a>
			</div>
		</div>

	</div>

</div>
<!-- /.rh_form__item -->
