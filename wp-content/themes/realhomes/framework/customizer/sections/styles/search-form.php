<?php

/**
 * Section:	`Search Form`
 * Panel: 	`Styles`
 *
 * @package realhomes/customizer
 */

if (!function_exists('inspiry_styles_search_form_customizer')) {

    function inspiry_styles_search_form_customizer(WP_Customize_Manager $wp_customize)
    {
        if ('modern' === INSPIRY_DESIGN_VARIATION) {
            
            $wp_customize->add_section('inspiry_search_form_styles', array(
            'title' => esc_html__('Search Form', 'framework'),
            'panel' => 'inspiry_styles_panel',
        ));


            $wp_customize->add_setting('inspiry_search_form_primary_color', array(
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize,
                'inspiry_search_form_primary_color',
                array(
                    'label' => esc_html__('Primary Color', 'framework'),
                    'section' => 'inspiry_search_form_styles',
                )
            )
            );

            $wp_customize->add_setting('inspiry_search_form_secondary_color', array(
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize,
                'inspiry_search_form_secondary_color',
                array(
                    'label' => esc_html__('Secondary Color', 'framework'),
                    'section' => 'inspiry_search_form_styles',
                )
            )
            );

            $wp_customize->add_setting('inspiry_search_form_active_text', array(
            'type' => 'option',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize,
                'inspiry_search_form_active_text',
                array(
                    'label' => esc_html__('Button & Dropdown Text Color', 'framework'),
                    'section' => 'inspiry_search_form_styles',
                )
            )
            );
        }
    }

    add_action('customize_register', 'inspiry_styles_search_form_customizer');
}
