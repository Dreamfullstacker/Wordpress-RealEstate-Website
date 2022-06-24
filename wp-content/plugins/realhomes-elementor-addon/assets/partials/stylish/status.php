<?php

if ( has_term('', 'property-status', get_the_ID() )) {
global $settings;
$repeater_status = $settings['rhea_property_status_select'];
$status_terms    = get_the_terms( get_the_ID(), 'property-status' );

$first_status_slug = $status_terms[0]->slug;
$first_status_name = $status_terms[0]->name;

$this_status_bg     = '';
$this_status_colors = '';
foreach ( $repeater_status as $status ) {

	if ( $status['rhea_property_status_select_section'] == $first_status_slug ) {


		if ( $status['rhea_get_terms_bg'] ) {
			$this_status_bg = $status['rhea_get_terms_bg'];
		}
		if ( $status['rhea_get_terms_colors'] ) {
			$this_status_colors = $status['rhea_get_terms_colors'];
		}
	}
}

?>
<div class="rhea_soi_prop_status_sty">
<span class="rhea_prop_status_sty"
      style=" <?php
      if (!empty($this_status_bg)){ echo 'background: '.esc_attr( $this_status_bg ). ' ;' ; }
      if(!empty($this_status_colors)){echo 'color: ' .esc_attr( $this_status_colors ). ' ;';}
      ?>  ">
    <?php echo esc_html( $first_status_name ); ?></span>
</div>
<?php
}
    ?>