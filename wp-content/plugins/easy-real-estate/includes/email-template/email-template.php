<?php
/**
 * Email Template.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_info        = get_bloginfo( 'name' );
$site_logo        = get_option( 'theme_sitelogo' );
$site_logo_retina = get_option( 'theme_sitelogo_retina' );
if ( ! empty( $site_logo_retina ) ) {
	$site_logo = $site_logo_retina;
}

$header_content     = get_option( 'ere_email_template_header_content', 'image' );
$header_title_color = get_option( 'ere_email_template_header_title_color', '#333333' );
$background_color   = get_option( 'ere_email_template_background_color', '#e9eaec' );
$body_link_color    = get_option( 'ere_email_template_body_link_color', '#ff7f50' );
$footer_text        = get_option( 'ere_email_template_footer_text', '' );
$footer_text_color  = get_option( 'ere_email_template_footer_text_color', '#aaaaaa' );
$footer_link_color  = get_option( 'ere_email_template_footer_link_color', '#949494' );
$text_direction     = is_rtl() ? 'rtl' : 'ltr';
?>
<!doctype html>
<html dir="<?php echo $text_direction; ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo get_bloginfo( 'name' ); ?></title>
	<style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:50px 50px;
		}
		.templateContainer{
			max-width:600px !important;
			border:0;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		body{
			font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
			background-color:<?php echo $background_color; ?>;
			color:#202020;
		}
		h1{
			font-size:26px;
		}
		h2{
			font-size:22px;
		}
		h3{
			font-size:20px;
		}
		h4{
			font-size:18px;
		}
		#templateHeader{
			border-top:0;
			border-bottom:0;
			padding-top:0;
			padding-bottom:20px;
			text-align: center;
		}
		#templateBody{
			background-color:#FFFFFF;
			border-top:0;
			border: 1px solid #c1c1c1;
			padding-top:0;
			padding-bottom:0px;
		}
		#templateBody .mcnTextContent,
		#templateBody .mcnTextContent p{
			color:#555555;
			font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
			font-size:14px;
			line-height:150%;
		}
		#templateBody .mcnTextContent a,
		#templateBody .mcnTextContent p a{
			color:<?php echo $body_link_color; ?>;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateFooter{
			border-top:0;
			border-bottom:0;
			padding-top:12px;
			padding-bottom:12px;
		}
		#templateFooter .mcnTextContent,
		#templateFooter .mcnTextContent p{
			color:<?php echo $footer_text_color; ?>;
			font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
			font-size:12px;
			line-height:150%;
			text-align:center;
		}
		#templateFooter .mcnTextContent a,
		#templateFooter .mcnTextContent p a{
			color:<?php echo $footer_link_color; ?>;
			font-weight:normal;
			text-decoration:underline;
		}
		@media only screen and (min-width:768px){
			.templateContainer{
				width:600px !important;
			}
		}
		@media only screen and (max-width: 480px){
			body,table,td,p,a,li,blockquote{
				-webkit-text-size-adjust:none !important;
			}
		}
		@media only screen and (max-width: 480px){
			body{
				width:100% !important;
				min-width:100% !important;
			}
		}
		@media only screen and (max-width: 680px){
			#bodyCell{
				padding:20px 20px !important;
			}
		}
		@media only screen and (max-width: 480px){
			.mcnTextContentContainer{
				max-width:100% !important;
				width:100% !important;
			}
		}
	</style>
</head>
<body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: <?php echo $background_color; ?>;">
	<center>
		<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
			<tr>
				<td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 50px 50px;width: 100%;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;max-width: 600px !important;">
						<?php
						if ( 'none' !== $header_content ) {
							if ( 'image' === $header_content || 'both' === $header_content ) {
								$header_image = get_option( 'ere_email_template_header_image' );
								if ( empty( $header_image ) ) {
									$header_image = $site_logo;
								}
								echo '<tr><td valign="top" align="center" id="templateHeader" style="padding-bottom:20px;text-align:center;">';
								echo '<img src="' . esc_url( $header_image ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />';
								echo '</td></tr>';
							}

							if ( 'title' === $header_content || 'both' === $header_content ) {
								$header_title = get_option( 'ere_email_template_header_title' );
								if ( empty( $header_title ) ) {
									$header_title = $blog_info;
								}
								echo '<tr><td valign="top" align="center" style="padding-bottom:40px;text-align:center;">';
								echo '<h2 style="font-size: 26px; color:' . esc_html( $header_title_color ) . ';">' . esc_html( $header_title ) . '</h2>';
								echo '</td></tr>';
							}
						}
						?>
						<tr>
							<td valign="top" id="templateBody" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border: 1px solid #c1c1c1;padding-top: 0;padding-bottom: 0px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
									<tbody class="mcnTextBlockOuter">
										<tr>
											<td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer">
													<tbody>
														<tr>
															<td valign="top" style="padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;" class="mcnTextContent">
                                                                {{body_fields}}
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="top" id="templateFooter" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border-top: 0;border-bottom: 0;padding-top: 12px;padding-bottom: 12px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
									<tbody class="mcnTextBlockOuter">
									<tr>
										<td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
											<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer">
												<tbody>
												<tr>
													<td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: <?php echo $footer_text_color; ?>;font-family: Helvetica;font-size: 12px;line-height: 150%;text-align: center;">
														<?php
														if ( ! empty( $footer_text ) ) {
															echo wp_kses( $footer_text, array(
																'a'      => array(
																	'href'   => true,
																	'target' => true,
																),
																'i'      => array(),
																'em'     => array(),
																'b'      => array(),
																'strong' => array(),
															) );
														} else {
                                                            echo esc_html__( 'Sent from ', 'easy-real-estate' ) . '<a href="' . esc_url( home_url() ) . '" style="color:' . esc_html(  $footer_link_color ) . ';">' . wp_specialchars_decode( $blog_info ) . '</a>';
														}
                                                        ?>
													</td>
												</tr>
												</tbody>
											</table>
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>
