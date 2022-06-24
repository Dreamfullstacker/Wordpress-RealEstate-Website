<?php
global $settings;
$REAL_HOMES_property_owner = get_post_meta( get_the_ID(), 'rvr_property_owner', true );

if ( ! empty( $REAL_HOMES_property_owner ) ) {
	?>
    <div class="rhea_fp_agent_expand_wrapper">
        <div class="rhea_fp_agent_list">

			<?php
			if ( has_post_thumbnail( $REAL_HOMES_property_owner ) ) {
				?>
                <span class="agent-image">
	<?php echo get_the_post_thumbnail( $REAL_HOMES_property_owner, 'agent-image' ); ?>
	</span>
				<?php
			}
			?>
            <div class="rhea_agent_agency">
				<?php
				if ( ! empty( $settings['ere_property_owner_label'] ) ) {
					?>
                    <span class="rhea_owner_label">
	            <?php echo esc_html( $settings['ere_property_owner_label'] ); ?>
                    </span>
					<?php
				}
				?>
                <span class="rhea_owner_title">
	<?php echo get_the_title( $REAL_HOMES_property_owner ); ?>
		        </span>
            </div>
        </div>
    </div>
<?php } ?>