<?php
if ( ! function_exists( 'rh_home_page_meta_boxes' ) ) {
	/**
	 * Homepage related information and settings
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function rh_home_page_meta_boxes( $meta_boxes ) {

		// check if Easy Real Estate plugin's latest code is available
		if( ! class_exists('ERE_Data') ) {
			return;
		}

		$design_variation = INSPIRY_DESIGN_VARIATION;

		/**
		 * Options Variations Handling
		 */
		if ( 'classic' == $design_variation ) {

			$theme_show_home_properties_label = esc_html__( 'Show or Hide Slogan + Properties on Homepage?', 'framework' );

			$theme_homepage_module_options = array(
				'none'                   => esc_html__( 'None', 'framework' ),
				'properties-slider'      => esc_html__( 'Slider Based on Properties Custom Post Type', 'framework' ),
				'search-form-over-image' => esc_html__( 'Search Form Over an Image / Video', 'framework' ),
				'properties-map'         => esc_html__( 'Map with Properties Markers', 'framework' ),
				'simple-banner'          => esc_html__( 'Image Based Banner', 'framework' ),
				'revolution-slider'      => esc_html__( 'Slider Based on Revolution Slider Plugin', 'framework' ),
				'slides-slider'          => esc_html__( 'Slider Based on Slides Custom Post Type', 'framework' ),
				'contact-form-slider'    => esc_html__( 'Contact Form Over Slider', 'framework' ),

			);

			$feature_keys = array(
				'status'      => 'inspiry_show_features_section',
				'title'       => 'inspiry_features_section_title',
				'description' => 'inspiry_features_section_desc',
			);

			$news_keys = array(
				'status'      => 'theme_show_news_posts',
				'title'       => 'theme_news_posts_title',
				'description' => 'theme_news_posts_text',
			);

			$home_sections['id']      = 'inspiry_home_sections_order';
			$home_sections['default'] = 'home-properties,features-section,featured-properties,blog-posts';
			$home_sections['options'] = array(
				'home-properties'     => esc_html__( 'Home Properties', 'framework' ),
				'features-section'    => esc_html__( 'Features Section', 'framework' ),
				'featured-properties' => esc_html__( 'Featured Properties', 'framework' ),
				'blog-posts'          => esc_html__( 'News/Blog Posts', 'framework' )
			);

		} else {

			$theme_show_home_properties_label = esc_html__( 'Properties on Homepage', 'framework' );

			$theme_homepage_module_options = array(
				'none'                   => esc_html__( 'None', 'framework' ),
				'properties-slider'      => esc_html__( 'Slider Based on Properties Custom Post Type', 'framework' ),
				'search-form-over-image' => esc_html__( 'Search Form Over an Image / Video', 'framework' ),
				'properties-map'         => esc_html__( 'Map with Properties Markers', 'framework' ),
				'simple-banner'          => esc_html__( 'Image Based Banner', 'framework' ),
				'revolution-slider'      => esc_html__( 'Slider Based on Revolution Slider Plugin.', 'framework' ),
				'slides-slider'          => esc_html__( 'Slider Based on Slides Custom Post Type', 'framework' ),
				'contact-form-slider'    => esc_html__( 'Contact Form Over Slider', 'framework' ),
			);

			$feature_keys = array(
				'status'      => 'inspiry_show_home_features',
				'title'       => 'inspiry_home_features_title',
				'description' => 'inspiry_home_features_desc',
			);

			$news_keys = array(
				'status'      => 'inspiry_show_home_news_modern',
				'title'       => 'inspiry_home_news_title',
				'description' => 'inspiry_home_news_desc',
			);

			$home_sections['id']      = 'inspiry_home_sections_order_mod';
			$home_sections['default'] = 'content,latest-properties,featured-properties,testimonial,cta,agents,features,partners,news,cta-contact';
			$home_sections['options'] = array(
				'content'             => esc_html__( 'Content Area', 'framework' ),
				'latest-properties'   => esc_html__( 'Latest Properties', 'framework' ),
				'featured-properties' => esc_html__( 'Featured Properties', 'framework' ),
				'testimonial'         => esc_html__( 'Testimonials', 'framework' ),
				'cta'                 => esc_html__( 'Call to Action', 'framework' ),
				'agents'              => esc_html__( 'Agents', 'framework' ),
				'features'            => esc_html__( 'Features', 'framework' ),
				'partners'            => esc_html__( 'Partners', 'framework' ),
				'news'                => esc_html__( 'News & Updates', 'framework' ),
				'cta-contact'         => esc_html__( 'Call to Action -- Contact', 'framework' ),
			);
		}

		$fields = array(
			/**
			 * Sections Manager
			 */
			array(
				'name'    => esc_html__( 'Order Settings', 'framework' ),
				'id'      => 'inspiry_home_sections_order_default',
				'type'    => 'radio',
				'std'     => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'framework' ),
					'custom'  => esc_html__( 'Custom', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'sections-manager',
			),
			array(
				'name'    => esc_html__( 'Sections Order', 'framework' ),
				'desc'    => esc_html__( 'You can reorder the homepage sections here.', 'framework' ),
				'id'      => $home_sections['id'],
				'std'     => $home_sections['default'],
				'type'    => 'sorter',
				'options' => $home_sections['options'],
				'columns' => 6,
				'tab'     => 'sections-manager',
			),

			/**
			 * Slider Area
			 */
			array(
				'name'    => esc_html__( 'What to Display Below Header on Home Page ?', 'framework' ),
				'id'      => 'theme_homepage_module',
				'type'    => 'radio',
				'std'     => 'simple-banner',
				'options' => $theme_homepage_module_options,
				'columns' => 12,
				'tab'     => 'slider-area',
			),

			array(
				'name'     => esc_html__( 'Maximum Number of Slides to Display in Slider Based on Properties', 'framework' ),
				'id'       => 'theme_number_of_slides',
				'type'     => 'select',
				'std'      => '3',
				'options'  => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
				),
				'multiple' => false,
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'properties-slider' )
			),
			array(
				'name'     => esc_html__( 'Maximum Number of Slides to Display in Slider Based on Slides Custom Post Type', 'framework' ),
				'id'       => 'theme_number_custom_slides',
				'type'     => 'select',
				'std'      => '3',
				'options'  => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
				),
				'multiple' => false,
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'slides-slider' )
			),
			array(
				'name'     => esc_html__( 'Button Text', 'framework' ),
				'id'       => 'theme_custom_slides_button_text',
				'type'     => 'text',
				'std'      => esc_html__( 'Read More', 'framework' ),
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'slides-slider' )
			),

			array(
				'name'     => esc_html__( 'Maximum Number of Slides to Display', 'framework' ),
				'id'       => 'theme_number_of_slides_cfos',
				'type'     => 'select',
				'std'      => '4',
				'options'  => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
				),
				'multiple' => false,
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name'     => esc_html__( 'Select Post Type', 'framework' ),
				'id'       => 'theme_cpt_cfoss',
				'type'     => 'select',
				'std'      => 'property',
				'options' => array(
					'property' => esc_html__( 'Properties', 'framework' ),
					'slide'    => esc_html__( 'Slides', 'framework' ),
				),
				'multiple' => false,
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name'    => esc_html__( 'Revolution Slider Alias', 'framework' ),
				'desc'    => esc_html__( '*If you want to display Revolution Slider instead of Slider with Post Type (Properties or Slides), then provide its alias here. ', 'framework' ),
				'id'      => 'theme_cfos_rev_alias',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Form Heading', 'framework' ),
				'desc'      => esc_html__( "i.e 'Let Us Call You!'", 'framework' ),
				'id'       => 'theme_contact_cta_heading_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'std'      => esc_html__( "Let Us Call You!", 'framework' ),
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),


			array(
				'name' => esc_html__( 'Form Description', 'framework' ),
				'desc'      => esc_html__( "i.e 'To help you choose your property' ", 'framework' ),
				'id'       => 'theme_contact_cta_description_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'std'      => esc_html__( "To help you choose your property", 'framework' ),
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),


			array(
				'name' => esc_html__( 'Name Field Label', 'framework' ),
				'desc'     => esc_html__( 'Label will be hidden if GDPR or rCaptcha are activated', 'framework' ),
				'id'       => 'theme_contact_name_label_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Name Field Placeholder', 'framework' ),
				'id'       => 'theme_contact_name_placeholder_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Email Field Label', 'framework' ),
				'desc'     => esc_html__( 'Label will be hidden if GDPR or rCaptcha are activated', 'framework' ),
				'id'       => 'theme_contact_email_label_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Email Field Placeholder', 'framework' ),
				'id'       => 'theme_contact_email_placeholder_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Number Field Label', 'framework' ),
				'desc'     => esc_html__( 'Label will be hidden if GDPR or rCaptcha are activated', 'framework' ),
				'id'       => 'theme_contact_number_label_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Number Field Placeholder', 'framework' ),
				'id'       => 'theme_contact_number_placeholder_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Message Field Label', 'framework' ),
				'id'       => 'theme_contact_message_label_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Message Field Placeholder', 'framework' ),
				'id'       => 'theme_contact_message_placeholder_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name' => esc_html__( 'Contact Form Email', 'framework' ),
				'desc' => esc_html__( 'Provide email address that will get messages from contact form.', 'framework' ),
				'id'       => 'theme_contact_form_email_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),


			array(
				'name'     => esc_html__( 'Contact Form CC Email', 'framework' ),
				'desc'     => esc_html__( 'You can add multiple comma separated cc email addresses, to get a carbon copy of contact form message.', 'framework' ),
				'id'       => 'theme_contact_form_email_cc_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),


			array(
				'name'     => esc_html__( 'Contact Form BCC Email', 'framework' ),
				'desc'     => esc_html__( 'You can add multiple comma separated bcc email addresses, to get a blind carbon copy of contact form message.', 'framework' ),
				'id'       => 'theme_contact_form_email_bcc_cfos',
				'type'     => 'text',
				'columns'  => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

			array(
				'name'    => esc_html__( 'Select Page For Redirection', 'framework' ),
				'desc'    => esc_html__( 'User will be redirected to the selected page after successful submission of the form.', 'framework' ),
				'id'      => "inspiry_cfos_success_redirect_page",
				'type'    => 'select',
				'options' => RH_Data::get_pages_array(),
				'columns' => 6,
				'tab'      => 'slider-area',
				'visible'  => array( 'theme_homepage_module', '=', 'contact-form-slider' )
			),

		);

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Google Map Type', 'framework' ),
					'desc'    => esc_html__( 'Choose Google Map Type', 'framework' ),
					'id'      => 'inspiry_home_map_type',
					'type'    => 'select',
					'std'     => 'roadmap',
					'options' => array(
						'roadmap'   => esc_html__( 'RoadMap', 'framework' ),
						'satellite' => esc_html__( 'Satellite', 'framework' ),
						'hybrid'    => esc_html__( 'Hybrid', 'framework' ),
						'terrain'   => esc_html__( 'Terrain', 'framework' ),
					),
					'columns' => 6,
					'tab'     => 'slider-area',
					'visible' => array( 'theme_homepage_module', '=', 'properties-map' )
				),
			) );
		}

		$fields = array_merge( $fields, array(

			array(
				'name'             => esc_html__( 'Banner Image', 'framework' ),
				'id'               => 'REAL_HOMES_home_banner_image',
				'desc'             => esc_html__( 'Please upload the Banner Image. Otherwise the default banner image from theme options will be displayed.', 'framework' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'columns'          => 12,
				'tab'              => 'slider-area',
				'visible'          => array( 'theme_homepage_module', '=', 'simple-banner' )
			),
			array(
				'name'    => esc_html__( 'Revolution Slider Alias', 'framework' ),
				'desc'    => esc_html__( 'If you want to display Revolution Slider then provide its alias here.', 'framework' ),
				'id'      => 'theme_rev_alias',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'revolution-slider' )
			),
			array(
				'name'             => esc_html__( 'Background Image for Homepage Search Form', 'framework' ),
				'desc'             => esc_html__( 'Recommended image size is 1970px by 850px', 'framework' ),
				'id'               => 'inspiry_home_search_bg_img',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'columns'          => 12,
				'tab'              => 'slider-area',
				'visible'          => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
				array(
					'name'    => esc_html__( 'Background Video for Homepage Search Form ( Revolution Slider Alias )', 'framework' ),
					'desc'    => esc_html__( 'Video will be placed over the background image of search form', 'framework' ),
					'id'      => 'inspiry_home_search_bg_video',
					'type'    => 'text',
					'columns' => 12,
					'tab'     => 'slider-area',
					'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
				),
			array(
				'name'    => esc_html__( 'Background Image Overlay Opacity (between 0 and 1)', 'framework' ),
				'id'      => 'inspiry_SFOI_overlay_opacity',
				'std'     => 0.3,
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
			array(
				'name'    => esc_html__( 'Background Image Overlay Color', 'framework' ),
				'id'      => 'inspiry_SFOI_overlay_color',
				'std'     => '#000000',
				'type'    => 'color',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
			array(
				'name'    => esc_html__( 'Title for Search Form Over Image', 'framework' ),
				'id'      => 'inspiry_SFOI_title',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
			array(
				'name'    => esc_html__( 'Title Color', 'framework' ),
				'id'      => 'inspiry_SFOI_title_color',
				'std'     => '#ffffff',
				'type'    => 'color',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
			array(
				'name'    => esc_html__( 'Description for Search Form Over Image', 'framework' ),
				'id'      => 'inspiry_SFOI_description',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),
			array(
				'name'    => esc_html__( 'Description Color', 'framework' ),
				'id'      => 'inspiry_SFOI_description_color',
				'std'     => '#ffffff',
				'type'    => 'color',
				'columns' => 6,
				'tab'     => 'slider-area',
				'visible' => array( 'theme_homepage_module', '=', 'search-form-over-image' )
			),

			/**
			 * Search Form
			 */
			array(
				'name'    => esc_html__( 'Properties Search Form on Homepage', 'framework' ),
				'desc'    => esc_html__( 'You can configure properties search form using related section in Customizer settings.', 'framework' ),
				'id'      => 'theme_show_home_search',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'search-form',
			)

		)


		);

		if ( 'modern' == $design_variation ) {


			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Enable Advance Search Label', 'framework' ),
					'id'      => 'inspiry_enable_search_label_image',
					'type'    => 'radio',
					'std'     => 'true',
					'options' => array(
						'true'  => esc_html__( 'Show', 'framework' ),
						'false' => esc_html__( 'Hide', 'framework' ),
					),
					'columns' => 12,
					'tab'     => 'search-form',
					'visible' => array( 'theme_show_home_search', 'true' )
				),
				array(
					'name'    => esc_html__( 'Advance Search Label Text (optional)', 'framework' ),
					'desc'    => esc_html__( 'This text will guide to expend Advance Search form.', 'framework' ),
					'id'      => 'inspiry_search_label_text',
					'type'    => 'text',
					'std'     => esc_html__( 'Advance Search', 'framework' ),
					'columns' => 6,
					'tab'     => 'search-form',
					'visible' => array( 'inspiry_enable_search_label_image', 'true' )
				),
			) );
		}

		if ( 'classic' == $design_variation ) {
			$fields = array_merge( $fields, array(
				/**
				 * Home Properties
				 */
				array(
					'name'    => esc_html__( 'Slogan Title', 'framework' ),
					'id'      => 'theme_slogan_title',
					'type'    => 'text',
					'columns' => 12,
					'tab'     => 'home-properties',
				),
				array(
					'name'    => esc_html__( 'Description Text Below Slogan', 'framework' ),
					'id'      => 'theme_slogan_text',
					'type'    => 'textarea',
					'columns' => 12,
					'tab'     => 'home-properties',
				),
				array(
					'type' => 'divider',
					'tab'  => 'home-properties'
				),
			) );
		}

		$fields = array_merge( $fields, array(

			/**
			 * Home Properties
			 */
			array(
				'name'    => $theme_show_home_properties_label,
				'id'      => 'theme_show_home_properties',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'home-properties',
			),
		) );

		if ( 'modern' == $design_variation ) {

			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Text Over Title', 'framework' ),
					'id'      => 'inspiry_home_properties_sub_title',
					'type'    => 'text',
					'std'     => esc_html__( 'Latest', 'framework' ),
					'columns' => 6,
					'tab'     => 'home-properties',
					'visible' => array( 'theme_show_home_properties', 'true' )
				),
				array(
					'name'    => esc_html__( 'Section Title', 'framework' ),
					'id'      => 'inspiry_home_properties_title',
					'type'    => 'text',
					'std'     => esc_html__( 'Properties', 'framework' ),
					'columns' => 6,
					'tab'     => 'home-properties',
					'visible' => array( 'theme_show_home_properties', 'true' )
				),
				array(
					'name'    => esc_html__( 'Section Description', 'framework' ),
					'id'      => 'inspiry_home_properties_desc',
					'type'    => 'textarea',
					'std'     => esc_html__( 'Some amazing features of RealHomes theme.', 'framework' ),
					'columns' => 12,
					'tab'     => 'home-properties',
					'visible' => array( 'theme_show_home_properties', 'true' )
				),
			) );

		}

		$fields = array_merge( $fields, array(
			array(
				'name'    => esc_html__( 'Select the kind of properties you want to display on Homepage ?', 'framework' ),
				'id'      => 'theme_home_properties',
				'type'    => 'radio',
				'std'     => 'recent',
				'options' => array(
					'recent'             => esc_html__( 'Recent Properties', 'framework' ),
					'featured'           => esc_html__( 'Featured Properties', 'framework' ),
					'based-on-selection' => esc_html__( 'Properties Based on Selected Locations, Statuses and Types from Below', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_show_home_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Select Property Types', 'framework' ),
				'id'      => 'theme_types_for_homepage',
				'type'    => 'checkbox_list',
				'options' => ERE_Data::get_types_slug_name(),
				'columns' => 4,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_home_properties', 'based-on-selection' )
			),
			array(
				'name'    => esc_html__( 'Select Property Statuses', 'framework' ),
				'id'      => 'theme_statuses_for_homepage',
				'type'    => 'checkbox_list',
				'options' => ERE_Data::get_statuses_slug_name(),
				'columns' => 4,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_home_properties', 'based-on-selection' )
			),
			array(
				'name'    => esc_html__( 'Select Property Locations', 'framework' ),
				'id'      => 'theme_cities_for_homepage',
				'type'    => 'checkbox_list',
				'options' => ERE_Data::get_locations_slug_name(true ),
				'columns' => 4,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_home_properties', 'based-on-selection' )
			),
			array(
				'name'    => esc_html__( 'Sort Properties By', 'framework' ),
				'id'      => 'theme_sorty_by',
				'type'    => 'radio',
				'std'     => 'recent',
				'options' => array(
					'recent'      => esc_html__( 'Time - Recent First', 'framework' ),
					'low-to-high' => esc_html__( 'Price - Low to High', 'framework' ),
					'high-to-low' => esc_html__( 'Price - High to Low', 'framework' ),
					'random'      => esc_html__( 'Random', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_show_home_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Number of Properties on Each Page', 'framework' ),
				'id'      => 'theme_properties_on_home',
				'type'    => 'select',
				'std'     => '4',
				'options' => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
					'11' => 11,
					'12' => 12,
					'13' => 13,
					'14' => 14,
					'15' => 15,
					'16' => 16,
					'17' => 17,
					'18' => 18,
					'19' => 19,
					'20' => 20,
				),
				'columns' => 6,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_show_home_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Show Sticky Properties First', 'framework' ),
				'id'      => 'inspiry_home_skip_sticky',
				'type'    => 'checkbox',
				'desc'    => esc_html__( 'No', 'framework' ),
				'std'     => 0,
				'columns' => 12,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_show_home_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'AJAX Pagination', 'framework' ),
				'id'      => 'theme_ajax_pagination_home',
				'type'    => 'radio',
				'std'     => 'true',
				'options' => array(
					'true'  => 'Enable',
					'false' => 'Disable',
				),
				'columns' => 12,
				'tab'     => 'home-properties',
				'visible' => array( 'theme_show_home_properties', 'true' )
			),

			/**
			 * Features Section
			 */
			array(
				'name'    => esc_html__( 'Features Section on Homepage', 'framework' ),
				'id'      => $feature_keys['status'],
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'features-section',
			),
		) );

		if ( 'classic' == $design_variation ) {

			$fields = array_merge( $fields, array(
				array(
					'id'               => 'inspiry_features_background_image',
					'name'             => esc_html__( 'Section Background Image', 'framework' ),
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'mime_type'        => '',
					'columns'          => 12,
					'tab'              => 'features-section',
					'visible'          => array( $feature_keys['status'], 'true' )
				),
			) );

		} else {
			$fields = array_merge( $fields, array(
				array(
					'id'      => 'inspiry_home_features_sub_title',
					'name'    => esc_html__( 'Text Over Title', 'framework' ),
					'type'    => 'text',
					'columns' => 6,
					'tab'     => 'features-section',
					'visible' => array( $feature_keys['status'], 'true' )
				),
			) );
		}

		$fields = array_merge( $fields, array(
			array(
				'name'    => esc_html__( 'Section Title', 'framework' ),
				'id'      => $feature_keys['title'],
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'features-section',
				'visible' => array( $feature_keys['status'], 'true' )

			),
			array(
				'name'    => esc_html__( 'Description Text', 'framework' ),
				'id'      => $feature_keys['description'],
				'type'    => 'textarea',
				'columns' => 12,
				'tab'     => 'features-section',
				'visible' => array( $feature_keys['status'], 'true' )
			),
			array(
				'id'      => 'inspiry_features',
				'type'    => 'group',
				'columns' => 12,
				'clone'   => true,
				'tab'     => 'features-section',
				'visible' => array( $feature_keys['status'], 'true' ),
				'fields'  => array(
					array(
						'name'    => esc_html__( 'Feature Name', 'framework' ),
						'id'      => 'inspiry_feature_name',
						'desc'    => esc_html__( 'Example: Perfect Backend', 'framework' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'name'    => esc_html__( 'Feature URL', 'framework' ),
						'id'      => 'inspiry_feature_link',
						'desc'    => esc_html__( 'Example: https://themeforest.net/user/inspirythemes/portfolio', 'framework' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'name'             => esc_html__( 'Feature Icon', 'framework' ),
						'id'               => 'inspiry_feature_icon',
						'desc'             => esc_html__( 'Icon should have minimum width of 150px and minimum height of 150px.', 'framework' ),
						'type'             => 'image_advanced',
						'max_file_uploads' => 1,
						'columns'          => 6,
					),
					array(
						'name'    => esc_html__( 'Feature Description', 'framework' ),
						'id'      => 'inspiry_feature_desc',
						'type'    => 'textarea',
						'rows'    => 7,
						'cols'    => 60,
						'columns' => 6,
					),
				),
			),

			/**
			 * Featured Properties
			 */
			array(
				'name'    => esc_html__( 'Featured Properties on Homepage', 'framework' ),
				'id'      => 'theme_show_featured_properties',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'featured-properties',
			),
		) );

		if ( 'modern' == $design_variation ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Text Over Title', 'framework' ),
					'id'      => 'inspiry_featured_prop_sub_title',
					'type'    => 'text',
					'columns' => 6,
					'tab'     => 'featured-properties',
					'visible' => array( 'theme_show_featured_properties', 'true' )
				),
			) );
		}

		$fields = array_merge( $fields, array(
			array(
				'name'    => esc_html__( 'Section Title', 'framework' ),
				'id'      => 'theme_featured_prop_title',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'featured-properties',
				'visible' => array( 'theme_show_featured_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Description', 'framework' ),
				'id'      => 'theme_featured_prop_text',
				'type'    => 'textarea',
				'columns' => 12,
				'tab'     => 'featured-properties',
				'visible' => array( 'theme_show_featured_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Number of Featured Properties to Display?', 'framework' ),
				'id'      => 'realhomes_max_featured_properties',
				'type'    => 'number',
				'std'     => '6',
				'columns' => 6,
				'tab'     => 'featured-properties',
				'visible' => array( 'theme_show_featured_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Exclude or Include Featured Properties from Recent Properties on Homepage', 'framework' ),
				'id'      => 'theme_exclude_featured_properties',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Exclude', 'framework' ),
					'false' => esc_html__( 'Include', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'featured-properties',
				'visible' => array( 'theme_show_featured_properties', 'true' )
			),
			array(
				'name'    => esc_html__( 'Which statuses would you like to exclude ?', 'framework' ),
				'id'      => 'inspiry_featured_properties_exclude_status',
				'type'    => 'checkbox_list',
				'options' => ERE_Data::get_statuses_slug_name(),
				'columns' => 12,
				'tab'     => 'featured-properties',
				'visible' => array( 'theme_show_featured_properties', 'true' )
			),

		) );

		if ( 'classic' == $design_variation ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Select Featured Properties Variation', 'framework' ),
					'id'      => 'inspiry_featured_properties_variation',
					'type'    => 'radio',
					'std'     => 'default',
					'options' => array(
						'default'            => 'Default',
						'one_property_slide' => 'Slide with single property',
					),
					'columns' => 12,
					'tab'     => 'featured-properties',
				),
			) );
		}

		$fields = array_merge( $fields, array(

			/**
			 * News Section
			 */
			array(
				'name'    => esc_html__( 'News Posts on Homepage', 'framework' ),
				'id'      => $news_keys['status'],
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'blog-posts',
			),
		) );

		if ( 'modern' == $design_variation ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Text Over Title', 'framework' ),
					'id'      => 'inspiry_home_news_sub_title',
					'type'    => 'text',
					'std'     => esc_html__( 'Recent', 'framework' ),
					'columns' => 6,
					'tab'     => 'blog-posts',
					'visible' => array( 'theme_show_news_posts', 'true' )
				),
			) );
		}

		$fields = array_merge( $fields, array(
			array(
				'name'    => esc_html__( 'Title', 'framework' ),
				'id'      => $news_keys['title'],
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'blog-posts',
				'visible' => array( $news_keys['status'], 'true' )
			),
			array(
				'name'    => esc_html__( 'Description Text', 'framework' ),
				'id'      => $news_keys['description'],
				'type'    => 'textarea',
				'columns' => 12,
				'tab'     => 'blog-posts',
				'visible' => array( $news_keys['status'], 'true' )
			),


			/**
			 * Content Area - Modern Design Only
			 */

			// Content Area
			array(
				'name'    => esc_html__( 'Content Area on Homepage', 'framework' ),
				'id'      => 'theme_show_home_contents',
				'desc'    => esc_html__( 'For the contents that you may have added to the homepage using above content area underneath homepage title.', 'framework' ),
				'type'    => 'radio',
				'std'     => 'true',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'content-area',
			),

			// Testimonial
			array(
				'name'    => esc_html__( 'Testimonial on Homepage', 'framework' ),
				'id'      => 'inspiry_show_testimonial',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'testimonial',
			),
			array(
				'name'    => esc_html__( 'Name', 'framework' ),
				'id'      => 'inspiry_testimonial_name',
				'type'    => 'text',
				'std'     => esc_html__( 'giovannigr', 'framework' ),
				'columns' => 6,
				'tab'     => 'testimonial',
				'visible' => array( 'inspiry_show_testimonial', 'true' )
			),
			array(
				'name'    => esc_html__( 'URL', 'framework' ),
				'id'      => 'inspiry_testimonial_url',
				'type'    => 'text',
				'std'     => esc_html__( 'http://giovannigr.com', 'framework' ),
				'columns' => 6,
				'tab'     => 'testimonial',
				'visible' => array( 'inspiry_show_testimonial', 'true' )
			),
			array(
				'name'    => esc_html__( 'Testimonial', 'framework' ),
				'id'      => 'inspiry_testimonial_text',
				'type'    => 'textarea',
				'std'     => esc_html__( 'Best theme for Real Estate Agency fast installation and translation can be done with po-edit software. Cool & comfortable design, thanks for this amazing theme. Recommended for all real estate agency.', 'framework' ),
				'columns' => 12,
				'tab'     => 'testimonial',
				'visible' => array( 'inspiry_show_testimonial', 'true' )
			),

			// Call to Action
			array(
				'name'    => esc_html__( 'CTA on Homepage', 'framework' ),
				'id'      => 'inspiry_show_cta',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'call-to-action',
			),
			array(
				'id'               => 'inspiry_cta_background_image',
				'name'             => esc_html__( 'CTA Background', 'framework' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'columns'          => 12,
				'tab'              => 'call-to-action',
				'visible'          => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Title', 'framework' ),
				'id'      => 'inspiry_cta_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Featured', 'framework' ),
				'columns' => 6,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Description', 'framework' ),
				'id'      => 'inspiry_cta_desc',
				'type'    => 'textarea',
				'std'     => esc_html__( 'Looking to Buy a new property or Sell an existing one? RealHomes provides an easy solution!', 'framework' ),
				'columns' => 12,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button Title One', 'framework' ),
				'id'      => 'inspiry_cta_btn_one_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Submit Property', 'framework' ),
				'columns' => 6,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button URL One', 'framework' ),
				'id'      => 'inspiry_cta_btn_one_url',
				'type'    => 'text',
				'std'     => '#',
				'columns' => 6,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button Title Two', 'framework' ),
				'id'      => 'inspiry_cta_btn_two_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Browse Property', 'framework' ),
				'columns' => 6,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button URL Two', 'framework' ),
				'id'      => 'inspiry_cta_btn_two_url',
				'type'    => 'text',
				'std'     => '#',
				'columns' => 6,
				'tab'     => 'call-to-action',
				'visible' => array( 'inspiry_show_cta', 'true' )
			),

			// Agents
			array(
				'name'    => esc_html__( 'Agents on Homepage', 'framework' ),
				'id'      => 'inspiry_show_agents',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'agents',
			),
			array(
				'name'    => esc_html__( 'Text Over Title', 'framework' ),
				'id'      => 'inspiry_home_agents_sub_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Recent', 'framework' ),
				'columns' => 6,
				'tab'     => 'agents',
				'visible' => array( 'inspiry_show_agents', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Title', 'framework' ),
				'id'      => 'inspiry_home_agents_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Agents', 'framework' ),
				'columns' => 6,
				'tab'     => 'agents',
				'visible' => array( 'inspiry_show_agents', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Description', 'framework' ),
				'id'      => 'inspiry_home_agents_desc',
				'type'    => 'textarea',
				'std'     => esc_html__( 'Some amazing features of RealHomes theme.', 'framework' ),
				'columns' => 12,
				'tab'     => 'agents',
				'visible' => array( 'inspiry_show_agents', 'true' )
			),
			array(
				'name'    => esc_html__( 'Number of Agents', 'framework' ),
				'id'      => 'inspiry_agents_on_home',
				'type'    => 'select',
				'std'     => '4',
				'options' => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
					'11' => 11,
					'12' => 12,
					'13' => 13,
					'14' => 14,
					'15' => 15,
					'16' => 16,
					'17' => 17,
					'18' => 18,
					'19' => 19,
					'20' => 20,
				),
				'columns' => 6,
				'tab'     => 'agents',
				'visible' => array( 'inspiry_show_agents', 'true' )
			),

			// partners
			array(
				'name'    => esc_html__( 'Partners on Homepage', 'framework' ),
				'id'      => 'inspiry_show_home_partners',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'partners',
			),
			array(
				'name'    => esc_html__( 'Text Over Title', 'framework' ),
				'id'      => 'inspiry_home_partners_sub_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Our', 'framework' ),
				'columns' => 6,
				'tab'     => 'partners',
				'visible' => array( 'inspiry_show_home_partners', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Title', 'framework' ),
				'id'      => 'inspiry_home_partners_title',
				'type'    => 'text',
				'std'     => esc_html__( 'Partners', 'framework' ),
				'columns' => 6,
				'tab'     => 'partners',
				'visible' => array( 'inspiry_show_home_partners', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Description', 'framework' ),
				'id'      => 'inspiry_home_partners_desc',
				'type'    => 'textarea',
				'std'     => esc_html__( 'Some amazing partners of RealHomes theme', 'framework' ),
				'columns' => 12,
				'tab'     => 'partners',
				'visible' => array( 'inspiry_show_home_partners', 'true' )
			),
			array(
				'name'    => esc_html__( 'Partners Design Variation to Display', 'framework' ),
				'id'      => 'inpsiry_modern_partners_variation',
				'type'    => 'radio',
				'std'     => 'simple',
				'options' => array(
					'simple'   => esc_html__( 'Simple', 'framework' ),
					'carousel' => esc_html__( 'Carousel', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'partners',
				'visible' => array( 'inspiry_show_home_partners', 'true' )
			),
			array(
				'name'    => esc_html__( 'Number of Partners', 'framework' ),
				'id'      => 'inspiry_home_partners_to_show',
				'type'    => 'select',
				'std'     => '20',
				'options' => array(
					'1'  => 1,
					'2'  => 2,
					'3'  => 3,
					'4'  => 4,
					'5'  => 5,
					'6'  => 6,
					'7'  => 7,
					'8'  => 8,
					'9'  => 9,
					'10' => 10,
					'11' => 11,
					'12' => 12,
					'13' => 13,
					'14' => 14,
					'15' => 15,
					'16' => 16,
					'17' => 17,
					'18' => 18,
					'19' => 19,
					'20' => 20,
				),
				'columns' => 6,
				'tab'     => 'partners',
				'visible' => array(
					array(
						'inspiry_show_home_partners',
						'true'
					),
					array(
						'inpsiry_modern_partners_variation',
						'simple'
					)
				)
			),

			// Call to Action - Contact
			array(
				'name'    => esc_html__( 'CTA Contact on Homepage', 'framework' ),
				'id'      => 'inspiry_show_home_cta_contact',
				'type'    => 'radio',
				'std'     => 'false',
				'options' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' )
				),
				'columns' => 12,
				'tab'     => 'call-to-action-contact'
			),
			array(
				'name'             => esc_html__( 'CTA Background', 'framework' ),
				'id'               => 'inspiry_home_cta_contact_bg_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'columns'          => 12,
				'tab'              => 'call-to-action-contact',
				'visible'          => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Title', 'framework' ),
				'id'      => 'inspiry_home_cta_contact_title',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'Section Description', 'framework' ),
				'id'      => 'inspiry_home_cta_contact_desc',
				'type'    => 'textarea',
				'columns' => 12,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button Title One', 'framework' ),
				'id'      => 'inspiry_cta_contact_btn_one_title',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button URL One', 'framework' ),
				'id'      => 'inspiry_cta_contact_btn_one_url',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button Title Two', 'framework' ),
				'id'      => 'inspiry_cta_contact_btn_two_title',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),
			array(
				'name'    => esc_html__( 'CTA Button URL Two', 'framework' ),
				'id'      => 'inspiry_cta_contact_btn_two_url',
				'type'    => 'text',
				'columns' => 6,
				'tab'     => 'call-to-action-contact',
				'visible' => array( 'inspiry_show_home_cta_contact', 'true' )
			),

			// General
			array(
				'name'    => esc_html__( 'Sections Border Angle', 'framework' ),
				'id'      => 'inspiry_home_sections_border',
				'type'    => 'radio',
				'std'     => 'flat-border',
				'options' => array(
					'diagonal-border' => esc_html__( 'Diagonal', 'framework' ),
					'flat-border'     => esc_html__( 'Flat', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'general'
			),
		) );


		/**
		 * Tabs
		 */
		$tabs = array(
			'sections-manager' => array(
				'label' => esc_html__( 'Sections Manager', 'framework' ),
				'icon'  => 'fas fa-bars',
			),
			'slider-area'      => array(
				'label' => esc_html__( 'Slider Area', 'framework' ),
				'icon'  => 'dashicons-slides',
			),
			'search-form'      => array(
				'label' => esc_html__( 'Search Form', 'framework' ),
				'icon'  => 'fas fa-search',
			),
		);

		if ( 'modern' == $design_variation ) {
			$tabs = array_merge( $tabs, array(
				'content-area' => array(
					'label' => esc_html__( 'Content Area', 'framework' ),
					'icon'  => 'far fa-edit',
				),
			) );
		}

		$tabs = array_merge( $tabs, array(
			'home-properties'     => array(
				'label' => esc_html__( 'Properties', 'framework' ),
				'icon'  => 'dashicons-building',
			),
			'features-section'    => array(
				'label' => esc_html__( 'Features Section', 'framework' ),
				'icon'  => 'dashicons-yes',
			),
			'featured-properties' => array(
				'label' => esc_html__( 'Featured Properties', 'framework' ),
				'icon'  => 'dashicons-building',
			),

		) );

		if ( 'modern' == $design_variation ) {
			$tabs = array_merge( $tabs, array(
				'testimonial'    => array(
					'label' => esc_html__( 'Testimonial', 'framework' ),
					'icon'  => 'dashicons-admin-comments',
				),
				'call-to-action' => array(
					'label' => esc_html__( 'Call to Action', 'framework' ),
					'icon'  => 'dashicons-admin-links',
				),
				'agents'         => array(
					'label' => esc_html__( 'Agents', 'framework' ),
					'icon'  => 'fas fa-users',
				),
				'partners'       => array(
					'label' => esc_html__( 'Partners', 'framework' ),
					'icon'  => 'far fa-handshake',
				),
			) );
		}

		$tabs = array_merge( $tabs, array(
			'blog-posts' => array(
				'label' => esc_html__( 'News/Blog Posts', 'framework' ),
				'icon'  => 'dashicons-welcome-write-blog',
			),
		) );

		if ( 'modern' == $design_variation ) {
			$tabs = array_merge( $tabs, array(
				'call-to-action-contact' => array(
					'label' => esc_html__( 'Call to Action - Contact', 'framework' ),
					'icon'  => 'dashicons-admin-links',
				),
				'general'                => array(
					'label' => esc_html__( 'General', 'framework' ),
					'icon'  => 'dashicons-admin-generic',
				),
			) );
		}

		/**
		 * Homepage meta-boxes settings
		 */
		$meta_boxes[] = array(
			'id'         => 'home-page-meta-box',
			'title'      => esc_html__( 'Homepage Settings', 'framework' ),
			'post_types' => array( 'page' ),
			'show'       => array(
				'template' => array(
					'templates/home.php',
				),
			),
			'context'    => 'normal',
			'priority'   => 'low',
			'tabs'       => $tabs,
			'tab_style'  => 'left',
			'fields'     => $fields,
		);

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'rh_home_page_meta_boxes' );
}