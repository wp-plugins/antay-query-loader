<?php 

/*
Plugin Name: Antay Query Loader
Description: Create a loading page that will run until your website and it's assets( images, files, etc ) successfully loaded.
Author: Calvin Canas
Author URI: http://calvincanas.com
License: GPLv2 or later.
Version: 1.0

*/

defined('ABSPATH') or die(-1);


define('PLUGIN_ROOT_PATH', plugins_url( '', __FILE__ ) );

class Antay_Query_Loader {

	/* 
	 * will hold the value we get from our options 
	 */
	public $options;

	/**
	 * Run all the hooks and other functions after being instantiated.
	 */
	public function __construct() 
	{
		$this->options = get_option( 'ulp_general_options' );
		add_action( 'admin_menu', array( $this, 'ulp_settings_page' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ulp_front_scripts_and_styles' ), 0 );
		add_action( 'admin_init', array( $this, 'ulp_settings_page_settings_and_field' ) );

	}

	/**
	 * Load all the scripts and css will be using to show to our users
	 */
	public function ulp_front_scripts_and_styles()
	{

		if( isset( $this->options['ulp_switch']) && $this->options['ulp_switch'] == true ) {
			wp_enqueue_script( 'ulp-front-jquery-loader-script', PLUGIN_ROOT_PATH . '/assets/js/queryloader2.min.js', array(), false, false  );
			wp_enqueue_script( 'ulp-front-main-script', PLUGIN_ROOT_PATH. '/assets/js/main.js', array(), false );
		}
	}


	/**
	 * Add a custom settings page for our plugin.
	 */
	public function ulp_settings_page()
	{
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position ); 

		add_menu_page( 'Antay Query Loader', 'Antay Query Loader', 'manage_options', 'ulp_page_name', array($this, 'ulp_settings_page_function') );
	}

	/**
	 * This will output the settings page of our plugin
	 */
	public function ulp_settings_page_function()
	{

		?>
		<div class="wrap">
			<h2><?php _e('Settings') ?></h2>

			<form action="options.php" method="post">

				<?php settings_errors(); ?>
				<?php settings_fields( 'ulp_page_name' ) ?>

				<?php do_settings_sections( 'ulp_page_name' ) ?>

				<?php submit_button(); ?>

			</form>
		</div>
		<?php
	}

	/**
	 * We will register settings here and our custom fields and sections
	 */
	public function ulp_settings_page_settings_and_field()
	{

		add_settings_section(
			'ulp_general_section',
			__('General Settings'),
			array( $this, 'ulp_general_section_callback' ),
			'ulp_page_name'
		);

		add_settings_field(
			'ulp_switch',
			__('Enable Antay Query Loader'),
			array( $this, 'ulp_switch_field'),
			'ulp_page_name',
			'ulp_general_section'
		);

		register_setting( 
			'ulp_page_name',
			'ulp_general_options'
		);
	}

	/**
	 * ULP General Section Callback Function
	 */
	public function ulp_general_section_callback()
	{
		//TODO - leave blank for now
	}

	/**
	 * Ouput the input field for ulp_switch
	 */
	public function ulp_switch_field()
	{

		if( !isset($this->options['ulp_switch']) ) {
			$this->options['ulp_switch'] = false;
		}
		
		echo '<input type="checkbox" name="ulp_general_options[ulp_switch]" id="ulp-switch" value="1" ' . checked( $this->options['ulp_switch'], 1, false ) . '/>';
	}

	

}

// run the plugin.
new Antay_Query_Loader();

