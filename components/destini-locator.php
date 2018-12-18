<?php

/*
Element Description: Madwell Destini Store Locator integration
Inserts the Destini install script in desired location on the page
*/
 
// Element Class 
class madDestiniLocator extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'mad_destini_map' ) );
        add_shortcode( 'mad_destini', array( $this, 'mad_destini_html' ) );
    }
     
    // Element Mapping
    public function mad_destini_map() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }                       

        // Map the block with vc_map()
        vc_map( 

            array(
                'name' => __('Destini Store Locator', 'madwell-vc-plugin'),
                'base' => 'mad_destini',
                'description' => __('Destini Integration', 'madwell-vc-plugin'), 
                'category' => __('Madwell Elements', 'madwell-vc-plugin'),   
                'icon' => plugins_url('/../assets/img/mad_fullhero.png', __FILE__),           
                'params' => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __( 'Store ID', 'madwell-elements' ),
                        'param_name'  => 'store_id',
                        'value' => __( '', 'madwell-vc-plugin' ),
                        'description' => '',
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Madwell',
                    ),

                )
            )
        );
    }

     
    // Element HTML
    public function mad_destini_html( $atts, $content = null ) {
         
        $data = wp_parse_args( $atts, array(
            'store_id'    => '',
        ) );

        $zip = '';
        if ( isset($_GET['zip']) && is_numeric($_GET['zip']) ) {
            $zip = '?MM=panel2&ZIP='.esc_attr($_GET['zip']);
            if ( isset($_GET['prodlist']) ) {
                $zip .= '&PROD='.esc_attr($_GET['prodlist']);
            } 
        }

        // Start output
        $output = '';

        // Output install script with store ID
        $output .= '<script src="//destinilocators.com/' . esc_html( $data['store_id'] ) . '/site/install/' . $zip . '"></script>';

        return $output;
    }
     
} // End Element Class
 
// Element Class Init
new madDestiniLocator();