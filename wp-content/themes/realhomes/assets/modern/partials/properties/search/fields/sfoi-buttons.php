<div class="rh_sfoi_buttons_wrapper">
    <div class="rh_mod_sfoi_advanced_expander">
		<?php inspiry_safe_include_svg( '/images/icons/icon-search-plus.svg' ); ?>
    </div>
    <div class="rh_mode_sfoi_search_btn rh_prop_search__searchBtn">
		<?php $inspiry_search_button_text = get_option( 'inspiry_search_button_text' ); ?>
        <button class="rh_btn rh_btn_sfoi rh_btn__prop_search"
                type="submit">
			<?php inspiry_safe_include_svg( '/images/icons/icon-search.svg' ); ?>
            <span>
                <?php
                if ( ! empty( $inspiry_search_button_text ) ) {
	                echo esc_html( $inspiry_search_button_text );
                } else {
	                echo esc_html__( 'Search', 'framework' );
                }
                ?>
            </span>
        </button>
    </div>
</div>