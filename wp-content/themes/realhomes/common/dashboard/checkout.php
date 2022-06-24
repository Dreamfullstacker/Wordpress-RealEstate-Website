<?php
if ( method_exists( 'IMS_Helper_Functions', 'checkout_form' ) ) {
	IMS_Helper_Functions::checkout_form( realhomes_get_dashboard_page_url( 'membership&submodule=order' ) );
}