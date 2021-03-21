<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    Jc_Member_Locker
 * @subpackage Jc_Member_Locker/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Jc_Member_Locker
 * @subpackage Jc_Member_Locker/includes
 * @author     Roger Coathup <roger@21applications.com>
 */
class Jc_Member_Locker_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'jc-member-locker',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
