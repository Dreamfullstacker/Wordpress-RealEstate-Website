<div class="360-virtual-tour-field-wrapper">
    <p>
        <label for="REAL_HOMES_360_virtual_tour"><?php esc_html_e( '360 Virtual Tour', 'framework' ); ?></label>
        <textarea name="REAL_HOMES_360_virtual_tour" id="REAL_HOMES_360_virtual_tour" cols="30" rows="3"><?php
			if ( realhomes_dashboard_edit_property() ) {
				global $post_meta_data;
				if ( isset( $post_meta_data['REAL_HOMES_360_virtual_tour'] ) ) {
					echo wp_kses( $post_meta_data['REAL_HOMES_360_virtual_tour'][0], inspiry_embed_code_allowed_html() );
				}
			}
			?></textarea>

        <span class="note"><?php
			echo wp_kses(
				sprintf( esc_html__( 'Provide iframe embed code or %s shortcode for the 360 virtual tour. For more details please consult %s in documentation.', 'framework' ),
					'<a href="https://wordpress.org/plugins/ipanorama-360-virtual-tour-builder-lite/" target="_blank">iPanorama</a>',
					'<a href="https://realhomes.io/documentation/add-property/#add-video-tour-and-virtual-tour" target="_blank">Add Property</a>'
				),
				inspiry_embed_code_allowed_html()
			);
			?></span>
    </p>
</div>