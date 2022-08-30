<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    JC_Member_Preferences
 * @subpackage JC_Member_Preferences/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    JC_Member_Preferences
 * @subpackage JC_Member_Preferences/admin
 * @author     Roger Coathup <roger@21applications.com>
 */
class JC_Member_Preferences_Admin {

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
		 * defined in JC_Member_Preferences_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The JC_Member_Preferences_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jc-member-preferences-admin.css', array(), $this->version, 'all' );

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
		 * defined in JC_Member_Preferences_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The JC_Member_Preferences_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jc-member-preferences-admin.js', array( 'jquery' ), $this->version, false );

	}

	
	/**
	 * Undocumented function
	 *
	 * @param [type] $cmb
	 * @return void
	 */
	public function register_options( $cmb, $parent_slug ) {

		$options = new_cmb2_box( [
			'id'         => 'journal_preferences',
			'title' 	=> 'Preferences',
			'object_types'    => [ 'options-page' ],
			'option_key' => $parent_slug . 'preferences',
			'parent_slug' => $parent_slug,
			'tab_group' => $parent_slug,
			'tab_title' => 'Preferences'
		] );

		$options->add_field( [
			'name' => __( 'Show on front end', 'journal-preferences' ),
			'id'  => 'show',
			'type' => 'checkbox'
		]);

		$options->add_field( [
			'name' => __( 'Variation IDs', 'journal-preferences' ),
			'id'  => 'putter_variations',
			'type' => 'title'
		]);		

		$options->add_field( [
			'name' => __( 'Blade black', 'journal-preferences' ),
			'id'  => 'blade_black_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Blade white', 'journal-preferences' ),
			'id'  => 'blade_white_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Blade green', 'journal-preferences' ),
			'id'  => 'blade_green_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Mallet black', 'journal-preferences' ),
			'id'  => 'mallet_black_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Mallet white', 'journal-preferences' ),
			'id'  => 'mallet_white_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Mallet tan', 'journal-preferences' ),
			'id'  => 'mallet_tan_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Square Mallet black', 'journal-preferences' ),
			'id'  => 'square_mallet_black_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Square Mallet white', 'journal-preferences' ),
			'id'  => 'square_mallet_white_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Square Mallet green', 'journal-preferences' ),
			'id'  => 'square_mallet_green_id',
			'type' => 'text_small'
		]);


		$options->add_field( [
			'name' => __( 'Headcover Tan', 'journal-preferences' ),
			'id'  => 'headcover_tan_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Headcover White', 'journal-preferences' ),
			'id'  => 'headcover_white_id',
			'type' => 'text_small'
		]);

		$options->add_field( [
			'name' => __( 'Headcover Black', 'journal-preferences' ),
			'id'  => 'headcover_black_id',
			'type' => 'text_small'
		]);
	}

}
