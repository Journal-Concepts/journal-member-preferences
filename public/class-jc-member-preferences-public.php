<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    JC_Member_Preferences
 * @subpackage JC_Member_Preferences/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    JC_Member_Preferences
 * @subpackage JC_Member_Preferences/public
 * @author     Roger Coathup <roger@21applications.com>
 */
class JC_Member_Preferences_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_register_style( 'journal-member-preferences-public', plugin_dir_url( __FILE__ ) . 'css/jc-member-preferences-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$protocol = isset( $_SERVER["HTTPS"]) ? 'https://' : 'http://';

		/**
		 * Our general public js
		 * @var array
		 */
		$params = array(
			'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
		);


		wp_register_script( 'journal-member-preferences-public', plugin_dir_url( __FILE__ ) . 'js/jc-member-preferences-public.js' );
		wp_localize_script( 'journal-member-preferences-public', 'jc_member_preferences' , $params );
	}

}
