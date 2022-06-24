<div class="option-bar rh-search-field large">
    <label for="rvr-check-in"><?php echo esc_html__( 'Check In', 'framework' ); ?></label>
    <input type="text" name="check-in" id="rvr-check-in" placeholder="<?php echo esc_html__( 'Any', 'framework' ); ?>" title="<?php esc_html_e( 'Only provide digits!', 'framework' ); ?>" value="<?php echo ! empty( $_GET['check-in'] ) ? $_GET['check-in'] : ''; ?>" autocomplete="off"/>
</div>

<div class="option-bar rh-search-field large">
    <label for="rvr-check-out"><?php echo esc_html__( 'Check Out', 'framework' ); ?></label>
    <input type="text" name="check-out" id="rvr-check-out" placeholder="<?php echo esc_html__( 'Any', 'framework' ); ?>" title="<?php esc_html_e( 'Only provide digits!', 'framework' ); ?>" value="<?php echo ! empty( $_GET['check-out'] ) ? $_GET['check-out'] : ''; ?>" autocomplete="off"/>
</div>