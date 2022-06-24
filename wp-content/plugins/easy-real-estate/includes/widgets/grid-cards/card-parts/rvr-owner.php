<?php
$REAL_HOMES_property_owner = get_post_meta( get_the_ID(), 'rvr_property_owner', true );

if ( ! empty( $REAL_HOMES_property_owner ) ) {
	?>
    <div class="rh_agent_expand_wrapper">
        <div class="rh_agent_list">

			<?php
			if ( has_post_thumbnail( $REAL_HOMES_property_owner ) ) {
				?>
                <span class="agent-image">
	<?php echo get_the_post_thumbnail( $REAL_HOMES_property_owner, 'agent-image' ); ?>
	</span>
				<?php
			}
			?>
            <div class="rh_agent_agency">
                    <span class="rh_owner_label">
	            <?php esc_html_e( 'Owner', 'easy-real-estate' ); ?>
                    </span>
                <span class="rh_owner_title">
	<?php echo get_the_title( $REAL_HOMES_property_owner ); ?>
		        </span>
            </div>
        </div>
    </div>
<?php } ?>