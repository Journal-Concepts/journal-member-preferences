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
 * @package           Jc_Member_Locker
 *
 * @wordpress-plugin
 * Plugin Name:       Journal Member Locker
 * Plugin URI:        git@github.com:rogercoathup/journal-member-locker.git
 * Description:       The member locker page in My Account - provides frame for other features to add content, e.g. referrals, partner program
 * Version:           1.0.0
 * Author:            Roger Coathup
 * Author URI:        21applications.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jc-member-locker
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
define( 'JC_MEMBER_LOCKER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jc-member-locker-activator.php
 */
function activate_jc_member_locker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-locker-activator.php';
	Jc_Member_Locker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jc-member-locker-deactivator.php
 */
function deactivate_jc_member_locker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-locker-deactivator.php';
	Jc_Member_Locker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jc_member_locker' );
register_deactivation_hook( __FILE__, 'deactivate_jc_member_locker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jc-member-locker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jc_member_locker() {

	$plugin = new Jc_Member_Locker();
	$plugin->run();

}
run_jc_member_locker();
