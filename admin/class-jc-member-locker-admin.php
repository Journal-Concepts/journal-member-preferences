<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    Jc_Member_Locker
 * @subpackage Jc_Member_Locker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jc_Member_Locker
 * @subpackage Jc_Member_Locker/admin
 * @author     Roger Coathup <roger@21applications.com>
 */
class Jc_Member_Locker_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jc_Member_Locker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jc_Member_Locker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jc-member-locker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jc_Member_Locker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jc_Member_Locker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jc-member-locker-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $cmb
	 * @param [type] $parent_slug
	 * @return void
	 */
	public function register_options( $cmb, $parent_slug ) {

		$options = new_cmb2_box( [
			'id'         => 'journal_locker',
			'title' 	=> 'Member Locker',
			'object_types'    => [ 'options-page' ],
			'option_key' => $parent_slug . 'locker',
			'parent_slug' => $parent_slug,
			'tab_group' => $parent_slug,
			'tab_title' => 'Member Locker'
		] );

		$options->add_field( [
			'name' => __( 'Member Locker Name', 'journal-partner-program' ),
			'id' => 'name',
			'type' => 'text',
			'default' => 'Member Locker'
		]);

		$options->add_field( [
			'name' => __( 'Member Locker URL', 'journal-partner-program' ),
			'id' => 'url',
			'type' => 'text',
			'default' => 'member-locker'
		]);
	}

}
