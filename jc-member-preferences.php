<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              21applications.com
 * @since             1.0.0
 * @package           JC_Member_Preferences
 *
 * @wordpress-plugin
 * Plugin Name:       Journal Member Preferences
 * Plugin URI:        git@github.com:rogercoathup/journal-member-preferences.git
 * Description:       Support for member preferences, panel in admin, mallet vs blade selection & redemption, etc.
 * Version:           1.0.0
 * Author:            Roger Coathup
 * Author URI:        21applications.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jc-member-preferences
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JC_MEMBER_PREFERENCES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jc-member-preferences-activator.php
 */
function activate_jc_member_preferences() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-preferences-activator.php';
	JC_Member_Preferences_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jc-member-preferences-deactivator.php
 */
function deactivate_jc_member_preferences() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-preferences-deactivator.php';
	JC_Member_Preferences_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jc_member_preferences' );
register_deactivation_hook( __FILE__, 'deactivate_jc_member_preferences' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-preferences.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jc_member_preferences() {

	$plugin = new JC_Member_Preferences();
	$plugin->run();

}
run_jc_member_preferences();
