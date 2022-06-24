<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_currency_sign              = $this->get_option( 'theme_currency_sign', '$' );
$theme_currency_position          = $this->get_option( 'theme_currency_position', 'before' );
$theme_decimals                   = $this->get_option( 'theme_decimals', '0' );
$theme_dec_point                  = $this->get_option( 'theme_dec_point', '.' );
$theme_thousands_sep              = $this->get_option( 'theme_thousands_sep', ',' );
$theme_no_price_text              = $this->get_option( 'theme_no_price_text' );
$ere_price_number_format_language = $this->get_option( 'ere_price_number_format_language', 'en-US' );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'theme_currency_sign', $theme_currency_sign );
	update_option( 'theme_currency_position', $theme_currency_position );
	update_option( 'theme_decimals', $theme_decimals );
	update_option( 'theme_dec_point', $theme_dec_point );
	update_option( 'theme_thousands_sep', $theme_thousands_sep );
	update_option( 'theme_no_price_text', $theme_no_price_text );
	update_option( 'ere_price_number_format_language', $ere_price_number_format_language );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">

    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label
                            for="theme_currency_sign"><?php esc_html_e( 'Currency Sign', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <input name="theme_currency_sign" type="text" id="theme_currency_sign"
                           value="<?php echo esc_attr( $theme_currency_sign ); ?>" class="regular-text code">
                    <p class="description"><?php esc_html_e( 'Provide currency sign. For Example: $', 'easy-real-estate' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e( 'Position of Currency Sign', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Position of Currency Sign', 'easy-real-estate' ); ?></span>
                        </legend>
                        <label>
                            <input type="radio" name="theme_currency_position"
                                   value="before" <?php checked( $theme_currency_position, 'before' ) ?>>
                            <span><?php esc_html_e( 'Before the numbers', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="theme_currency_position"
                                   value="after" <?php checked( $theme_currency_position, 'after' ) ?>>
                            <span><?php esc_html_e( 'After the numbers', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_decimals"><?php esc_html_e( 'Number of Decimals Points', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <select name="theme_decimals" id="theme_decimals">
                        <option value="0"<?php selected( $theme_decimals, '0' ); ?>><?php esc_html_e( '0', 'easy-real-estate' ); ?></option>
                        <option value="1"<?php selected( $theme_decimals, '1' ); ?>><?php esc_html_e( '1', 'easy-real-estate' ); ?></option>
                        <option value="2"<?php selected( $theme_decimals, '2' ); ?>><?php esc_html_e( '2', 'easy-real-estate' ); ?></option>
                        <option value="3"<?php selected( $theme_decimals, '3' ); ?>><?php esc_html_e( '3', 'easy-real-estate' ); ?></option>
                        <option value="4"<?php selected( $theme_decimals, '4' ); ?>><?php esc_html_e( '4', 'easy-real-estate' ); ?></option>
                        <option value="5"<?php selected( $theme_decimals, '5' ); ?>><?php esc_html_e( '5', 'easy-real-estate' ); ?></option>
                        <option value="6"<?php selected( $theme_decimals, '6' ); ?>><?php esc_html_e( '6', 'easy-real-estate' ); ?></option>
                        <option value="7"<?php selected( $theme_decimals, '7' ); ?>><?php esc_html_e( '7', 'easy-real-estate' ); ?></option>
                        <option value="8"<?php selected( $theme_decimals, '8' ); ?>><?php esc_html_e( '8', 'easy-real-estate' ); ?></option>
                        <option value="9"<?php selected( $theme_decimals, '9' ); ?>><?php esc_html_e( '9', 'easy-real-estate' ); ?></option>
                        <option value="10"<?php selected( $theme_decimals, '10' ); ?>><?php esc_html_e( '10', 'easy-real-estate' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_dec_point"><?php esc_html_e( 'Decimal Point Separator', 'easy-real-estate' ); ?></label>
                </th>
                <td><input name="theme_dec_point" type="text" id="theme_dec_point"
                           value="<?php echo esc_attr( $theme_dec_point ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_thousands_sep"><?php esc_html_e( 'Thousands Separator', 'easy-real-estate' ); ?></label>
                </th>
                <td><input name="theme_thousands_sep" type="text" id="theme_thousands_sep"
                           value="<?php echo esc_attr( $theme_thousands_sep ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_no_price_text"><?php esc_html_e( 'Empty Price Text', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <input name="theme_no_price_text" type="text" id="theme_no_price_text"
                           value="<?php echo esc_attr( $theme_no_price_text ); ?>" class="regular-text code">
                    <p class="description"><?php esc_html_e( 'Text to display when no price is provided.', 'easy-real-estate' ); ?></p>
                </td>
            </tr>
			<?php
			// List of language tags according to RFC 5646.
			// See <http://tools.ietf.org/html/rfc5646> for info on how to parse these language tags.
			$RFC5646_language_tags = array(
				'ar-AE'      => 'Arabic (U.A.E.)',
				'ar-BH'      => 'Arabic (Bahrain)',
				'ar-DZ'      => 'Arabic (Algeria)',
				'ar-EG'      => 'Arabic (Egypt)',
				'ar-IQ'      => 'Arabic (Iraq)',
				'ar-JO'      => 'Arabic (Jordan)',
				'ar-KW'      => 'Arabic (Kuwait)',
				'ar-LB'      => 'Arabic (Lebanon)',
				'ar-LY'      => 'Arabic (Libya)',
				'ar-MA'      => 'Arabic (Morocco)',
				'ar-OM'      => 'Arabic (Oman)',
				'ar-QA'      => 'Arabic (Qatar)',
				'ar-SA'      => 'Arabic (Saudi Arabia)',
				'ar-SY'      => 'Arabic (Syria)',
				'ar-TN'      => 'Arabic (Tunisia)',
				'ar-YE'      => 'Arabic (Yemen)',
				'af-ZA'      => 'Afrikaans (South Africa)',
				'az-AZ'      => 'Azeri (Latin) (Azerbaijan)',
				'az-Cyrl-AZ' => 'Azeri (Cyrillic) (Azerbaijan)',
				'be-BY'      => 'Belarusian (Belarus)',
				'bg-BG'      => 'Bulgarian (Bulgaria)',
				'bs-BA'      => 'Bosnian (Bosnia and Herzegovina)',
				'ca-ES'      => 'Catalan (Spain)',
				'cs-CZ'      => 'Czech (Czech Republic)',
				'cy-GB'      => 'Welsh (United Kingdom)',
				'da-DK'      => 'Danish (Denmark)',
				'dv-MV'      => 'Divehi (Maldives)',
				'en-US'      => 'English (United States)',
				'en-AU'      => 'English (Australia)',
				'en-BZ'      => 'English (Belize)',
				'en-CA'      => 'English (Canada)',
				'en-CB'      => 'English (Caribbean)',
				'en-GB'      => 'English (United Kingdom)',
				'en-IE'      => 'English (Ireland)',
				'en-JM'      => 'English (Jamaica)',
				'en-NZ'      => 'English (New Zealand)',
				'en-PH'      => 'English (Republic of the Philippines)',
				'en-TT'      => 'English (Trinidad and Tobago)',
				'en-ZA'      => 'English (South Africa)',
				'en-ZW'      => 'English (Zimbabwe)',
				'de-AT'      => 'German (Austria)',
				'de-CH'      => 'German (Switzerland)',
				'de-DE'      => 'German (Germany)',
				'de-LI'      => 'German (Liechtenstein)',
				'de-LU'      => 'German (Luxembourg)',
				'el-GR'      => 'Greek (Greece)',
				'es-AR'      => 'Spanish (Argentina)',
				'es-BO'      => 'Spanish (Bolivia)',
				'es-CL'      => 'Spanish (Chile)',
				'es-CO'      => 'Spanish (Colombia)',
				'es-CR'      => 'Spanish (Costa Rica)',
				'es-DO'      => 'Spanish (Dominican Republic)',
				'es-EC'      => 'Spanish (Ecuador)',
				'es-ES'      => 'Spanish (Spain)',
				'es-GT'      => 'Spanish (Guatemala)',
				'es-HN'      => 'Spanish (Honduras)',
				'es-MX'      => 'Spanish (Mexico)',
				'es-NI'      => 'Spanish (Nicaragua)',
				'es-PA'      => 'Spanish (Panama)',
				'es-PE'      => 'Spanish (Peru)',
				'es-PR'      => 'Spanish (Puerto Rico)',
				'es-PY'      => 'Spanish (Paraguay)',
				'es-SV'      => 'Spanish (El Salvador)',
				'es-UY'      => 'Spanish (Uruguay)',
				'es-VE'      => 'Spanish (Venezuela)',
				'et-EE'      => 'Estonian (Estonia)',
				'eu-ES'      => 'Basque (Spain)',
				'fa-IR'      => 'Farsi (Iran)',
				'fi-FI'      => 'Finnish (Finland)',
				'fo-FO'      => 'Faroese (Faroe Islands)',
				'fr-BE'      => 'French (Belgium)',
				'fr-CA'      => 'French (Canada)',
				'fr-CH'      => 'French (Switzerland)',
				'fr-FR'      => 'French (France)',
				'fr-LU'      => 'French (Luxembourg)',
				'fr-MC'      => 'French (Principality of Monaco)',
				'gl-ES'      => 'Galician (Spain)',
				'gu-IN'      => 'Gujarati (India)',
				'he-IL'      => 'Hebrew (Israel)',
				'hi-IN'      => 'Hindi (India)',
				'hr-BA'      => 'Croatian (Bosnia and Herzegovina)',
				'hr-HR'      => 'Croatian (Croatia)',
				'hu-HU'      => 'Hungarian (Hungary)',
				'hy-AM'      => 'Armenian (Armenia)',
				'id-ID'      => 'Indonesian (Indonesia)',
				'is-IS'      => 'Icelandic (Iceland)',
				'it-CH'      => 'Italian (Switzerland)',
				'it-IT'      => 'Italian (Italy)',
				'ja-JP'      => 'Japanese (Japan)',
				'ka-GE'      => 'Georgian (Georgia)',
				'kk-KZ'      => 'Kazakh (Kazakhstan)',
				'kn-IN'      => 'Kannada (India)',
				'ko-KR'      => 'Korean (Korea)',
				'kok-IN'     => 'Konkani (India)',
				'ky-KG'      => 'Kyrgyz (Kyrgyzstan)',
				'lt-LT'      => 'Lithuanian (Lithuania)',
				'lv-LV'      => 'Latvian (Latvia)',
				'mi-NZ'      => 'Maori (New Zealand)',
				'mk-MK'      => 'FYRO Macedonian (Former Yugoslav Republic of Macedonia)',
				'mn-MN'      => 'Mongolian (Mongolia)',
				'mr-IN'      => 'Marathi (India)',
				'ms-BN'      => 'Malay (Brunei Darussalam)',
				'ms-MY'      => 'Malay (Malaysia)',
				'mt-MT'      => 'Maltese (Malta)',
				'nb-NO'      => 'Norwegian (Bokm?l) (Norway)',
				'nl-BE'      => 'Dutch (Belgium)',
				'nl-NL'      => 'Dutch (Netherlands)',
				'nn-NO'      => 'Norwegian (Nynorsk) (Norway)',
				'ns-ZA'      => 'Northern Sotho (South Africa)',
				'pa-IN'      => 'Punjabi (India)',
				'pl-PL'      => 'Polish (Poland)',
				'ps-AR'      => 'Pashto (Afghanistan)',
				'pt-BR'      => 'Portuguese (Brazil)',
				'pt-PT'      => 'Portuguese (Portugal)',
				'qu-BO'      => 'Quechua (Bolivia)',
				'qu-EC'      => 'Quechua (Ecuador)',
				'qu-PE'      => 'Quechua (Peru)',
				'ro-RO'      => 'Romanian (Romania)',
				'ru-RU'      => 'Russian (Russia)',
				'sa-IN'      => 'Sanskrit (India)',
				'se-FI'      => 'Sami (Finland)',
				'se-NO'      => 'Sami (Norway)',
				'se-SE'      => 'Sami (Sweden)',
				'sk-SK'      => 'Slovak (Slovakia)',
				'sl-SI'      => 'Slovenian (Slovenia)',
				'sq-AL'      => 'Albanian (Albania)',
				'sr-BA'      => 'Serbian (Latin) (Bosnia and Herzegovina)',
				'sr-Cyrl-BA' => 'Serbian (Cyrillic) (Bosnia and Herzegovina)',
				'sr-SP'      => 'Serbian (Latin) (Serbia and Montenegro)',
				'sr-Cyrl-SP' => 'Serbian (Cyrillic) (Serbia and Montenegro)',
				'sv-FI'      => 'Swedish (Finland)',
				'sv-SE'      => 'Swedish (Sweden)',
				'sw-KE'      => 'Swahili (Kenya)',
				'syr-SY'     => 'Syriac (Syria)',
				'ta-IN'      => 'Tamil (India)',
				'te-IN'      => 'Telugu (India)',
				'th-TH'      => 'Thai (Thailand)',
				'tl-PH'      => 'Tagalog (Philippines)',
				'tn-ZA'      => 'Tswana (South Africa)',
				'tr-TR'      => 'Turkish (Turkey)',
				'tt-RU'      => 'Tatar (Russia)',
				'uk-UA'      => 'Ukrainian (Ukraine)',
				'ur-PK'      => 'Urdu (Islamic Republic of Pakistan)',
				'uz-UZ'      => 'Uzbek (Latin) (Uzbekistan)',
				'uz-Cyrl-UZ' => 'Uzbek (Cyrillic) (Uzbekistan)',
				'vi-VN'      => 'Vietnamese (Viet Nam)',
				'xh-ZA'      => 'Xhosa (South Africa)',
				'zh-CN'      => 'Chinese (S)',
				'zh-HK'      => 'Chinese (Hong Kong)',
				'zh-MO'      => 'Chinese (Macau)',
				'zh-SG'      => 'Chinese (Singapore)',
				'zh-TW'      => 'Chinese (T)',
				'zu-ZA'      => 'Zulu (South Africa)'
			);

			if ( ! empty( $RFC5646_language_tags ) ) :
				// Holds the HTML markup.
				$structure = array();

				// sort the array in ascending order, according to the value.
				asort( $RFC5646_language_tags );

				// List RFC5646 languages tags.
				foreach ( $RFC5646_language_tags as $tag => $language ) {
					$structure[] = sprintf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $tag ),
						selected( $ere_price_number_format_language, $tag, false ),
						esc_html( $language )
					);
				}

				$output = '<select name="ere_price_number_format_language" id="ere_price_number_format_language">';
				$output .= implode( "\n", $structure );
				$output .= '</select>';
				?>
                <tr>
                    <th scope="row">
                        <label for="ere_price_number_format_language"><?php esc_html_e( 'Price Preview Number Format Language', 'easy-real-estate' ); ?></label>
                    </th>
                    <td>
						<?php echo $output; ?>
                        <p class="description"><?php esc_html_e( 'Change the property metabox price fields number format preview as per selected language.', 'easy-real-estate' ); ?></p>
                    </td>
                </tr>
			<?php endif; ?>
            </tbody>
        </table>
        <div class="submit">
			<?php wp_nonce_field( 'inspiry_ere_settings' ); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary"
                   value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
            <p><?php esc_html_e( 'Note: If you have enabled RealHomes Currency Switcher then default format of selected base currency will override above settings.', 'easy-real-estate' ); ?></p>
        </div>
    </form>
</div>