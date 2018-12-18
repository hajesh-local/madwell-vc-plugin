<?php

/*
Element Description: Madwell VC Full Width Hero
Displays hero background with h1 heading and p subheding
*/
 
// Element Class 
class madFullHero extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'mad_fullhero_mapping' ) );
        add_shortcode( 'mad_fullhero', array( $this, 'mad_fullhero_html' ) );
    }
     
    // Element Mapping
    public function mad_fullhero_mapping() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }                       

        // Map the block with vc_map()
        vc_map( 

            array(
                'name' => __('Full Width Hero', 'madwell-vc-plugin'),
                'base' => 'mad_fullhero',
                'description' => __('Full Width Hero', 'madwell-vc-plugin'),
                'category' => __('Madwell Elements', 'madwell-vc-plugin'),
                'icon' => plugins_url('/../assets/img/mad_fullhero.png', __FILE__),            
                'params' => array(
                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Header Image', 'madwell-elements' ),
                        'param_name'  => 'image',
                        'description' => 'The background image for the hero area',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Mobile Header Image', 'madwell-elements' ),
                        'param_name'  => 'mobile-image',
                        'description' => 'The background image for the hero area on mobile devices',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'textfield',
                        'holder' => 'h1',
                        'heading'     => __( 'Title', 'madwell-elements' ),
                        'param_name'  => 'title',
                        'description' => 'The heading on the hero image',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'textarea_html',
                        'holder' => 'div',
                        'heading'     => __( 'Content', 'madwell-elements' ),
                        'param_name'  => 'content',
                        'description' => 'The subheading of the hero image',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'textfield',
                        'holder' => 'div',
                        'heading'     => __( 'Button URL', 'madwell-elements' ),
                        'param_name'  => 'button_url',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'textfield',
                        'holder' => 'div',
                        'heading'     => __( 'Button Text', 'madwell-elements' ),
                        'param_name'  => 'button_text',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                    array(
                        'type'        => 'textfield',
                        'holder' => 'div',
                        'heading'     => __( 'Custom Class', 'madwell-elements' ),
                        'param_name'  => 'custom_class',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),
                )
            )
        );
    }

     
    // Element HTML
    public function mad_fullhero_html( $atts, $content = null ) {
         
        $data = wp_parse_args( $atts, array(
            'image'         => '',
            'mobile-image'  => '',
            'title'         => '',
            'button_url'    => '',
            'button_text'   => '',
            'custom_class'  => '',
        ) );

        // Grab the images
        $image = wp_get_attachment_image_src( $data['image'], 'full' );
        $mobileImage = wp_get_attachment_image_src( $data['mobile-image'], 'full' );

        // Build our button output
        $button_output = '';
        if ( $data['button_url'] && $data['button_text'] ) {
            $button_output = '<a href="' . esc_url( $data['button_url'] ) . '" class="hero-button">' . esc_html( $data['button_text'] ) . '</a>';
        }

        // Start output
        $output = '';

        // Start section
        $output .= '<section class="hero-container__fullwidth ' . esc_html( $data['custom_class'] ) . '">';

        // Start section with background image if exists
        $output .= '<img class="home-hero__background desktop-only" src="' . esc_url( $image[0] ) . '">';
        $output .= '<img class="home-hero__background desktop-hide" src="' . esc_url( $mobileImage[0] ) . '">';

        // Start content div
        $output .= '<div class="hero-content__fullwidth ' . esc_html( $data['custom_class'] ) . ' wrapper">';

        // Output the title if one exists
        $output .= $data['title'] ? '<h1 class="hero">' . esc_html( $data['title'] ) . '</h1>' : '';

        // Output the content if it exists
        $output .= $content ? apply_filters( 'the_content', $content ) : '';

        // Output the button
        $output .= wp_kses_post( $button_output );

        // Close content div
        $output .= '</div>';

        // Close section
        $output .= '</section>';
        return $output;
    }
     
} // End Element Class
 
// Element Class Init
new madFullHero();