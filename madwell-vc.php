<?php
/*
Plugin Name: Madwell Visual Composer Tweaks
Plugin URI: http://madwell.com
Description: Adjust visual composer elements
Version: 0.9.0
Author: Madwell
Author URI: http://madwell.com
*/

if ( ! class_exists( 'Madwell_VC_Plugin' ) ) :

class Madwell_VC_Plugin {
	
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ) );

	}

	public function init() {

		add_filter( 'vc_shortcodes_css_class', array( $this, 'custom_css_classes' ), 10, 2 );

		// Before VC Init Custom Elements
		add_action( 'vc_before_init', array( $this, 'vc_before_init_actions' ) );

		// Remove unnecessary elements
		add_action( 'vc_after_init', array( $this, 'vc_after_init_actions' ) );

	}

	
	/**
	 * Override class names
	 * 
	 * @param string $class_string name to override class name
	 * @param unknown $tag name of tag to override
	 * @return mixed
	 */
	function custom_css_classes( $class_string, $tag ) {
	
		$class_string = str_replace( array( 'vc_row', 'wpb_row', 'vc_row-fluid', 'wpb_column', 'vc_general'), '', $class_string );
	
		if ( $tag == 'vc_column'|| $tag == 'vc_column_container' ) {
			$class_string = str_replace( 'vc_column_container', '', $class_string );
		}
	
		if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
			$class_string = preg_replace( array( '/-fluid/', '/-has-fill/', '/-inner/' ), 'main', $class_string );
		}
	
		if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
			$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-${1}', $class_string );
		}
	
		if ( $tag == 'vc_btn' ) {
			$class_string = preg_replace( '/vc_btn(\d{1,2})/', 'button', $class_string );
		}
	
		if ( $tag == 'vc_btn' ) {
			$class_string = preg_replace( array( '/-size-md/', '/-shape-rounded/', '/style-modern/', '/-color-grey/'), '', $class_string );
		}

		// Return our classes
		return $class_string;

	}
	
	/**
	 * Load custom VC components
	 */
	function vc_before_init_actions() {
	
		// Link VC elements's folder
		if( function_exists('vc_set_shortcodes_templates_dir') ){
			vc_set_shortcodes_templates_dir( plugin_dir_path(__FILE__) . '/vc_templates' );
		}
	
		// include all custom components
		$dirs = array(
				get_template_directory().'/components/',
				plugin_dir_path(__FILE__).'components/'
		);
		foreach ($dirs as $dir) {
			if (file_exists($dir)) {
				foreach (glob("{$dir}*.php") as $filename) {
					include $filename;
				}
			}
		}
		 
	}

	
	

	function vc_after_init_actions() {
		 
		// Remove VC Elements
		if( function_exists('vc_remove_element') ){
			 
			vc_remove_element( 'vc_accordion' );
			// vc_remove_element( 'vc_basic_grid' );
			vc_remove_element( 'vc_facebook' );
			vc_remove_element( 'vc_flickr' );
			vc_remove_element( 'vc_googleplus' );
			vc_remove_element( 'vc_gmaps link' );
			vc_remove_element( 'vc_icon' );
			vc_remove_element( 'vc_message' );
			vc_remove_element( 'vc_raw_js' );
			// vc_remove_element( 'vc_raw_html' );
			vc_remove_element( 'vc_round_chart' );
			vc_remove_element( 'vc_posts_slider' );
			vc_remove_element( 'vc_masonry_grid' );
			vc_remove_element( 'vc_masonry_media_grid' );
			vc_remove_element( 'vc_line_chart' );
			vc_remove_element( 'vc_text_separator' );
			vc_remove_element( 'vc_media_grid' );
			vc_remove_element( 'vc_pie' );
			vc_remove_element( 'vc_tta_tour' );
			vc_remove_element( 'vc_pie label_value' );
			vc_remove_element( 'vc_progress_bar' );
			vc_remove_element( 'vc_tta_pageable' );
			vc_remove_element( 'vc_tweetmeme' );
			vc_remove_element( 'vc_pinterest' );
			vc_remove_element( 'vc_tabs' );
			vc_remove_element( 'vc_tour' );
			vc_remove_element( 'vc_widget_sidebar' );
			vc_remove_element( 'vc_wp_calendar' );
			vc_remove_element( 'vc_wp_pages' );
			vc_remove_element( 'vc_wp_archives' );
			vc_remove_element( 'vc_wp_categories' );
			vc_remove_element( 'vc_wp_custommenu' );
			vc_remove_element( 'vc_wp_text' );
			vc_remove_element( 'vc_wp_posts' );
			vc_remove_element( 'vc_wp_recentcomments' );
			vc_remove_element( 'vc_wp_search' );
			vc_remove_element( 'vc_wp_meta' );
			vc_remove_element( 'vc_wp_rss' );
			vc_remove_element( 'vc_wp_tagcloud' );

			if ( function_exists( 'mad_remove_other_elements' ) ) {
				/**
				 * Call theme function to override any other VC elements - add to your theme
				*/
				mad_remove_other_elements();
			}
			 
		}
		 
	}
	
}

new Madwell_VC_Plugin();

endif;