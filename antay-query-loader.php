<?php 

/*
Plugin Name: Antay Query Loader
Description: A wordpress plugin version of QueryLoader2. Read more about it here: https://github.com/Gaya/QueryLoader2
Author: Calvin Canas
Author URI: http://calvincanas.com
License: GPLv2 or later.
Version: 2.0
Text Domain: antay-query-loader
Domain Path: /languages


Special thanks to WordPress Codex, tom mcfarlin, http://mikejolley.com/, http://ottopress.com, https://blog.gaya.ninja - they are my resources for this plugin
*/

defined('ABSPATH') or die(-1);


define('PLUGIN_URL_PATH', plugins_url( '', __FILE__ ) );
define('PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

class Antay_Query_Loader {

	/**
	 * Run all the hooks and other functions after being instantiated.
	 */
	public function __construct() 
	{
		// $this->options = get_option( 'aql_general_options' );
		add_action( 'wp_enqueue_scripts', array( $this, 'aql_front_scripts_and_styles' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'value_to_js' ), 0 );
		add_action( 'admin_enqueue_scripts', array($this, 'aql_add_color_picker' ) );

		if ( is_admin() ) {
			include( 'includes/admin/class-aql-admin.php' );
		}
	}


	/**
	 * Load all the scripts and style
	 */
	public function aql_front_scripts_and_styles()
	{

		wp_enqueue_script( 'aql-queryloader2-script', PLUGIN_URL_PATH . '/assets/js/queryloader2.min.js', array(), false, false  );
	}

	/**
	 * Add the color picker for some settings field we have.
	 */
	function aql_add_color_picker( $hook ) {
	 
	    if( is_admin() ) { 
	     
	        // Add the color picker css file       
	        wp_enqueue_style( 'wp-color-picker' ); 
	         
	        // Include our custom jQuery file with WordPress Color Picker dependency
	        wp_enqueue_script( 'custom-script-handle', PLUGIN_URL_PATH . '/assets/js/admin.js', array( 'wp-color-picker' ), false, true ); 
	    }
	}

	/**
	 * Pass the value we get from the settings page to javascript
	 * Thanks to wp_localize_script and ottopress
	 */
	function value_to_js() {

		// init and set the variable
		$aql_switch = ( get_option( 'aql_switch' ) !== '' ) ? 'true' : 'false';
		$aql_percentage = ( get_option( 'aql_use_percentage' ) !== '' ) ? 'true' : 'false';
		$bar_color = ( get_option( 'aql_bar_color' ) == '' ) ? '#fff': get_option( 'aql_bar_color' ); 
		$background_color = ( get_option( 'aql_bg_color' ) == '' ) ? '#000': get_option( 'aql_bg_color' );
		$bar_height	= ( get_option( 'aql_bar_height' ) == '' ) ? '10': get_option( 'aql_bar_height' );
		$min_time	= ( get_option( 'aql_minimum_time' ) == '' ) ? '1000': get_option( 'aql_minimum_time' );
		$fadeout_time	= ( get_option( 'aql_fadeout_time' ) == '' ) ? '1000': get_option( 'aql_fadeout_time' );

		$params = array(
			'switch'				=>		$aql_switch,
			'percentage'			=>		$aql_percentage,
			'barColor'				=>		$bar_color,
			'backgroundColor'		=>		$background_color,
			'barHeight'				=>		$bar_height,
			'minimumTime'			=>		$min_time,
			'fadeOutTime'			=>		$fadeout_time,
		);

		// register the script
		wp_register_script( 'aql-main-script', PLUGIN_URL_PATH . '/assets/js/main.js' );

		wp_localize_script( 'aql-main-script', 'AqlObject', $params );

		wp_enqueue_script( 'aql-main-script' );
	}


}

// run the plugin.
return new Antay_Query_Loader();

