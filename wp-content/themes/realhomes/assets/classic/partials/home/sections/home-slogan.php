<?php
/* Slogan Title and Text */
$slogan_title = get_post_meta( get_the_ID(), 'theme_slogan_title', true );
$slogan_text  = get_post_meta( get_the_ID(), 'theme_slogan_text', true );

?>
<div class="narrative">
	<?php
	if ( ! empty( $slogan_title ) ) {
		?><h2><?php echo stripslashes( $slogan_title ); ?></h2><?php

	}

	if ( ! empty( $slogan_text ) ) {
		?><div class="home-slogan-text"><?php echo wpautop( $slogan_text ); ?></div><?php
	}
	?>
</div>